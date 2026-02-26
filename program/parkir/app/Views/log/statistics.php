<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.stats-container {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

.stats-header {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2rem;
    border-radius: 15px 15px 0 0;
    margin-bottom: 2rem;
}

.stats-body {
    background: white;
    border-radius: 0 0 15px 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.chart-container {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
}

.chart-canvas {
    max-height: 400px;
}

.filter-form {
    background: rgba(0, 198, 255, 0.1);
    border: 1px solid rgba(0, 198, 255, 0.2);
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.btn-export {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-export:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
</style>

<div class="stats-container">
    <div class="stats-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Statistik Log Aktivitas</h2>
                <p class="mb-0 opacity-75">Analisis aktivitas sistem</p>
            </div>
            <div class="d-flex gap-2">
                <form method="GET" action="<?= site_url('/log-aktivitas/statistics') ?>" class="d-flex gap-2">
                    <input type="date" name="tanggal_awal" class="form-control" 
                           value="<?= $tanggal_awal ?>" max="<?= $tanggal_akhir ?>">
                    <input type="date" name="tanggal_akhir" class="form-control" 
                           value="<?= $tanggal_akhir ?>" max="<?= $tanggal_awal ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar me-2"></i>Filter
                    </button>
                </form>
                <a href="<?= site_url('/log-aktivitas/export?tanggal_awal=<?= $tanggal_awal ?>&tanggal_akhir=<?= $tanggal_akhir ?> ?>" 
                   class="btn btn-export">
                    <i class="fas fa-download me-2"></i>Export
                </a>
            </div>
        </div>
    </div>

    <div class="stats-body">
        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number"><?= count($stats) ?></div>
                    <div class="stat-label">Total Hari</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number"><?= array_sum(array_column($stats, 'total_aktivitas')) ?></div>
                    <div class="stat-label">Total Aktivitas</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number"><?= round(array_sum(array_column($stats, 'total_aktivitas')) / count($stats)) ?></div>
                    <div class="stat-label">Rata-rata/Hari</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number"><?= max(array_column($stats, 'total_aktivitas')) ?></div>
                    <div class="stat-label">Tertinggi Tertinggi</div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="chart-container">
            <h5><i class="fas fa-chart-line me-2"></i>Grafik Aktivitas Per Hari</h5>
            <canvas id="aktivitasChart"></canvas>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Total Aktivitas</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats as $stat): ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($stat['tanggal'])) ?></td>
                            <td><?= $stat['total_aktivitas'] ?></td>
                            <td>
                                <?php 
                                $total = array_sum(array_column($stats, 'total_aktivitas'));
                                $persentase = $total > 0 ? round(($stat['total_aktivitas'] / $total) * 100, 2) : 0;
                                echo $persentase . '%';
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('aktivitasChart').getContext('2d');
    
    const labels = <?= json_encode(array_column($stats, 'tanggal')) ?>;
    const data = <?= json_encode(array_column($stats, 'total_aktivitas')) ?>;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Aktivitas',
                data: data,
                borderColor: 'rgba(0, 198, 255, 1)',
                backgroundColor: 'rgba(0, 198, 255, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
});
</script>

<?= $this->endSection() ?>
