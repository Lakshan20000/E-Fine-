<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            /*align-items: center;*/
            background-image: url(./background.jpg);
                width: 100%;
                height: 100vh;
                background-size: cover;
                background-repeat: repeat;
        }
        
        header {
            background-color: #0e3c82;
            padding: 5px 30px;
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
            color: white;
            font-weight: bold;
            transition: color 0.1s;
    
        }
        
        nav ul li a:hover {
            color: #4CAF50;
        }
        
        .about-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .about-container h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
            font-size: 28px;
        }
        
        .about-content {
            margin-top: 20px;
        }
        
        .about-content p {
            margin-bottom: 20px;
            font-size: 16px;
        }
        
        .features {
            margin: 25px 0;
            padding-left: 20px;
        }
        
        .features li {
            margin-bottom: 15px;
            position: relative;
            padding-left: 30px;
        }
        
        .features li:before {
            content: "✓";
            color: #4CAF50;
            position: absolute;
            left: 0;
            font-weight: bold;
        }
        
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
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
            
            .about-container {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="./logo.png" alt="E-fine Logo" class="logo">
        <nav>
            <ul>
                
                 <li><a href="lo.php">Home</a></li>
                <li><a href="about us.php">About Us</a></li>
                <li><a href="contact us.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    
    <div class="about-container">
        <h1>About Us</h1>
        <div class="about-content">
            <p>E-Fine Sri Lanka is a digital traffic fine management system developed to modernize and streamline the process of issuing and settling traffic violation fines across the country. This web-based application allows drivers to:</p>
            
            <ul class="features">
                <li>Instantly check traffic fines using their National Driving License Number (NDL)</li>
                <li>Make secure online payments without visiting police stations or post offices</li>
                <li>Receive digital receipts and confirmation of payment</li>
                <li>View their traffic violation history and license status online</li>
            </ul>
            
            <p>The system is designed to support the Sri Lanka Traffic Police Department in reducing paperwork, improving fine collection efficiency, and enhancing citizen convenience.</p>
        </div>
    </div>
    
    <footer>
        &copy; E-Fine System - Department of Traffic Police. All Rights Reserved.
    </footer>
</body>
</html>