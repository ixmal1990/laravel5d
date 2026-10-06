# Entity Relationship Diagram (ERD) — RentPS (PlayStation Rental System)

> **Proyek**: RentPS — Sistem Informasi Penyewaan PlayStation & Console Gaming  
> **Mahasiswa**: Muhammad Ixmal Alimudin  
> **NPM**: 2410010280  
> **Kelas**: TI 5D REG BJB  
> **Mata Kuliah**: Pemrograman Berbasis Objek 2 (PBO 2) / Laravel Framework  

---

## 1. Diagram ERD (Mermaid)

```mermaid
erDiagram
    users ||--o| user_profiles : "has one (1:1)"
    users ||--o{ rentals : "places (1:N)"
    users ||--o{ payments : "has through rentals (HasManyThrough)"
    
    categories ||--o{ consoles : "classifies (1:N)"
    categories ||--o{ rental_items : "has through consoles (HasManyThrough)"
    
    consoles ||--o{ console_game : "installed in (N:M)"
    games ||--o{ console_game : "installed on (N:M)"
    
    consoles ||--o{ maintenance_logs : "undergoes (1:N)"
    consoles ||--o{ rental_items : "rented in (1:N)"
    
    rentals ||--o{ rental_items : "contains (1:N)"
    rentals ||--o| payments : "paid with (1:1)"

    users {
        bigint id PK
        string name
        string email UK
        string password
        string role "admin|customer|staff"
        string phone
        text address
    }

    user_profiles {
        bigint id PK
        bigint user_id FK,UK
        string nik UK
        string emergency_contact
        text bio
        string avatar_url
    }

    categories {
        bigint id PK
        string name UK
        string slug UK
        text description
        decimal base_daily_rate
    }

    consoles {
        bigint id PK
        bigint category_id FK
        string serial_number UK
        string name
        enum status "available|rented|maintenance"
        decimal daily_rate
        string condition
    }

    games {
        bigint id PK
        string title
        string publisher
        string genre
        int min_age_rating
        int storage_req_gb
    }

    console_game {
        bigint id PK
        bigint console_id FK
        bigint game_id FK
        timestamp installed_at
        int storage_size_gb
    }

    rentals {
        bigint id PK
        string rental_code UK
        bigint user_id FK
        datetime start_time
        datetime end_time
        decimal total_price
        decimal deposit_amount
        enum status "pending|active|completed|late|cancelled"
    }

    rental_items {
        bigint id PK
        bigint rental_id FK
        bigint console_id FK
        int duration_days
        decimal daily_rate_snapshot
        decimal subtotal
        decimal late_fee
    }

    payments {
        bigint id PK
        string payment_code UK
        bigint rental_id FK,UK
        enum method "cash|qris|bank_transfer|e_wallet"
        decimal amount
        enum status "pending|paid|failed|refunded"
        timestamp paid_at
    }

    maintenance_logs {
        bigint id PK
        bigint console_id FK
        date service_date
        string technician_name
        decimal cost
        text issue_description
        text action_taken
    }
```

---

## 2. Deskripsi Ringkas Entitas & Relasi

| No | Relasi | Tipe | Penjelasan |
|---|---|---|---|
| 1 | `User` <-> `UserProfile` | **One-to-One (1:1)** | Setiap User memiliki 1 UserProfile detail (NIK, kontak darurat, bio, foto). |
| 2 | `Category` <-> `Console` | **One-to-Many (1:N)** | Kategori konsol (PS4 Slim, PS5 Disc, dsb.) membawahi banyak unit konsol fisik. |
| 3 | `Console` <-> `Game` | **Many-to-Many (N:M)** | Konsol memiliki banyak Game terinstall melalui tabel pivot `console_game` yang menyimpan `installed_at` dan `storage_size_gb`. |
| 4 | `User` <-> `Rental` | **One-to-Many (1:N)** | Pelanggan dapat melakukan banyak transaksi penyewaan. |
| 5 | `Rental` <-> `Console` | **Many-to-Many (N:M)** | Penyewaan mencakup konsol melalui tabel pivot `rental_items` dengan data `duration_days`, `subtotal`, dan `late_fee`. |
| 6 | `Rental` <-> `Payment` | **One-to-One (1:1)** | Setiap transaksi penyewaan memiliki 1 catatan pembayaran. |
| 7 | `User` <-> `Payment` | **Has-Many-Through** | Mengakses riwayat pembayaran milik User melalui transaksi `Rental`. |
| 8 | `Category` <-> `RentalItem` | **Has-Many-Through** | Mengakses statistik penyewaan item berdasarkan `Category` konsol. |
| 9 | `Console` <-> `MaintenanceLog` | **One-to-Many (1:N)** | Satu unit konsol dapat memiliki banyak rekam medis/log perawatan teknisi. |
