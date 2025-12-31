<?php
require_once 'db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: lo.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment Details</title>
     <!--link rel="stylesheet" href="styles1.css"-->
    <style>
       /* nav ul {
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
        }*/
        body {
             background-image: url(./background.jpg);
        }
        
        .payment-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .payment-container h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        
        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus, 
        .form-group select:focus {
            border-color: #4CAF50;
            outline: none;
        }
        
        .card-type {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        
        .card-option {
            display: flex;
            align-items: center;
        }
        
        .card-option input {
            margin-right: 8px;
        }
        
        .expiry-date {
            display: flex;
            gap: 15px;
        }
        
        .expiry-date select {
            flex: 1;
        }
        
        .cvv-info {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        
        .divider {
            height: 1px;
            background-color: #eee;
            margin: 30px 0;
        }
        
        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }
        
        .btn {
            padding: 14px 25px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-cancel {
            background-color: #f44336;
            color: white;
        }
        
        .btn-cancel:hover {
            background-color: #d32f2f;
        }
        
        .btn-pay {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-pay:hover {
            background-color: #388e3c;
        }
        
        .required:after {
            content: " *";
            color: red;
        }
        
        .card-number {
            letter-spacing: 1px;
            font-family: monospace;
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
            
            .payment-container {
                margin: 20px;
                padding: 20px;
            }
            
            .card-type {
                flex-direction: column;
                gap: 10px;
            }
            
            .button-group {
                flex-direction: column;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header>
        <!--img src="./logo.png" alt="E-fine Logo" class="logo"-->
        <!--nav>
            <ul>
                <li><a href="lo.php">Home</a></li>
                <li><a href="about us.php">About Us</a></li>
                <li><a href="contact us.php">Contact Us</a></li>
            </ul>
        </nav-->
    </header>
    
    <div class="payment-container">
        <h2>Payment Details</h2>
        
        <div class="form-group">
            <label class="required">Card Type</label>
            <div class="card-type">
                <div class="card-option">
                    <input type="radio" id="visa" name="cardType" value="visa" checked>
                    <label for="visa"><i class="fab fa-cc-visa" style="font-size: 24px; color: #1a1a71;"></i> Visa</label>
                </div>
                <div class="card-option">
                    <input type="radio" id="mastercard" name="cardType" value="mastercard">
                    <label for="mastercard"><i class="fab fa-cc-mastercard" style="font-size: 24px; color: #eb001b;"></i> Mastercard</label>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="required">Card Number</label>
            <input type="text" id="cardNumber" class="card-number" placeholder="xxxx xxxx xxxx xxxx" maxlength="19">
        </div>
        
        <div class="form-group">
            <label class="required">Expiration Date</label>
            <div class="expiry-date">
                <select id="expMonth" required>
                    <option value="">Month</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
                <select id="expYear" required>
                    <option value="">Year</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="required">CVN</label>
            <input type="text" id="cvn" placeholder="xxx" maxlength="4">
            <div class="cvv-info">
                This is a three or four digit number printed on the back or front of your credit card.
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="button-group">
            <button class="btn btn-cancel" id="cancelBtn">
                <i class="fas fa-times"></i> Cancel
            </button>
            <button class="btn btn-pay" id="payBtn">
                <i class="fas fa-lock"></i> Pay Now
            </button>
        </div>
    </div>

    <script>
        // Format card number with spaces
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = this.value.replace(/\s+/g, ''); // Remove all spaces
            if (value.length > 0) {
                value = value.match(new RegExp('.{1,4}', 'g')).join(' '); // Add space every 4 chars
            }
            this.value = value;
        });

        // Cancel button - go back to previous page
        document.getElementById('cancelBtn').addEventListener('click', function() {
            window.history.back();
        });

        // Pay button - validate and proceed to payment success
        document.getElementById('payBtn').addEventListener('click', function() {
            // Validate all fields
            const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
            const expMonth = document.getElementById('expMonth').value;
            const expYear = document.getElementById('expYear').value;
            const cvn = document.getElementById('cvn').value;
            
            if (!cardNumber || cardNumber.length < 16) {
                alert('Please enter a valid 16-digit card number');
                return;
            }
            
            if (!expMonth) {
                alert('Please select expiration month');
                return;
            }
            
            if (!expYear) {
                alert('Please select expiration year');
                return;
            }
            
            if (!cvn || (cvn.length !== 3 && cvn.length !== 4)) {
                alert('Please enter a valid 3 or 4 digit CVN');
                return;
            }
            
            // Check if card is expired
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth() + 1; // Months are 0-indexed
            
            if (parseInt(expYear) < currentYear || 
                (parseInt(expYear) === currentYear && parseInt(expMonth) < currentMonth)) {
                alert('This card has expired');
                return;
            }
            
            // Get payment data from session storage
            const paymentData = JSON.parse(sessionStorage.getItem('paymentData'));
            
            if (!paymentData) {
                alert('Payment data not found. Please start over.');
                window.location.href = 'first main.php';
                return;
            }
            
            // Submit payment data to server
            fetch('process_payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    ...paymentData,
                    cardType: document.querySelector('input[name="cardType"]:checked').value,
                    cardLastFour: cardNumber.slice(-4)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'done.php?receipt=' + encodeURIComponent(data.receipt_no);
                } else {
                    alert('Payment failed: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Payment processing failed. Please try again.');
            });
        });
    </script>
</body>
</html>