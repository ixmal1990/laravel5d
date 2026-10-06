# SmartKost — Sistem Informasi Manajemen Sewa Kost & Kontrakan

> **Tugas 1 (Assignment 1)**: Database Design and Table Relationships  
> **Mata Kuliah**: Pemrograman Berbasis Objek 2 (PBO 2) / Laravel Framework  
> **Dosen Pengampu**: Mirza Yogy Utama  

---

## 👤 Identitas Mahasiswa

| Informasi | Detail |
|---|---|
| **Nama** | Muhammad Ixmal Alimudin |
| **NPM** | 2410010280 |
| **Kelas** | TI 5D REG BJB |
| **Repositori Fork** | [ixmal1990/laravel5d](https://github.com/ixmal1990/laravel5d) |
| **Upstream Repositori** | [mirzayogy/laravel5d](https://github.com/mirzayogy/laravel5d) |

---

## 📌 Ringkasan Proyek

**SmartKost** adalah aplikasi sistem informasi berbasis web yang dirancang menggunakan framework Laravel 11/12 untuk mengelola bisnis persewaan rumah kost dan kontrakan. Sistem ini memfasilitasi pencatatan lokasi properti, kategori tipe hunian, kamar sewa, katalog fasilitas kamar, transaksi kontrak sewa (*lease*), tagihan pembayaran bulanan, hingga pengajuan perbaikan/perawatan kamar (*maintenance requests*).

---

## 🗄️ Daftar Entitas & Tabel Database

Sistem ini memiliki **10 tabel database** yang saling terhubung:

1. **`users`**: Data pengguna (Owner, Tenant, Staff).
2. **`user_profiles`**: Profil detail pengguna (NIK, kontak darurat, pekerjaan, avatar).
3. **`property_types`**: Kategori tipe hunian (Kost Putra, Kost Putri, Kost Exclusive, Kontrakan Rumah).
4. **`properties`**: Lokasi properti kost (nama properti, pemilik/owner, alamat, aturan kost).
5. **`rooms`**: Unit kamar sewa (nomor kamar, tipe kamar, tarif sewa bulanan, status kamar).
6. **`facilities`**: Katalog fasilitas kamar (AC, Wi-Fi 100Mbps, Kamar Mandi Dalam, Water Heater).
7. **`facility_room`**: Tabel pivot N:M antara kamar & fasilitas (`condition`, `installed_at`).
8. **`leases`**: Kontrak transaksi sewa (kode kontrak, penyewa/tenant, kamar, tanggal sewa, deposit).
9. **`payments`**: Transaksi pembayaran sewa (periode bulan, metode pembayaran, jumlah, status).
10. **`maintenance_requests`**: Tiket pengaduan keluhan & perbaikan kamar oleh penyewa.

---

## 🔗 Matriks Relasi Eloquent

| Relasi | Model Asal | Model Tujuan | Jenis Relasi | Keterangan |
|---|---|---|---|---|
| 1 | `User` | `UserProfile` | **One-to-One (1:1)** | Profil pengguna terhubung 1:1 dengan User |
| 2 | `PropertyType` | `Property` | **One-to-Many (1:N)** | Kategori tipe hunian membawahi banyak properti |
| 3 | `User` (Owner) | `Property` | **One-to-Many (1:N)** | Pemilik (*Owner*) memiliki banyak lokasi properti |
| 4 | `Property` | `Room` | **One-to-Many (1:N)** | Lokasi properti memiliki banyak unit kamar |
| 5 | `Room` | `Facility` | **Many-to-Many (N:M)** | Kamar dilengkapi fasilitas melalui `facility_room` |
| 6 | `User` (Tenant) | `Lease` | **One-to-Many (1:N)** | Penyewa (*Tenant*) memiliki kontrak transaksi sewa |
| 7 | `Lease` | `Payment` | **One-to-Many (1:N)** | Kontrak sewa memiliki catatan tagihan pembayaran |
| 8 | `User` | `Payment` | **Has-Many-Through** | Mengakses pembayaran Penyewa melalui kontrak Lease |
| 9 | `Property` | `Lease` | **Has-Many-Through** | Mengakses kontrak sewa di Properti melalui unit Room |
| 10 | `Room` | `MaintenanceRequest` | **One-to-Many (1:N)** | Kamar memiliki tiket keluhan perbaikan |

---

## 📄 Dokumentasi Terkait

- **Diagram ERD (Mermaid)**: [`docs/database/erd.md`](docs/database/erd.md)
- **Laporan Progres P01**: [`docs/progress/P01-database-design.md`](docs/progress/P01-database-design.md)
- **Panduan Fork & Pull Request**: [`docs/FORK_GUIDE.md`](docs/FORK_GUIDE.md)

---

## 🧪 Cara Verifikasi & Pengujian

Jalankan perintah berikut di terminal:

```bash
# 1. Jalankan migrasi dan seeder
php artisan migrate:fresh --seed

# 2. Jalankan pengujian otomatis untuk relasi database
php artisan test --filter=DatabaseRelationshipsTest
```
