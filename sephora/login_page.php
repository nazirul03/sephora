<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sephora-themed Register and Login Page with MFA and Account Lockout Features">
    <title>Sephora - Secure Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }
        header {
            background-color: #000;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        .container {
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #d7322c;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="submit"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #d7322c;
            color: #fff;
            cursor: pointer;
            border: none;
        }
        input[type="submit"]:hover {
            background-color: #b62923;
        }
        p {
            text-align: center;
        }
        a {
            color: #d7322c;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Sephora</h1>
    </header>

    <div class="container">
        <h1>Register</h1>
        <form action="register.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    
    <label for="mfa">Preferred MFA Method:</label>
    <select id="mfa" name="mfa" required>
        <option value="email">Email</option>
        <option value="sms">SMS</option>
    </select>
    
    <button type="submit">Register</button>
</form>

        <p>Already have an account? <a href="#login">Log in</a></p>
    </div>

    <div class="container" id="login">
        <h1>Login</h1>
        <form action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    
    <label for="mfa_code">MFA Code:</label>
    <input type="text" id="mfa_code" name="mfa_code" required>
    
    <button type="submit">Login</button>
</form>

        <p>Don't have an account? <a href="#registerForm">Register</a></p>
    </div>

    <script>
        const lockoutMessage = document.getElementById('lockoutMessage');
        let failedAttempts = 0;
        const maxAttempts = 3;
        const lockoutDuration = 30000; // 30 seconds

        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();

            if (failedAttempts >= maxAttempts) {
                lockoutMessage.style.display = 'block';
                return;
            }

            const username = document.getElementById('loginUsername').value;
            const password = document.getElementById('loginPassword').value;
            const mfaCode = document.getElementById('loginMfa').value;

            // Simulate login validation (replace with server-side validation)
            if (username !== 'user' || password !== 'password' || mfaCode !== '123456') {
                failedAttempts++;
                alert('Invalid credentials or MFA code.');
                if (failedAttempts >= maxAttempts) {
                    lockoutMessage.style.display = 'block';
                    setTimeout(() => {
                        failedAttempts = 0;
                        lockoutMessage.style.display = 'none';
                    }, lockoutDuration);
                }
            } else {
                alert('Login successful!');
                failedAttempts = 0;
            }
        });
    </script>
</body>
</html>
