<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $email, $password]);
        
        header("Location: first main.php");
        exit();
    } catch (PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up - E-Fine System</title>
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

        /* ===== SIGNUP CONTAINER ===== */
        .signup-container {
            width: 100%;
            max-width: 500px;
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
            margin-bottom: 20px;
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

        .name-fields {
            display: flex;
            gap: 15px;
        }

        .name-fields .form-group {
            flex: 1;
        }

        .error-message {
            color: var(--error);
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .password-strength {
            height: 4px;
            background-color: #e0e0e0;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            background-color: var(--error);
            transition: width 0.3s, background-color 0.3s;
        }

        /* ===== TERMS CHECKBOX ===== */
        .terms-check {
            display: flex;
            align-items: flex-start;
            margin: 25px 0;
        }

        .terms-check input {
            margin-right: 10px;
            margin-top: 3px;
        }

        .terms-check label {
            font-size: 14px;
            color: var(--text);
            text-align: left;
        }

        .terms-check a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .terms-check a:hover {
            text-decoration: underline;
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

        /* ===== LOGIN LINK ===== */
        .login-link {
            margin-top: 20px;
            color: var(--text-light);
            font-size: 15px;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 576px) {
            .signup-container {
                padding: 30px 20px;
                margin: 20px;
            }

            h1 {
                font-size: 24px;
            }

            .name-fields {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <img src="./logo.png" alt="E-fine Logo" class="logo">
        <h1>Create Account</h1>
        <p class="subtitle">Register to manage your traffic fines online</p>

        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px; text-align: center;"><?php echo $error; ?></div>
        <?php endif; ?>

        <form id="signupForm" method="POST">
            <div class="name-fields">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
                    </div>
                    <div class="error-message" id="firstNameError"></div>
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
                    </div>
                    <div class="error-message" id="lastNameError"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="error-message" id="emailError"></div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>
                <div class="password-strength">
                    <div class="password-strength-bar" id="passwordStrength"></div>
                </div>
                <div class="error-message" id="passwordError"></div>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                </div>
                <div class="error-message" id="confirmPasswordError"></div>
            </div>

            <div class="terms-check">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the <a href="terms.html">Terms of Service</a> and <a href="privacy.html">Privacy Policy</a></label>
            </div>

            <button type="submit" class="btn">CREATE ACCOUNT</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="lo.php">Log in</a>
        </div>
    </div>

    <script>
        // Password strength indicator
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthBar = document.getElementById('passwordStrength');
            let strength = 0;
            
            // Length check
            if (password.length > 7) strength += 1;
            if (password.length > 11) strength += 1;
            
            // Character variety checks
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            // Update strength bar
            const width = strength * 20;
            strengthBar.style.width = width + '%';
            
            // Update color based on strength
            if (width < 40) {
                strengthBar.style.backgroundColor = 'var(--error)';
            } else if (width < 80) {
                strengthBar.style.backgroundColor = '#ff9800';
            } else {
                strengthBar.style.backgroundColor = 'var(--secondary)';
            }
        });

        // Form validation
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => {
                el.style.display = 'none';
                el.textContent = '';
            });
            
            // Validate first name
            const firstName = document.getElementById('firstName').value.trim();
            if (firstName.length < 2) {
                showError('firstNameError', 'First name must be at least 2 characters');
                isValid = false;
            }
            
            // Validate last name
            const lastName = document.getElementById('lastName').value.trim();
            if (lastName.length < 2) {
                showError('lastNameError', 'Last name must be at least 2 characters');
                isValid = false;
            }
            
            // Validate email
            const email = document.getElementById('email').value.trim();
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showError('emailError', 'Please enter a valid email address');
                isValid = false;
            }
            
            // Validate password
            const password = document.getElementById('password').value;
            if (password.length < 8) {
                showError('passwordError', 'Password must be at least 8 characters');
                isValid = false;
            }
            
            // Validate password match
            const confirmPassword = document.getElementById('confirmPassword').value;
            if (password !== confirmPassword) {
                showError('confirmPasswordError', 'Passwords do not match');
                isValid = false;
            }
            
            // Validate terms checkbox
            if (!document.getElementById('terms').checked) {
                alert('You must agree to the terms and conditions');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });

        function showError(elementId, message) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.style.display = 'block';
        }
    </script>
</body>
</html>