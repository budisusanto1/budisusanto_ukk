<?php
// Helper function untuk menampilkan label metode pembayaran
function getMetodePembayaranLabel($metode) {
    $labels = [
        'tunai' => 'Tunai',
        'transfer' => 'Transfer Bank',
        'ewallet' => 'E-Wallet',
        'kartu_kredit' => 'Kartu Kredit',
        'kartu_debit' => 'Kartu Debit'
    ];
    return $labels[$metode] ?? ucfirst($metode);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Parkir - <?= $transaksi['plat_nomor'] ?? 'N/A' ?></title>
    
    <style>
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        
        .struk-container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border: 2px solid #333;
            border-radius: 5px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        
        .content {
            margin: 15px 0;
        }
        
        .row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 12px;
        }
        
        .row.total {
            border-top: 2px dashed #333;
            padding-top: 10px;
            margin-top: 15px;
            font-weight: bold;
            font-size: 14px;
        }
        
        .footer {
            text-align: center;
            border-top: 2px dashed #333;
            padding-top: 10px;
            margin-top: 15px;
            font-size: 10px;
        }
        
        .no-print {
            text-align: center;
            margin: 20px 0;
        }
        
        .no-print button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
        }
        
        .no-print button:hover {
            background: #0056b3;
        }
        
        @media print {
            body {
                padding: 0;
                background: white;
            }
            
            .struk-container {
                border: none;
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="struk-container">
        <div class="header">
            <h1>BCS MALL PARKIR</h1>
            <p>Jl. Mall BCS No. 123, Jakarta</p>
            <p>Telp: (021) 1234-5678</p>
        </div>
        
        <div class="content">
            <div class="row">
                <span>No. Struk:</span>
                <span><?= str_pad($transaksi['id_parkir'] ?? '000000', 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="row">
                <span>Tanggal Cetak:</span>
                <span><?= date('d-m-Y H:i:s') ?></span>
            </div>
            <div class="row">
                <span>Petugas:</span>
                <span><?= session()->get('nama_lengkap') ?? session()->get('username') ?? 'N/A' ?></span>
            </div>
            
            <div style="height: 10px;"></div>
            
            <div class="row">
                <span>Plat Nomor:</span>
                <span><?= $transaksi['plat_nomor'] ?? 'N/A' ?></span>
            </div>
            <div class="row">
                <span>Jenis Kendaraan:</span>
                <span><?= ucfirst($transaksi['jenis_kendaraan'] ?? 'N/A') ?></span>
            </div>
            <div class="row">
                <span>Warna:</span>
                <span><?= $transaksi['warna'] ?? '-' ?></span>
            </div>
            <div class="row">
                <span>Pemilik:</span>
                <span><?= $transaksi['pemilik'] ?? 'Tidak Diketahui' ?></span>
            </div>
            
            <div style="height: 10px;"></div>
            
            <div class="row">
                <span>Waktu Masuk:</span>
                <span><?= $transaksi['waktu_masuk'] ? date('d-m-Y H:i:s', strtotime($transaksi['waktu_masuk'])) : 'N/A' ?></span>
            </div>
            <div class="row">
                <span>Waktu Keluar:</span>
                <span><?= $transaksi['waktu_keluar'] ? date('d-m-Y H:i:s', strtotime($transaksi['waktu_keluar'])) : 'N/A' ?></span>
            </div>
            <div class="row">
                <span>Durasi:</span>
                <span><?= number_format($transaksi['durasi_jam'] ?? 0, 2, ',', '.') ?> jam</span>
            </div>
            <div class="row">
                <span>Tarif per Jam:</span>
                <span>Rp <?= number_format($transaksi['tarif_per_jam'] ?? 0, 0, ',', '.') ?></span>
            </div>
            <div class="row">
                <span>Metode Pembayaran:</span>
                <span><?= getMetodePembayaranLabel($transaksi['metode_pembayaran'] ?? 'tunai') ?></span>
            </div>
            
            <div class="row total">
                <span>TOTAL BAYAR:</span>
                <span>Rp <?= number_format($transaksi['biaya_total'] ?? 0, 0, ',', '.') ?></span>
            </div>
        </div>
        
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda</p>
            <p>Barang hilang bukan tanggung jawab kami</p>
            <p>*Struk ini sah sebagai bukti pembayaran*</p>
        </div>
    </div>
    
    <div class="no-print">
        <button onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
        <button onclick="window.close()">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>
    
    <script>
        // Auto print dan close setelah 2 detik
        setTimeout(function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 1000);
        }, 2000);
    </script>
</body>
</html>
