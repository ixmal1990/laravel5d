# Entity Relationship Diagram (ERD) — SmartKost (Kost & Property Management System)

> **Proyek**: SmartKost — Sistem Informasi Manajemen Sewa Kost & Kontrakan  
> **Mahasiswa**: Muhammad Ixmal Alimudin  
> **NPM**: 2410010280  
> **Kelas**: TI 5D REG BJB  
> **Mata Kuliah**: Pemrograman Berbasis Objek 2 (PBO 2) / Laravel Framework  

---

## 1. Diagram ERD (Mermaid)

```mermaid
erDiagram
    users ||--o| user_profiles : "has one (1:1)"
    users ||--o{ properties : "owns (1:N)"
    users ||--o{ leases : "holds as tenant (1:N)"
    users ||--o{ payments : "has through leases (HasManyThrough)"
    users ||--o{ maintenance_requests : "submits (1:N)"
    
    property_types ||--o{ properties : "classifies (1:N)"
    properties ||--o{ rooms : "contains (1:N)"
    properties ||--o{ leases : "has through rooms (HasManyThrough)"
    
    rooms ||--o{ facility_room : "equipped in (N:M)"
    facilities ||--o{ facility_room : "installed on (N:M)"
    
    rooms ||--o{ leases : "leased in (1:N)"
    rooms ||--o{ maintenance_requests : "has (1:N)"
    
    leases ||--o{ payments : "billed with (1:N)"

    users {
        bigint id PK
        string name
        string email UK
        string password
        string role "owner|tenant|staff"
        string phone
        text address
    }

    user_profiles {
        bigint id PK
        bigint user_id FK,UK
        string nik UK
        string emergency_contact
        string occupation
        text bio
        string avatar_url
    }

    property_types {
        bigint id PK
        string name UK
        string slug UK
        text description
    }

    properties {
        bigint id PK
        bigint property_type_id FK
        bigint owner_id FK
        string name
        text address
        string city
        text description
        text rules
    }

    rooms {
        bigint id PK
        bigint property_id FK
        string room_number
        string room_type
        decimal monthly_rate
        enum status "available|occupied|maintenance"
        int size_m2
    }

    facilities {
        bigint id PK
        string name UK
        string icon
        text description
    }

    facility_room {
        bigint id PK
        bigint room_id FK
        bigint facility_id FK
        string condition
        timestamp installed_at
    }

    leases {
        bigint id PK
        string lease_code UK
        bigint tenant_id FK
        bigint room_id FK
        date start_date
        date end_date
        decimal monthly_rent_snapshot
        decimal deposit_amount
        enum status "pending|active|completed|terminated"
    }

    payments {
        bigint id PK
        string payment_code UK
        bigint lease_id FK
        string period_month
        decimal amount
        enum method "cash|qris|bank_transfer|e_wallet"
        enum status "pending|paid|late|refunded"
        timestamp paid_at
    }

    maintenance_requests {
        bigint id PK
        string ticket_code UK
        bigint room_id FK
        bigint tenant_id FK
        string title
        text description
        enum priority "low|medium|high"
        enum status "open|in_progress|resolved"
        timestamp resolved_at
    }
```

---

## 2. Deskripsi Ringkas Entitas & Relasi

| No | Relasi | Tipe | Penjelasan |
|---|---|---|---|
| 1 | `User` <-> `UserProfile` | **One-to-One (1:1)** | Pengguna memiliki 1 UserProfile (NIK, nomor darurat, pekerjaan, avatar). |
| 2 | `PropertyType` <-> `Property` | **One-to-Many (1:N)** | Kategori properti (Kost Putra, Kost Putri, Kost Exclusive, dsb.) membawahi banyak properti. |
| 3 | `User` (Owner) <-> `Property` | **One-to-Many (1:N)** | Pemilik (*Owner*) dapat memiliki banyak lokasi properti kost. |
| 4 | `Property` <-> `Room` | **One-to-Many (1:N)** | Satu lokasi properti kost memiliki banyak unit kamar (*Room*). |
| 5 | `Room` <-> `Facility` | **Many-to-Many (N:M)** | Kamar dilengkapi fasilitas melalui `facility_room` dengan atribut pivot `condition` dan `installed_at`. |
| 6 | `User` (Tenant) <-> `Lease` | **One-to-Many (1:N)** | Penyewa (*Tenant*) memiliki kontrak sewa (*Lease*). |
| 7 | `Room` <-> `Lease` | **One-to-Many (1:N)** | Unit kamar disewakan dalam banyak riwayat kontrak sewa. |
| 8 | `Lease` <-> `Payment` | **One-to-Many (1:N)** | Kontrak sewa memiliki pembayaran tagihan bulanan (*Payment*). |
| 9 | `User` <-> `Payment` | **Has-Many-Through** | Mengakses seluruh pembayaran milik Penyewa melalui kontrak `Lease`. |
| 10 | `Property` <-> `Lease` | **Has-Many-Through** | Mengakses seluruh kontrak sewa di suatu Properti melalui unit `Room`. |
| 11 | `Room` <-> `MaintenanceRequest` | **One-to-Many (1:N)** | Unit kamar memiliki tiket pengaduan/keluhan perbaikan dari penghuni. |
