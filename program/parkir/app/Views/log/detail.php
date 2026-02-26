<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.detail-container {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

.detail-header {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2rem;
    border-radius: 15px 15px 0 0;
    margin-bottom: 2rem;
}

.detail-body {
    background: white;
    border-radius: 0 0 15px 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.info-card {
    background: rgba(0, 198, 255, 0.1);
    border: 1px solid rgba(0, 198, 255, 0.2);
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.info-label {
    font-weight: 600;
    color: var(--aurora-blue);
}

.log-activity {
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 1.5rem;
    font-size: 1rem;
    line-height: 1.6;
}

.log-time {
    font-family: monospace;
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0.5rem;
}

.log-user-agent {
    font-family: monospace;
    font-size: 0.8rem;
    color: #999;
    word-break: break-all;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #ddd;
}

.btn-back {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
</style>

<div class="detail-container">
    <div class="detail-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-1">Detail Log Aktivitas</h2>
                <p class="mb-0 opacity-75">Informasi lengkap aktivitas</p>
            </div>
            <a href="<?= site_url('/log-aktivitas') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="detail-body">
        <?php if (!empty($log)): ?>
            <div class="info-card">
                <h5><i class="fas fa-info-circle me-2"></i>Informasi Log</h5>
                <div class="info-item">
                    <span class="info-label">ID Log:</span>
                    <span>#<?= $log[0]['id_log'] ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Waktu:</span>
                    <span><?= date('d M Y H:i:s', strtotime($log[0]['waktu_aktivitas'])) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">User:</span>
                    <span><?= $log[0]['nama_lengkap'] ?? $log[0]['username'] ?></span>
                    <small class="text-muted">(@<?= $log[0]['username'] ?>)</small>
                </div>
                <div class="info-item">
                    <span class="info-label">IP Address:</span>
                    <span><?= $log[0]['ip_address'] ?></span>
                </div>
            </div>

            <div class="info-card">
                <h5><i class="fas fa-list-alt me-2"></i>Aktivitas</h5>
                <div class="log-activity">
                    <div class="log-time">
                        <?= date('d M Y H:i:s', strtotime($log[0]['waktu_aktivitas'])) ?>
                    </div>
                    <div>
                        <?= $log[0]['aktivitas'] ?>
                    </div>
                    <div class="log-user-agent">
                        <strong>User Agent:</strong><br>
                        <?= $log[0]['user_agent'] ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
