<?php
require_once 'db.php';
session_start();

// Check if receipt number is provided
if (!isset($_GET['receipt'])) {
    header("Location: first main.php");
    exit();
}

$receiptNo = $_GET['receipt'];

// Fetch payment details
$stmt = $pdo->prepare("
    SELECT f.*, lh.full_name, ft.description AS fine_description
    FROM fines f
    JOIN license_holders lh ON f.license_id = lh.license_id
    JOIN fine_types ft ON f.fine_code = ft.fine_code
    WHERE f.receipt_no = ?
");
$stmt->execute([$receiptNo]);
$payment = $stmt->fetch();

if (!$payment) {
    header("Location: first main.php?error=invalid_receipt");
    exit();
}

// Generate HTML content for PDF
$receipt_html = '
<!DOCTYPE html>
<html>
<head>
    <title>Receipt - '.$payment['receipt_no'].'</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #0e3c82; }
        .receipt-details { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .receipt-details th { background-color: #f5f5f5; text-align: left; padding: 8px; }
        .receipt-details td { padding: 8px; border-bottom: 1px solid #ddd; }
        .total { font-weight: bold; font-size: 1.2em; text-align: right; margin-top: 20px; }
        .footer { margin-top: 30px; text-align: center; font-size: 0.9em; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>E-Fine Payment Receipt</h1>
        <p>Department of Traffic Police</p>
    </div>
    
    <table class="receipt-details">
        <tr>
            <th>Receipt No:</th>
            <td>'.$payment['receipt_no'].'</td>
        </tr>
        <tr>
            <th>License No:</th>
            <td>'.$payment['license_id'].'</td>
        </tr>
        <tr>
            <th>License Holder:</th>
            <td>'.$payment['full_name'].'</td>
        </tr>
        <tr>
            <th>Fine Date:</th>
            <td>'.$payment['imposed_date'].'</td>
        </tr>
        <tr>
            <th>Payment Date:</th>
            <td>'.$payment['payment_date'].'</td>
        </tr>
        <tr>
            <th>Fine Code:</th>
            <td>'.$payment['fine_code'].'</td>
        </tr>
        <tr>
            <th>Reason:</th>
            <td>'.$payment['fine_description'].'</td>
        </tr>
        <tr>
            <th>Vehicle No:</th>
            <td>'.$payment['vehicle_no'].'</td>
        </tr>
    </table>
    
    <div class="total">
        Total Amount: LKR '.number_format($payment['amount'], 2).'
    </div>
    
    <div class="footer">
        <p>Thank you for using E-Fine System</p>
        <p>This is an official receipt</p>
    </div>
</body>
</html>
';

// Store HTML in session for PDF generation
$_SESSION['receipt_html'] = $receipt_html;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment Successful</title>
    <style>
        .success-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .success-icon {
            color: #4CAF50;
            font-size: 60px;
            margin-bottom: 20px;
        }
        
        .success-container h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .receipt-details {
            text-align: left;
            margin: 30px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 20px 0;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .detail-label {
            font-weight: bold;
            color: #555;
        }
        
        .detail-value {
            color: #333;
        }
        
        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin: 20px 0;
        }
        
        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-print {
            background-color: #3498db;
            color: white;
        }
        
        .btn-print:hover {
            background-color: #2980b9;
        }
        
        .btn-download {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-download:hover {
            background-color: #3e8e41;
        }
        
        .btn-close {
            background-color: #f44336;
            color: white;
        }
        
        .btn-close:hover {
            background-color: #d32f2f;
        }
        
        @media (max-width: 768px) {
            .success-container {
                margin: 20px;
                padding: 20px;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h2>Payment Successful</h2>
        
        <div class="receipt-details">
            <div class="detail-row">
                <span class="detail-label">Receipt No:</span>
                <span class="detail-value"><?php echo htmlspecialchars($payment['receipt_no']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Driving Licence No:</span>
                <span class="detail-value"><?php echo htmlspecialchars($payment['license_id']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Licence Holder Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($payment['full_name']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date of fine imposed:</span>
                <span class="detail-value"><?php echo htmlspecialchars($payment['imposed_date']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Fine Code No:</span>
                <span class="detail-value"><?php echo htmlspecialchars($payment['fine_code']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Reason for Fine:</span>
                <span class="detail-value"><?php echo htmlspecialchars($payment['fine_description']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Vehicle No:</span>
                <span class="detail-value"><?php echo htmlspecialchars($payment['vehicle_no']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date of payment of fine:</span>
                <span class="detail-value"><?php echo htmlspecialchars($payment['payment_date']); ?></span>
            </div>
        </div>
        
        <div class="total-amount">
            Total amount: <span>LKR <?php echo number_format($payment['amount'], 2); ?></span>
        </div>
        
        <div class="button-group">
            <button class="btn btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> Print Receipt
            </button>
            <a href="download_receipt.php?receipt=<?php echo urlencode($payment['receipt_no']); ?>" class="btn btn-download">
                <i class="fas fa-download"></i> Download Receipt
            </a>
            <button class="btn btn-close" onclick="window.location.href='lo.php'">
                <i class="fas fa-times"></i> Close
            </button>
        </div>
    </div>
</body>
</html>