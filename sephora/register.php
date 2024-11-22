<?php
// register.php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $mfa_method = $_POST['mfa'];

    try {
        $stmt = $pdo->prepare("INSERT INTO Users (username, email, password_hash, mfa_method) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $mfa_method]);
        echo "Registration successful. You can now log in.";
    } catch (PDOException $e) {
        echo "Registration failed: " . $e->getMessage();
    }
}
?>
