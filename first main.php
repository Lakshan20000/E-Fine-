<!DOCTYPE html>
<html lang="en">
<head>
    <title>License Verification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="styles1.css">
    <style>
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

        .main-container {
            flex: 1;
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
        }

        .page-title {
            color: var(--primary);
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary);
            font-weight: 500;
            font-size: 16px;
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
        }

        .form-group input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(14, 60, 130, 0.1);
        }

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

        .info-display {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f8f9fa;
            display: none;
        }

        .info-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-item strong {
            color: var(--primary);
            display: inline-block;
            min-width: 150px;
        }

        .next-btn-container {
            text-align: right;
            margin-top: 20px;
            display: none;
        }

        .user-info {
            color: white;
            font-weight: 500;
            margin-right: 20px;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                padding: 15px;
            }

            nav ul {
                margin-top: 15px;
            }

            .main-container {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    
    <div class="main-container">
        <h1 class="page-title">License Verification</h1>
        
        <div class="form-group">
            <label for="licenseNo">Driving License Number</label>
            <div class="input-wrapper">
                <i class="fas fa-id-card"></i>
                <input type="text" id="licenseNo" placeholder="Enter driving license number" required>
            </div>
        </div>
        
        <button id="enterBtn" class="btn">Verify License</button>
        
        <div id="infoDisplay" class="info-display">
            <div class="info-item">
                <strong>License Holder:</strong> <span id="holderName"></span>
            </div>
            <div class="info-item">
                <strong>License Type:</strong> <span id="licenseType"></span>
            </div>
        </div>
        
        <div class="next-btn-container">
            <button id="nextBtn" class="btn">Continue to Fine Details <i class="fas fa-arrow-right"></i></button>
        </div>
    </div>

   

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const enterBtn = document.getElementById('enterBtn');
            const licenseNoInput = document.getElementById('licenseNo');
            const infoDisplay = document.getElementById('infoDisplay');
            const nextBtnContainer = document.querySelector('.next-btn-container');
            
            // Handle Enter key press in license number field
            licenseNoInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    enterBtn.click();
                }
            });
            
            enterBtn.addEventListener('click', function() {
                const licenseNo = licenseNoInput.value.trim();
                
                if (!licenseNo) {
                    alert('Please enter a driving license number');
                    licenseNoInput.focus();
                    return;
                }
                
                // Show loading state
                enterBtn.disabled = true;
                enterBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
                
                // AJAX request to fetch license details
                fetch('get_license.php?licenseNo=' + encodeURIComponent(licenseNo))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Display license information
                            document.getElementById('holderName').textContent = data.name || 'N/A';
                            document.getElementById('licenseType').textContent = data.type || 'N/A';
                            
                            infoDisplay.style.display = 'block';
                            nextBtnContainer.style.display = 'block';
                            
                            // Store license number in session for next page
                            sessionStorage.setItem('licenseNo', licenseNo);
                        } else {
                            alert(data.message || 'License number not found. Please try again.');
                            infoDisplay.style.display = 'none';
                            nextBtnContainer.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while fetching license details.');
                    })
                    .finally(() => {
                        enterBtn.disabled = false;
                        enterBtn.textContent = 'Verify License';
                    });
            });
            
            document.getElementById('nextBtn').addEventListener('click', function() {
                const licenseNo = sessionStorage.getItem('licenseNo');
                if (licenseNo) {
                    window.location.href = 'second main.php?licenseNo=' + encodeURIComponent(licenseNo);
                } else {
                    alert('Please verify your license first.');
                }
            });
        });
    </script>
</body>
</html>

