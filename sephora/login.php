<?php
// login.php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mfa_code = $_POST['mfa_code'];

    try {
        // Check if the user exists
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check lockout status
            $lockoutStmt = $pdo->prepare("SELECT failed_attempts, locked_until FROM FailedLogins WHERE user_id = ?");
            $lockoutStmt->execute([$user['id']]);
            $lockout = $lockoutStmt->fetch(PDO::FETCH_ASSOC);

            if ($lockout && $lockout['locked_until'] && strtotime($lockout['locked_until']) > time()) {
                echo "Account locked. Try again later.";
                exit;
            }

            // Verify password
            if (password_verify($password, $user['password_hash'])) {
                // Simulate MFA verification
                if ($mfa_code == '123456') { // Replace with actual MFA verification logic
                    echo "Login successful!";
                    
                    // Reset failed attempts
                    $pdo->prepare("UPDATE FailedLogins SET failed_attempts = 0, locked_until = NULL WHERE user_id = ?")
                        ->execute([$user['id']]);
                } else {
                    echo "Invalid MFA code.";
                }
            } else {
                // Increment failed login attempts
                if (!$lockout) {
                    $pdo->prepare("INSERT INTO FailedLogins (user_id, failed_attempts) VALUES (?, 1)")
                        ->execute([$user['id']]);
                } else {
                    $newAttempts = $lockout['failed_attempts'] + 1;
                    $lockedUntil = null;

                    if ($newAttempts >= 3) {
                        $lockedUntil = date("Y-m-d H:i:s", strtotime("+30 minutes"));
                        echo "Account locked due to repeated failed attempts.";
                    } else {
                        echo "Invalid username or password.";
                    }

                    $pdo->prepare("UPDATE FailedLogins SET failed_attempts = ?, locked_until = ? WHERE user_id = ?")
                        ->execute([$newAttempts, $lockedUntil, $user['id']]);
                }
            }
        } else {
            echo "User not found.";
        }
    } catch (PDOException $e) {
        echo "Login failed: " . $e->getMessage();
    }
}
?>
