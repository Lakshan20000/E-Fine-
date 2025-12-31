<?php
require_once 'db.php';
session_start();

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

try {
    // Begin transaction
    $pdo->beginTransaction();
    
    // Generate receipt number
    $receiptNo = 'RCPT-' . strtoupper(uniqid());
    
    // Get station ID
    $stmt = $pdo->prepare("SELECT station_id FROM police_stations WHERE station_name = ?");
    $stmt->execute([$data['policeStation']]);
    $station = $stmt->fetch();
    
    if (!$station) {
        throw new Exception("Invalid police station");
    }
    
    // Insert fine record
    $stmt = $pdo->prepare("
        INSERT INTO fines (
            license_id, 
            fine_code, 
            vehicle_no, 
            station_id, 
            imposed_date, 
            payment_date, 
            amount, 
            status, 
            receipt_no
        ) VALUES (?, ?, ?, ?, ?, ?, ?, 'paid', ?)
    ");
    
    $stmt->execute([
        $data['licenseNo'],
        $data['fineCode'],
        $data['vehicleNo'],
        $station['station_id'],
        $data['fineDate'],
        $data['paymentDate'],
        $data['fineAmount'],
        $receiptNo
    ]);
    
    // Commit transaction
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'receipt_no' => $receiptNo
    ]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>