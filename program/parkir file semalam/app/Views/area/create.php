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
</style>

<div class="form-container">
    <div class="area-form">
        <div class="form-header">
            <h3 class="mb-0">Tambah Area Parkir Baru</h3>
            <p class="mb-0 opacity-75">Form pembuatan area parkir</p>
        </div>
        
        <form action="<?= site_url('/area/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="nama_area" class="form-label">
                    <i class="fas fa-map-marked-alt me-2"></i>Nama Area
                </label>
                <input type="text" class="form-control" id="nama_area" name="nama_area" 
                       placeholder="Contoh: Area A - Mobil" required>
            </div>

            <div class="mb-4">
                <label for="kapasitas" class="form-label">
                    <i class="fas fa-car me-2"></i>Kapasitas
                </label>
                <input type="number" class="form-control" id="kapasitas" name="kapasitas" 
                       placeholder="Contoh: 50" min="1" required>
                <small class="text-muted">Masukkan jumlah maksimal kendaraan yang dapat parkir di area ini</small>
            </div>

            <div class="mb-3">
                <label for="terisi" class="form-label">
                    <i class="fas fa-car me-2"></i>Terisi (Opsional)
                </label>
                <input type="number" class="form-control" id="terisi" name="terisi" 
                       placeholder="0" min="0" value="0">
                <small class="text-muted">Jumlah kendaraan yang sedang terisi (default: 0)</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-submit flex-fill">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
                <a href="<?= site_url('/area') ?>" class="btn btn-cancel flex-fill">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
