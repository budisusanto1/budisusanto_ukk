<?= $this->extend('templates/main_layout') ?>

<?= $this->section('content') ?>

<style>
.form-container {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.area-form {
    background: white;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    padding: 2.5rem;
    max-width: 500px;
    width: 100%;
}

.form-header {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    color: white;
    padding: 2rem;
    margin: -2.5rem -2.5rem 2rem -2.5rem;
    border-radius: 15px 15px 0 0;
    text-align: center;
}

.form-control:focus {
    border-color: var(--aurora-blue);
    box-shadow: 0 0 0 0.2rem rgba(0, 198, 255, 0.25);
}

.btn-submit {
    background: linear-gradient(135deg, var(--aurora-blue), var(--aurora-purple));
    border: none;
    color: white;
    padding: 12px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-cancel {
    background: #6c757d;
    border: none;
    color: white;
    padding: 12px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #5a6268;
}

.area-info {
    background: rgba(0, 198, 255, 0.1);
    border: 1px solid rgba(0, 198, 255, 0.2);
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.progress-bar {
    height: 8px;
    border-radius: 4px;
    background: #e9ecef;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--aurora-blue), var(--aurora-purple));
    transition: width 0.3s ease;
}
</style>

<div class="form-container">
    <div class="area-form">
        <div class="form-header">
            <h3 class="mb-0">Edit Area Parkir</h3>
            <p class="mb-0 opacity-75">Ubah data area parkir</p>
        </div>
        
        <form action="<?= site_url('/area/update/' . $area['id_area']) ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="nama_area" class="form-label">
                    <i class="fas fa-map-marked-alt me-2"></i>Nama Area
                </label>
                <input type="text" class="form-control" id="nama_area" name="nama_area" 
                       value="<?= $area['nama_area'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="kapasitas" class="form-label">
                    <i class="fas fa-car me-2"></i>Kapasitas
                </label>
                <input type="number" class="form-control" id="kapasitas" name="kapasitas" 
                       value="<?= $area['kapasitas'] ?>" min="1" required>
                <small class="text-muted">Masukkan jumlah maksimal kendaraan yang dapat parkir di area ini</small>
            </div>

            <div class="area-info">
                <h6><i class="fas fa-info-circle me-2"></i>Informasi Area Saat Ini</h6>
                <div class="row">
                    <div class="col-6">
                        <strong>Kapasitas:</strong> <?= $area['kapasitas'] ?>
                    </div>
                    <div class="col-6">
                        <strong>Terisi:</strong> <?= $area['terisi'] ?>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <strong>Tersedia:</strong> 
                        <span class="text-<?= $area['kapasitas'] - $area['terisi'] > 0 ? 'success' : 'danger' ?>">
                            <?= $area['kapasitas'] - $area['terisi'] ?>
                        </span>
                    </div>
                </div>
                <div class="progress-bar mt-2">
                    <div class="progress-fill" style="width: <?= $area['kapasitas'] > 0 ? round(($area['terisi'] / $area['kapasitas']) * 100, 2) : 0 ?>%"></div>
                </div>
                <small class="text-muted">Keterisian: <?= $area['kapasitas'] > 0 ? round(($area['terisi'] / $area['kapasitas']) * 100, 2) : 0 ?>%</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-submit flex-fill">
                    <i class="fas fa-save me-2"></i>Update
                </button>
                <a href="<?= site_url('/area') ?>" class="btn btn-cancel flex-fill">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
