<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['user_id'];
        header("Location: first main.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Fine System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== GLOBAL STYLES ===== */
        :root {
            --primary: #0e3c82;
            --secondary: #4CAF50;
            --accent: #3498db;
            --dark: #2c3e50;
            --light: #f8f9fa;
            --text: #333;
            --text-light: #6c757d;
            --error: #f44336;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('./background.jpg');
            background-size: cover;
            background-position: center;
        }

        /* ===== LOGIN CONTAINER ===== */
        .login-container {
            width: 100%;
            max-width: 450px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .logo {
            width: 80px;
            margin-bottom: 20px;
            filter: brightness(0) invert(0);
        }

        h1 {
            color: var(--primary);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .subtitle {
            color: var(--text-light);
            font-size: 16px;
            margin-bottom: 30px;
            font-weight: 400;
        }

        /* ===== FORM STYLES ===== */
        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary);
            font-weight: 500;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px 14px 45px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: #fff;
        }

        .form-group input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(14, 60, 130, 0.1);
        }

        .error-message {
            color: var(--error);
            font-size: 14px;
            margin-top: 5px;
            text-align: center;
        }

        /* ===== BUTTON STYLES ===== */
        .btn {
            display: inline-block;
            padding: 14px 25px;
            background-color: var(--secondary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .btn:hover {
            background-color: #3e8e41;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* ===== LINKS ===== */
        .forgot-password {
            display: block;
            text-align: right;
            margin-top: 10px;
            color: var(--primary);
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        .signup-link {
            margin-top: 20px;
            color: var(--text-light);
            font-size: 15px;
        }

        .signup-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .signup-link a:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 576px) {
            .login-container {
                padding: 30px 20px;
                margin: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="./logo.png" alt="E-fine Logo" class="logo">
        <h1>Login</h1>
        <p class="subtitle">Access your E-Fine account to manage your traffic fines</p>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <a href="forgot-password.php" class="forgot-password">Forgot password?</a>
            </div>

            <button type="submit" class="btn">LOGIN</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="sign in.php">Sign up</a>
        </div>
    </div>

    <script>
        // Simple client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (!email || !password) {
                e.preventDefault();
                const errorDiv = document.querySelector('.error-message') || document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.textContent = 'Please fill in all fields';
                
                if (!document.querySelector('.error-message')) {
                    document.querySelector('.subtitle').after(errorDiv);
                }
            }
        });
    </script>
</body>
</html-->