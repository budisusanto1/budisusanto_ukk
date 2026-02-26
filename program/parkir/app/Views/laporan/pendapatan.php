<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #28a745, #ffc107);">
                    <h4 class="mb-0">
                        <i class="fas fa-money-bill-wave me-2"></i>Laporan Pendapatan
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Filter Tanggal -->
                    <form method="GET" action="<?= site_url('/laporan/pendapatan') ?>">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                                <input type="date" class="form-control" name="tanggal_awal" 
                                       value="<?= $tanggal_awal ?>" 
                                       max="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" name="tanggal_akhir" 
                                       value="<?= $tanggal_akhir ?>" 
                                       max="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Tampilkan
                                    </button>
                                    <a href="<?= site_url('/laporan/exportExcel?tanggal_awal=' . $tanggal_awal . '&tanggal_akhir=' . $tanggal_akhir) ?>" 
                                       class="btn btn-success ms-2" target="_blank">
                                        <i class="fas fa-file-excel me-2"></i>Export Excel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Ringkasan Pendapatan -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-money-bill-wave fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Total Pendapatan</h5>
                                    <h2 class="text-success">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-car fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Total Transaksi</h5>
                                    <h2 class="text-info"><?= $total_transaksi ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-chart-line fa-3x text-warning mb-3"></i>
                                    <h5 class="card-title">Rata-rata per Transaksi</h5>
                                    <h2 class="text-warning">Rp <?= number_format($total_transaksi > 0 ? $total_pendapatan / $total_transaksi : 0, 0, ',', '.') ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Diagram Pendapatan -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-chart-line me-2"></i>Grafik Pendapatan Harian
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="pendapatanChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="fas fa-chart-pie me-2"></i>Distribusi Metode Pembayaran
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="metodePembayaranChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Detail -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Total Transaksi</th>
                                    <th>Total Pendapatan</th>
                                    <th>Rata-rata per Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($statistik_harian)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            Tidak ada data transaksi untuk periode yang dipilih.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($statistik_harian as $stat): ?>
                                        <tr>
                                            <td><?= date('d-m-Y', strtotime($stat['tanggal'])) ?></td>
                                            <td><?= $stat['total_transaksi'] ?></td>
                                            <td>Rp <?= number_format($stat['total_pendapatan'], 0, ',', '.') ?></td>
                                            <td>Rp <?= number_format($stat['total_transaksi'] > 0 ? $stat['total_pendapatan'] / $stat['total_transaksi'] : 0, 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data untuk grafik pendapatan harian
const pendapatanData = <?= json_encode(array_map(function($stat) {
    return [
        'tanggal' => date('d/m', strtotime($stat['tanggal'])),
        'pendapatan' => $stat['total_pendapatan']
    ];
}, $statistik_harian)) ?>;

const pendapatanLabels = pendapatanData.map(item => item[0]);
const pendapatanValues = pendapatanData.map(item => item[1]);

// Grafik Pendapatan Harian
const ctxPendapatan = document.getElementById('pendapatanChart').getContext('2d');
new Chart(ctxPendapatan, {
    type: 'line',
    data: {
        labels: pendapatanLabels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: pendapatanValues,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});

// Data untuk grafik metode pembayaran
const metodePembayaranData = <?= json_encode(array_map(function($t) {
    $metode = $t['metode_pembayaran'] ?? 'tunai';
    $labels = [
        'tunai' => 'Tunai',
        'transfer' => 'Transfer Bank',
        'ewallet' => 'E-Wallet',
        'kartu_kredit' => 'Kartu Kredit',
        'kartu_debit' => 'Kartu Debit'
    ];
    return [
        'metode' => $labels[$metode] ?? ucfirst($metode),
        'total' => $t['biaya_total']
    ];
}, $transaksi)) ?>;

// Group by metode pembayaran
const metodeGrouped = {};
metodePembayaranData.forEach(item => {
    if (!metodeGrouped[item[0]]) {
        metodeGrouped[item[0]] = 0;
    }
    metodeGrouped[item[0]] += item[1];
});

const metodeLabels = Object.keys(metodeGrouped);
const metodeValues = Object.values(metodeGrouped);

// Grafik Metode Pembayaran
const ctxMetode = document.getElementById('metodePembayaranChart').getContext('2d');
new Chart(ctxMetode, {
    type: 'doughnut',
    data: {
        labels: metodeLabels,
        datasets: [{
            data: metodeValues,
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0',
                '#9966FF'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'right'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID') + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});
</script>

<?= $this->endSection() ?>
