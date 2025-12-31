<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;

             margin: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: url(./background.jpg);
                width: 100%;
                height: 100vh;
                background-size: cover;
                background-repeat: repeat;
        }
        
        header {
            background-color: #0e3c82;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            height: 50px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 20px;
        }
        
        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s;
        }
        
        nav ul li a:hover {
            color: #4CAF50;
        }
        
        .contact-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .contact-container h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
            font-size: 28px;
        }
        
        .contact-info {
            margin-top: 30px;
        }
        
        .contact-info p {
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .contact-info a {
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .contact-info a:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .contact-icon {
            margin-right: 15px;
            color: #4CAF50;
            font-size: 20px;
            min-width: 20px;
        }
        
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 180px;
        }
        
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                padding: 15px;
            }
            
            nav ul {
                margin-top: 15px;
            }
            
            nav ul li {
                margin-left: 10px;
                margin-right: 10px;
            }
            
            .contact-container {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header>
        <img src="./logo.png" alt="E-fine Logo" class="logo">
        <section>
        <nav>
            <ul>
                
                  <li><a href="lo.php">Home</a></li>
                <li><a href="about us.php">About Us</a></li>
                <li><a href="contact us.php">Contact Us</a></li>
            </ul>
        </nav></section>
    </header>
    
    <div class="contact-container">
        <h1>Contact Us</h1>
        <div class="contact-info">
            <p>If you require any assistance or have inquiries regarding traffic fines or online payments, please contact:</p>
            
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <strong>E-Fine Support Unit – Department of Traffic Police</strong><br>
                    Traffic Division, Police Headquarters, No. 10, Colombo 01, Sri Lanka
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div>
                    <strong>Phone:</strong> <a href="tel:+94112345678">+94 11 2345678</a>
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <strong>Email:</strong> <a href="mailto:info@efine.gov.lk">info@efine.gov.lk</a>
                </div>
            </div>
            
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div>
                    <strong>Website:</strong> <a href="http://www.efine.gov.lk" target="_blank">www.efine.gov.lk</a>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        &copy;  E-Fine System - Department of Traffic Police. All Rights Reserved.
    </footer>
</body>
</html>