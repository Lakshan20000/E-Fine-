<?php
require_once 'db.php';

header('Content-Type: application/json');

if (isset($_GET['licenseNo'])) {
    $licenseNo = $_GET['licenseNo'];
    
    $stmt = $pdo->prepare("SELECT full_name, license_type FROM license_holders WHERE license_id = ?");
    $stmt->execute([$licenseNo]);
    $license = $stmt->fetch();
    
    if ($license) {
        echo json_encode([
            'success' => true,
            'name' => $license['full_name'],
            'type' => $license['license_type']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No license number provided']);
}
?>