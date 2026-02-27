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

.kendaraan-form {
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
    <div class="kendaraan-form">
        <div class="form-header">
            <h3 class="mb-0">Tambah Kendaraan Baru</h3>
            <p class="mb-0 opacity-75">Form registrasi kendaraan</p>
        </div>
        
        <form action="<?= site_url('/kendaraan/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="plat_nomor" class="form-label">
                    <i class="fas fa-id-card me-2"></i>Plat Nomor
                </label>
                <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" 
                       placeholder="Contoh: B1234CD" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kendaraan" class="form-label">
                    <i class="fas fa-car me-2"></i>Jenis Kendaraan
                </label>
                <select class="form-select" id="jenis_kendaraan" name="jenis_kendaraan" required>
                    <option value="">Pilih Jenis Kendaraan</option>
                    <option value="mobil">🚗 Mobil</option>
                    <option value="motor">🏍️ Motor</option>
                    <option value="truk">🚚 Truk</option>
                    <option value="bus">🚌 Bus</option>
                    <option value="lainnya">📦 Lainnya</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="warna" class="form-label">
                    <i class="fas fa-palette me-2"></i>Warna Kendaraan
                </label>
                <input type="text" class="form-control" id="warna" name="warna" 
                       placeholder="Contoh: Merah, Hitam, Silver">
            </div>

            <div class="mb-4">
                <label for="pemilik" class="form-label">
                    <i class="fas fa-user me-2"></i>Nama Pemilik
                </label>
                <input type="text" class="form-control" id="pemilik" name="pemilik" 
                       placeholder="Opsional">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-submit flex-fill">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
                <a href="<?= site_url('/kendaraan') ?>" class="btn btn-cancel flex-fill">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
