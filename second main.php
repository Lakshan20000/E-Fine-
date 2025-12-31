<?php
require_once 'db.php';
session_start();

// Check if license number is provided
if (!isset($_GET['licenseNo'])) {
    header("Location: first main.php");
    exit();
}

$licenseNo = $_GET['licenseNo'];

// Fetch license holder details
$stmt = $pdo->prepare("SELECT full_name FROM license_holders WHERE license_id = ?");
$stmt->execute([$licenseNo]);
$licenseHolder = $stmt->fetch();

if (!$licenseHolder) {
    header("Location: first main.php?error=invalid_license");
    exit();
}

// Fetch fine types
$fineTypes = $pdo->query("SELECT * FROM fine_types")->fetchAll();

// Fetch police stations
$policeStations = $pdo->query("SELECT station_name FROM police_stations")->fetchAll(PDO::FETCH_COLUMN);
?>

<DOCTYPE html>
<html lang="en">
<head>
    <title>Fine Payment System</title>
    <link rel="stylesheet" href="styles1.css">
    <style>
        
    
        .fine-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .fine-container h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
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
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .form-group input:read-only {
            background-color: #f5f5f5;
        }
        
        .divider {
            height: 1px;
            background-color: #ddd;
            margin: 20px 0;
        }
        
        .btn {
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        
        .btn:hover {
            background-color: #45a049;
        }
        
        .autocomplete {
            position: relative;
        }
        
        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }
        
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

    </style>
</head>
<body>
    
    <div class="fine-container">
        <h2>Fine Code No</h2>
        
        <div class="form-group">
            <label for="fineCode">Select Fine Code</label>
            <select id="fineCode">
                <option value="">-- Select a fine code --</option>
                <?php foreach ($fineTypes as $fine): ?>
                    <option value="<?php echo htmlspecialchars($fine['fine_code']); ?>">
                        <?php echo htmlspecialchars($fine['fine_code']); ?> 
                                        </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="licenseNo">Driving License No</label>
            <input type="text" id="licenseNo" value="<?php echo htmlspecialchars($licenseNo); ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="holderName">License Holder Name</label>
            <input type="text" id="holderName" value="<?php echo htmlspecialchars($licenseHolder['full_name']); ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="reason">Reason for fine</label>
            <input type="text" id="reason" readonly>
        </div>
        
        <div class="form-group">
            <label for="vehicleNo">Vehicle No</label>
            <input type="text" id="vehicleNo" placeholder="Enter vehicle number">
        </div>
        
        <div class="form-group">
            <label for="fineDate">Date of fine imposed</label>
            <input type="date" id="fineDate">
        </div>
        
        <div class="form-group">
            <label for="paymentDate">Date of payment of fine</label>
            <input type="date" id="paymentDate">
        </div>
        
        <div class="form-group">
            <label for="fineAmount">Fine amount</label>
            <input type="number" id="fineAmount" readonly>
        </div>
        
        <div class="form-group autocomplete">
            <label for="policeStation">Police Station</label>
            <input type="text" id="policeStation" placeholder="Search police station">
            <div id="policeStationAutocomplete" class="autocomplete-items"></div>
        </div>
        
        <div class="divider"></div>
        
        <button id="proceedBtn" class="btn">Proceed to pay</button>
    </div>

    <script>
        // Convert PHP array to JavaScript
        const policeStations = <?php echo json_encode($policeStations); ?>;
        
        const fineData = {
            <?php foreach ($fineTypes as $fine): ?>
                '<?php echo $fine['fine_code']; ?>': { 
                    reason: '<?php echo addslashes($fine['description']); ?>', 
                    amount: <?php echo $fine['amount']; ?> 
                },
            <?php endforeach; ?>
        };

        // Get today's date for default payment date
        const today = new Date();
        const todayString = today.toISOString().split('T')[0];
        document.getElementById('paymentDate').value = todayString;

        // Fine code selection handler
        document.getElementById('fineCode').addEventListener('change', function() {
            const fineCode = this.value;
            const reasonField = document.getElementById('reason');
            const amountField = document.getElementById('fineAmount');
            
            if (fineCode && fineData[fineCode]) {
                reasonField.value = fineData[fineCode].reason;
                amountField.value = fineData[fineCode].amount;
            } else {
                reasonField.value = '';
                amountField.value = '';
            }
        });

        // Payment date change handler (double fine if late payment)
        document.getElementById('paymentDate').addEventListener('change', function() {
            const fineDate = document.getElementById('fineDate').value;
            const paymentDate = this.value;
            const amountField = document.getElementById('fineAmount');
            const fineCode = document.getElementById('fineCode').value;
            
            if (fineDate && paymentDate && fineCode && fineData[fineCode]) {
                const originalAmount = fineData[fineCode].amount;
                const fineDateObj = new Date(fineDate);
                const paymentDateObj = new Date(paymentDate);
                
                // If payment is after fine date, double the amount
                if (paymentDateObj > fineDateObj) {
                    amountField.value = originalAmount * 2;
                } else {
                    amountField.value = originalAmount;
                }
            }
        });

        // Police station autocomplete
        document.getElementById('policeStation').addEventListener('input', function() {
            const input = this.value.toLowerCase();
            const autocompleteList = document.getElementById('policeStationAutocomplete');
            autocompleteList.innerHTML = '';
            
            if (!input) return;
            
            const matches = policeStations.filter(station => 
                station.toLowerCase().includes(input)
            );
            
            matches.forEach(station => {
                const item = document.createElement('div');
                item.textContent = station;
                item.addEventListener('click', function() {
                    document.getElementById('policeStation').value = station;
                    autocompleteList.innerHTML = '';
                });
                autocompleteList.appendChild(item);
            });
        });

        // Close autocomplete when clicking elsewhere
        document.addEventListener('click', function(e) {
            if (e.target.id !== 'policeStation') {
                document.getElementById('policeStationAutocomplete').innerHTML = '';
            }
        });

        // Proceed to pay button handler
        document.getElementById('proceedBtn').addEventListener('click', function() {
            const fineCode = document.getElementById('fineCode').value;
            const licenseNo = document.getElementById('licenseNo').value;
            const vehicleNo = document.getElementById('vehicleNo').value.trim();
            const fineDate = document.getElementById('fineDate').value;
            const paymentDate = document.getElementById('paymentDate').value;
            const fineAmount = document.getElementById('fineAmount').value;
            const policeStation = document.getElementById('policeStation').value.trim();
            
            if (!fineCode) {
                alert('Please select a fine code');
                return;
            }
            
            if (!vehicleNo) {
                alert('Please enter vehicle number');
                return;
            }
            
            if (!fineDate) {
                alert('Please select date of fine imposed');
                return;
            }
            
            if (!paymentDate) {
                alert('Please select payment date');
                return;
            }
            
            if (!fineAmount || fineAmount <= 0) {
                alert('Please select a valid fine code to calculate amount');
                return;
            }
            
            if (!policeStation) {
                alert('Please select police station');
                return;
            }
            
            // Store data in session for payment page
            const paymentData = {
                fineCode,
                licenseNo,
                vehicleNo,
                fineDate,
                paymentDate,
                fineAmount,
                policeStation,
                reason: document.getElementById('reason').value,
                holderName: document.getElementById('holderName').value
            };
            
            sessionStorage.setItem('paymentData', JSON.stringify(paymentData));
            window.location.href = 'payment.php';
        });
    </script>
</body>
</htm>
