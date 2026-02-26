<?php
// Set headers untuk Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Laporan_Pendapatan_' . date('d-m-Y', strtotime($tanggal_awal)) . '_s_d_' . date('d-m-Y', strtotime($tanggal_akhir)) . '.xls"');
header('Cache-Control: max-age=0');

// Helper function untuk label metode pembayaran
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
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .summary {
            background-color: #e8f5e8;
            margin: 20px 0;
            padding: 15px;
        }
        .summary td {
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        LAPORAN PENDAPATAN PARKIR BCS MALL
        <br>
        Periode: <?= date('d F Y', strtotime($tanggal_awal)) ?> - <?= date('d F Y', strtotime($tanggal_akhir)) ?>
    </div>

    <!-- Ringkasan -->
    <table class="summary">
        <tr>
            <td>Total Transaksi:</td>
            <td class="text-right"><?= $total_transaksi ?></td>
        </tr>
        <tr>
            <td>Total Pendapatan:</td>
            <td class="text-right">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Rata-rata per Transaksi:</td>
            <td class="text-right">Rp <?= number_format($total_transaksi > 0 ? $total_pendapatan / $total_transaksi : 0, 0, ',', '.') ?></td>
        </tr>
    </table>

    <!-- Statistik Harian -->
    <h3>Statistik Pendapatan Harian</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Total Transaksi</th>
                <th>Total Pendapatan</th>
                <th>Rata-rata per Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($statistik_harian)): ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data transaksi untuk periode yang dipilih.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; ?>
                <?php foreach ($statistik_harian as $stat): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d F Y', strtotime($stat['tanggal'])) ?></td>
                        <td class="text-center"><?= $stat['total_transaksi'] ?></td>
                        <td class="text-right">Rp <?= number_format($stat['total_pendapatan'], 0, ',', '.') ?></td>
                        <td class="text-right">Rp <?= number_format($stat['total_transaksi'] > 0 ? $stat['total_pendapatan'] / $stat['total_transaksi'] : 0, 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Statistik Metode Pembayaran -->
    <?php if (!empty($statistik_metode_pembayaran)): ?>
    <h3>Statistik Metode Pembayaran</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Metode Pembayaran</th>
                <th>Total Transaksi</th>
                <th>Total Pendapatan</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($statistik_metode_pembayaran as $stat): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= getMetodePembayaranLabel($stat['metode_pembayaran']) ?></td>
                    <td class="text-center"><?= $stat['total_transaksi'] ?></td>
                    <td class="text-right">Rp <?= number_format($stat['total_pendapatan'], 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format(($stat['total_pendapatan'] / $total_pendapatan) * 100, 1) ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Detail Transaksi -->
    <h3>Detail Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Parkir</th>
                <th>Plat Nomor</th>
                <th>Jenis Kendaraan</th>
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Durasi (Jam)</th>
                <th>Biaya Total</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transaksi)): ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data transaksi untuk periode yang dipilih.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; ?>
                <?php foreach ($transaksi as $t): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $t['id_parkir'] ?></td>
                        <td><?= $t['plat_nomor'] ?></td>
                        <td><?= ucfirst($t['jenis_kendaraan']) ?></td>
                        <td><?= date('d F Y H:i', strtotime($t['waktu_masuk'])) ?></td>
                        <td><?= $t['waktu_keluar'] ? date('d F Y H:i', strtotime($t['waktu_keluar'])) : '-' ?></td>
                        <td class="text-center"><?= number_format($t['durasi_jam'], 2) ?></td>
                        <td class="text-right">Rp <?= number_format($t['biaya_total'], 0, ',', '.') ?></td>
                        <td><?= getMetodePembayaranLabel($t['metode_pembayaran'] ?? 'tunai') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Footer -->
    <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        <p>Laporan ini dihasilkan pada: <?= date('d F Y H:i:s') ?></p>
        <p>Sistem Parkir BCS Mall - Powered by CodeIgniter 4</p>
    </div>
</body>
</html>
