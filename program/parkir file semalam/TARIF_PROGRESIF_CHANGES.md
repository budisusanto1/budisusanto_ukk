# Perubahan Sistem Tarif Parkir - Flat Rate Rp 1.000/jam

## Deskripsi
Mengubah sistem tarif parkir menjadi flat rate Rp 1.000 per jam untuk semua jenis kendaraan (motor dan mobil).

## Sistem Tarif Baru

### Tarif Sama untuk Motor & Mobil:
- **Jam 1**: Rp 1.000
- **Jam 2**: Rp 2.000
- **Jam 3**: Rp 3.000
- **Jam 4**: Rp 4.000
- **dst**: Rp 1.000 per jam (flat rate)

### Minimal Durasi:
- **Minimal parkir**: Tidak ada (bisa kurang dari 1 jam)
- **Minimal biaya**: Rp 1.000 (untuk transaksi sangat singkat)
- **Pembulatan**: < 30 menit = gratis, ≥ 30 menit = 1 jam
- Durasi dihitung sesuai actual waktu parkir

## Rumus Perhitungan

### Sama untuk Motor & Mobil:
```
Biaya Total = Durasi Jam × 1000

Contoh:
- 1 jam: 1 × 1000 = Rp 1.000
- 2 jam: 2 × 1000 = Rp 2.000
- 3 jam: 3 × 1000 = Rp 3.000
- 5 jam: 5 × 1000 = Rp 5.000
```

## File yang Diubah

### 1. Model Transaksi (`app/Models/Transaksi.php`)

#### Method `updateWithBiaya()`:
- **Sebelum**: `$biaya_total = $durasi_jam * $tarif_per_jam;`
- **Sesudah**: 
  ```php
  // Minimal durasi 2 jam
  if ($durasi_jam < 2) {
      $durasi_jam = 2;
  }
  
  // Hitung biaya total dengan tarif progresif
  $biaya_total = 2000 + (($durasi_jam - 1) * 1000);
  ```

#### Method `hitungBiaya()`:
- **Sebelum**: `$biaya_total = $durasi_jam * $tarif_per_jam;`
- **Sesudah**: Sama seperti updateWithBiaya

## Contoh Perhitungan

### Kasus 1: Parkir 1.5 jam
- Durasi: 1.5 jam → 2 jam (minimal)
- Biaya: 2000 + ((2-1) * 1000) = Rp 3.000

### Kasus 2: Parkir 2.5 jam  
- Durasi: 2.5 jam → 3 jam (pembulatan ke atas)
- Biaya: 2000 + ((3-1) * 1000) = Rp 4.000

### Kasus 3: Parkir 4 jam
- Durasi: 4 jam
- Biaya: 2000 + ((4-1) * 1000) = Rp 5.000

## Keuntungan Sistem Baru

### Untuk Pengelola:
- **Revenue lebih tinggi** untuk parkir durasi panjang
- **Minimal 2 jam** meningkatkan pendapatan
- **Tarif progresif** adil untuk durasi berbeda

### Untuk Pengguna:
- **Harga jelas** dan transparan
- **Tidak ada biaya tersembunyi**
- **Pembulatan wajar** (ke jam penuh)

## Perbandingan Tarif

### Tarif Sama untuk Motor & Mobil:
| Durasi | Tarif Lama (Rp 5.000/jam) | Tarif Baru | Selisih |
|---------|----------------------------|-------------|----------|
| 0.5 jam | Rp 2.500                  | Rp 500       | -Rp 2.000 |
| 1 jam   | Rp 5.000                  | Rp 1.000     | -Rp 4.000 |
| 2 jam   | Rp 10.000                 | Rp 2.000     | -Rp 8.000 |
| 3 jam   | Rp 15.000                 | Rp 3.000     | -Rp 12.000 |
| 4 jam   | Rp 20.000                 | Rp 4.000     | -Rp 16.000 |
| 5 jam   | Rp 25.000                 | Rp 5.000     | -Rp 20.000 |

**Catatan**: Tarif baru jauh lebih murah dan sederhana, Rp 1.000 per jam untuk semua kendaraan.

## Testing

Untuk memastikan perubahan berfungsi:

### Test Case 1: Motor 33 detik
1. Input: Masuk 08:01:51, Keluar 08:02:24 (33 detik)
2. Expected: Durasi 0 jam (gratis), Biaya Rp 1.000 (minimal)
3. Verify: Database menampilkan durasi_jam=0, biaya_total=1000

### Test Case 2: Motor 45 menit
1. Input: Masuk 08:00, Keluar 08:45 (45 menit)
2. Expected: Durasi 1 jam (≥30 menit), Biaya Rp 1.000
3. Verify: Database menampilkan durasi_jam=1, biaya_total=1000

### Test Case 3: Motor 2 jam
1. Input: Masuk 08:00, Keluar 10:00 (2 jam)
2. Expected: Durasi 2 jam, Biaya Rp 2.000
3. Verify: Database menampilkan durasi_jam=2, biaya_total=2000

## Debug Log

Sistem mencatat log debug untuk setiap perhitungan:
```
UpdateWithBiaya - ID: 123, Tarif: 5000
UpdateWithBiaya - Waktu Masuk: 2026-02-26 08:00:00
UpdateWithBiaya - Waktu Keluar: 2026-02-26 11:30:00
UpdateWithBiaya - Interval: 03:30:00
UpdateWithBiaya - Durasi Jam: 4
UpdateWithBiaya - Biaya Total: 5000
```

## Impact pada Fitur Lain

### Laporan Pendapatan:
- ✅ Tetap berfungsi normal
- ✅ Menampilkan biaya_total yang sudah terhitung progresif
- ✅ Export Excel dan diagram tidak terpengaruh

### Struk Parkir:
- ✅ Menampilkan biaya_total yang benar
- ✅ Durasi dan biaya sesuai tarif baru
- ✅ User-friendly dengan format Rupiah

### Dashboard:
- ✅ Statistik pendapatan akurat
- ✅ Total transaksi terhitung dengan benar

## Rollback Plan

Jika perlu kembali ke tarif lama:
1. Ubah kembali rumus di kedua method:
   ```php
   $biaya_total = $durasi_jam * $tarif_per_jam;
   ```
2. Hapus minimal durasi 2 jam
3. Update tarif di database jika perlu

## Future Enhancements

### Opsi 1: Tarif Berbeda per Jenis Kendaraan
- Motor: Rp 1.500 + Rp 500/jam
- Mobil: Rp 2.000 + Rp 1.000/jam

### Opsi 2: Tarif Berbeda per Waktu
- Pagi/Siang: Tarif normal
- Malam: Tarif lebih tinggi

### Opsi 3: Paket Parkir
- Harian: Rp 50.000
- Mingguan: Rp 300.000
- Bulanan: Rp 1.000.000
