<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode & QR Code - {{ $driver->name }}</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .cards-wrapper {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .code-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .card-header {
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        .barcode-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .qr-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-header h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .card-header p {
            font-size: 13px;
            opacity: 0.9;
        }
        
        .card-header .badge {
            display: inline-block;
            background: rgba(255,255,255,0.3);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            margin-top: 10px;
            font-weight: bold;
        }
        
        .driver-info {
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .driver-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 24px;
            font-weight: bold;
            color: white;
        }
        
        .driver-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
        }
        
        .driver-id {
            font-size: 12px;
            color: #666;
            font-family: 'Courier New', monospace;
        }
        
        .code-container {
            padding: 30px;
            background: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 250px;
        }
        
        .code-wrapper {
            background: white;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .barcode-wrapper {
            border: 4px solid #f5576c;
        }
        
        .qr-wrapper {
            border: 4px solid #667eea;
        }
        
        #barcode, #qrcode {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .card-footer {
            padding: 15px 20px;
            background: #f3f4f6;
            text-align: center;
        }
        
        .footer-note {
            font-size: 11px;
            color: #666;
            line-height: 1.5;
        }
        
        .url-text {
            font-size: 10px;
            color: #999;
            word-break: break-all;
            font-family: 'Courier New', monospace;
            margin-top: 8px;
        }
        
        .points-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fef3c7;
            color: #92400e;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 13px;
            margin-top: 10px;
        }
        
        .action-buttons {
            text-align: center;
            margin-top: 20px;
        }
        
        .print-button {
            padding: 12px 35px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: transform 0.2s;
            margin: 0 5px;
        }
        
        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .back-button {
            display: inline-block;
            padding: 10px 25px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: transform 0.2s;
            margin: 0 5px;
        }
        
        .back-button:hover {
            transform: translateY(-2px);
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .cards-wrapper {
                page-break-inside: avoid;
            }
            
            .code-card {
                box-shadow: none;
                page-break-inside: avoid;
            }
            
            .action-buttons {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .cards-wrapper {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cards-wrapper">
            <!-- Barcode Card (For Scanning Transaction) -->
            <div class="code-card">
                <div class="card-header barcode-header">
                    <h2>📊 BARCODE SCAN</h2>
                    <p>Scan saat bawa pasien ke RS</p>
                    <span class="badge">MENCATAT TRANSAKSI</span>
                </div>
                
                <div class="driver-info">
                    <div class="driver-avatar">{{ strtoupper(substr($driver->name, 0, 2)) }}</div>
                    <div class="driver-name">{{ $driver->name }}</div>
                    <div class="driver-id">{{ $driver->driver_id_card }}</div>
                </div>
                
                <div class="code-container">
                    <div class="code-wrapper barcode-wrapper">
                        <svg id="barcode"></svg>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="footer-note">
                        <strong>📱 Untuk Scan Transaksi</strong><br>
                        Scan barcode ini ketika driver membawa pasien ke rumah sakit.<br>
                        Sistem akan otomatis mencatat transaksi dan menunggu konfirmasi admin.
                    </div>
                    <div class="url-text">{{ route('driver.scan', $driver->driver_id_card) }}</div>
                </div>
            </div>
            
            <!-- QR Code Card (For Viewing Points) -->
            <div class="code-card">
                <div class="card-header qr-header">
                    <h2>🎯 QR CODE POIN</h2>
                    <p>Scan untuk lihat total poin</p>
                    <span class="badge">HANYA LIHAT POIN</span>
                </div>
                
                <div class="driver-info">
                    <div class="driver-avatar">{{ strtoupper(substr($driver->name, 0, 2)) }}</div>
                    <div class="driver-name">{{ $driver->name }}</div>
                    <div class="driver-id">{{ $driver->driver_id_card }}</div>
                    <div class="points-badge">
                        <span>💰</span>
                        <span>Poin: {{ number_format($driver->total_points) }}</span>
                    </div>
                </div>
                
                <div class="code-container">
                    <div class="code-wrapper qr-wrapper">
                        <div id="qrcode"></div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="footer-note">
                        <strong>👀 Untuk Cek Poin</strong><br>
                        Scan QR ini kapan saja untuk melihat total poin yang dimiliki.<br>
                        Tidak akan mencatat transaksi baru.
                    </div>
                    <div class="url-text">{{ route('driver.point', $driver->driver_id_card) }}</div>
                </div>
            </div>
        </div>
        
        <div class="action-buttons">
            <button class="print-button" onclick="window.print()">
                🖨️ Print Semua Barcode
            </button>
            <a href="{{ route('driver.show', $driver) }}" class="back-button">← Kembali</a>
        </div>
    </div>

    <!-- JsBarcode Library for 1D Barcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <!-- QRCode Library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    
    <script>
        // Generate 1D Barcode for scanning transaction
        JsBarcode("#barcode", "{{ $driver->driver_id_card }}", {
            format: "CODE128",
            width: 2,
            height: 80,
            displayValue: true,
            fontSize: 14,
            margin: 10
        });
        
        // Generate QR Code for viewing points
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ route('driver.point', $driver->driver_id_card) }}",
            width: 180,
            height: 180,
            colorDark: "#667eea",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>
