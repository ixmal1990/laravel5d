# RentPS — Sistem Informasi Penyewaan PlayStation & Console Gaming

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

**RentPS** adalah aplikasi sistem informasi berbasis web yang dirancang menggunakan framework Laravel 11/12 untuk mengelola bisnis penyewaan konsol gim (PlayStation 4, PlayStation 5, VR). Sistem ini memfasilitasi pencatatan inventaris unit konsol, katalog gim terinstall, transaksi penyewaan oleh pelanggan, pembayaran digital, hingga riwayat perawatan unit (*maintenance logs*).

---

## 🗄️ Daftar Entitas & Tabel Database

Sistem ini memiliki **10 tabel database** yang saling terhubung:

1. **`users`**: Data pengguna (Admin, Staff, Customer).
2. **`user_profiles`**: Profil detail pengguna (NIK, nomor darurat, bio, avatar).
3. **`categories`**: Kategori konsol (PS4 Slim, PS4 Pro, PS5 Digital, PS5 Disc).
4. **`consoles`**: Unit konsol fisik (Serial Number, nama unit, status, tarif sewa harian).
5. **`games`**: Katalog gim gim PlayStation (judul, publisher, genre, spesifikasi storage).
6. **`console_game`**: Tabel pivot N:M antara konsol & gim (`installed_at`, `storage_size_gb`).
7. **`rentals`**: Transaksi penyewaan (kode rental, pelanggan, periode sewa, total harga, status).
8. **`rental_items`**: Detail item rental / pivot N:M antara rental & konsol (`duration_days`, `subtotal`, `late_fee`).
9. **`payments`**: Transaksi pembayaran penyewaan (metode pembayaran, jumlah, status, waktu bayar).
10. **`maintenance_logs`**: Catatan servis & pemeliharaan unit konsol.

---

## 🔗 Matriks Relasi Eloquent

| Relasi | Model Asal | Model Tujuan | Jenis Relasi | Keterangan |
|---|---|---|---|---|
| 1 | `User` | `UserProfile` | **One-to-One (1:1)** | Profil pengguna terhubung 1:1 dengan User |
| 2 | `Category` | `Console` | **One-to-Many (1:N)** | Kategori membawahi banyak unit konsol |
| 3 | `Console` | `Game` | **Many-to-Many (N:M)** | Konsol memiliki banyak gim melalui `console_game` |
| 4 | `User` | `Rental` | **One-to-Many (1:N)** | Pelanggan dapat membuat banyak transaksi rental |
| 5 | `Rental` | `Console` | **Many-to-Many (N:M)** | Transaksi menyewa banyak konsol melalui `rental_items` |
| 6 | `Rental` | `Payment` | **One-to-One (1:1)** | Setiap transaksi Memiliki 1 catatan pembayaran |
| 7 | `User` | `Payment` | **Has-Many-Through** | Mengakses pembayaran User melalui transaksi Rental |
| 8 | `Category` | `RentalItem` | **Has-Many-Through** | Mengakses rental item dari konsol dalam suatu kategori |
| 9 | `Console` | `MaintenanceLog` | **One-to-Many (1:N)** | Unit konsol memiliki banyak log perawatan |

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
