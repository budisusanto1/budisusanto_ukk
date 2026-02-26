# Fitur Laporan Pendapatan dengan Export Excel dan Diagram

## Deskripsi
Fitur ini menyediakan laporan pendapatan parkir yang lengkap dengan visualisasi diagram dan kemampuan export ke Excel. User dapat melihat statistik pendapatan harian, distribusi metode pembayaran, dan mengunduh laporan dalam format Excel.

## Fitur Utama

### 1. Dashboard Laporan Pendapatan
- **Filter Tanggal**: Pilih periode laporan (tanggal awal - tanggal akhir)
- **Ringkasan Statistik**: Total pendapatan, total transaksi, rata-rata per transaksi
- **Tabel Detail**: Statistik harian dengan breakdown lengkap
- **Export Excel**: Tombol untuk download laporan dalam format Excel
- **Visualisasi Data**: Diagram interaktif dengan Chart.js

### 2. Diagram Visualisasi
- **Grafik Garis**: Menunjukkan tren pendapatan harian
- **Diagram Donat**: Distribusi pendapatan berdasarkan metode pembayaran
- **Responsive**: Diagram menyesuaikan ukuran layar
- **Interactive**: Hover untuk detail informasi

### 3. Export Excel
- **Format Lengkap**: Header, ringkasan, statistik harian, metode pembayaran, detail transaksi
- **Styling**: Tabel dengan format yang rapi dan mudah dibaca
- **Informasi Lengkap**: Semua data transaksi dengan metode pembayaran
- **Timestamp**: Waktu pembuatan laporan otomatis

## Hak Akses
- **Owner**: Akses penuh ke semua fitur laporan
- **Admin**: Akses penuh ke semua fitur laporan  
- **Superadmin**: Akses penuh ke semua fitur laporan
- **Petugas**: Tidak memiliki akses (sesuai role)

## Cara Penggunaan

### 1. Mengakses Laporan
1. Login sebagai Owner, Admin, atau Superadmin
2. Klik menu "Laporan" di navbar
3. Pilih "Laporan Pendapatan"

### 2. Filter Periode
1. Pilih tanggal awal dan tanggal akhir
2. Klik tombol "Tampilkan"
3. Data akan diperbarui sesuai periode yang dipilih

### 3. Melihat Diagram
- **Grafik Pendapatan**: Lihat tren pendapatan harian
- **Metode Pembayaran**: Lihat distribusi pendapatan per metode
- Hover pada diagram untuk detail informasi

### 4. Export Excel
1. Klik tombol "Export Excel" (hijau)
2. File Excel akan otomatis di-download
3. Nama file: `Laporan_Pendapatan_[tanggal_awal]_s_d_[tanggal_akhir].xls`

## Struktur File

### Controller
- `LaporanController.php`: 
  - `pendapatan()`: Menampilkan halaman laporan
  - `exportExcel()`: Generate dan download Excel

### Views
- `laporan/pendapatan.php`: Halaman utama dengan diagram
- `laporan/pendapatan_excel.php`: Template Excel export

### Routes
- `/laporan/pendapatan`: Halaman laporan
- `/laporan/exportExcel`: Export Excel

## Data yang Ditampilkan

### Ringkasan
- Total transaksi dalam periode
- Total pendapatan dalam periode
- Rata-rata pendapatan per transaksi

### Statistik Harian
- Tanggal
- Jumlah transaksi per hari
- Total pendapatan per hari
- Rata-rata pendapatan per transaksi

### Metode Pembayaran
- Tunai, Transfer Bank, E-Wallet, Kartu Kredit, Kartu Debit
- Jumlah transaksi per metode
- Total pendapatan per metode
- Persentase distribusi

### Detail Transaksi
- ID Parkir, Plat Nomor, Jenis Kendaraan
- Waktu Masuk/Keluar, Durasi
- Biaya Total, Metode Pembayaran

## Teknologi yang Digunakan
- **Backend**: CodeIgniter 4, PHP
- **Frontend**: Bootstrap 5, Chart.js
- **Export**: PHP Excel generation
- **Database**: MySQL dengan query optimasi

## Keunggulan
- **Real-time**: Data langsung dari database
- **Interactive**: Diagram yang responsif dan informatif
- **Comprehensive**: Laporan lengkap dari ringkasan hingga detail
- **User-friendly**: Interface yang intuitif dan mudah digunakan
- **Professional**: Format Excel yang siap presentasi

## Future Enhancements
- Export PDF
- Filter berdasarkan jenis kendaraan
- Comparison period (month-over-month)
- Email laporan otomatis
- Mobile app integration
