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

// Generate PDF content
require_once 'vendor/autoload.php'; // You'll need to install dompdf via composer 
$html = '
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

// Generate PDF
$dompdf = new Dompdf\Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output the generated PDF
$dompdf->stream('receipt_'.$payment['receipt_no'].'.pdf', [
    'Attachment' => true
]);
?>