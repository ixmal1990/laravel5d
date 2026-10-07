# Progress Report Phase P01 — Database Design and Table Relationships

## Identity

| Information | Detail |
|---|---|
| **Student Name** | Muhammad Ixmal Alimudin |
| **NPM** | 2410010280 |
| **Class** | TI 5D REG BJB |
| **Project Title** | SmartKost — Sistem Informasi Manajemen Sewa Kost & Kontrakan |
| **Phase** | P01: Database Design and Table Relationships |
| **Status** | ✅ Done (2026-10-07) |
| **Target Repository** | `mirzayogy/laravel5d` |
| **Fork Repository** | `ixmal1990/laravel5d` |

---

## 1. Job Progress Summary

| Job ID | Task / Work Description | Status | Proof / Location |
|---|---|---|---|
| **J1** | Database design, entity relationship definitions & Mermaid ERD | ✅ Done | [`docs/database/erd.md`](../database/erd.md) |
| **J2** | Database migrations for 10 tables (including pivot tables & schema definitions) | ✅ Done | [`database/migrations`](../../database/migrations) |
| **J3** | Eloquent models & relationship methods (1:1, 1:N, N:M with pivot attributes, HasManyThrough) | ✅ Done | [`app/Models`](../../app/Models) |
| **J4** | Factories and Seeder for complete realistic dataset | ✅ Done | [`database/factories`](../../database/factories), [`database/seeders/DatabaseSeeder.php`](../../database/seeders/DatabaseSeeder.php) |
| **J5** | Automated feature unit tests verifying all Eloquent relationships | ✅ Done | [`tests/Feature/DatabaseRelationshipsTest.php`](../../tests/Feature/DatabaseRelationshipsTest.php) |
| **J6** | README, progress report, & fork submission guide | ✅ Done | [`README.md`](../../README.md), [`docs/FORK_GUIDE.md`](../FORK_GUIDE.md) |

---

## 2. Implemented Eloquent Relationships

1. **`User` 1:1 `UserProfile`** (`hasOne` & `belongsTo`)
2. **`PropertyType` 1:N `Property`** (`hasMany` & `belongsTo`)
3. **`User` (Owner) 1:N `Property`** (`hasMany` & `belongsTo`)
4. **`Property` 1:N `Room`** (`hasMany` & `belongsTo`)
5. **`Room` N:M `Facility`** (`belongsToMany` via `facility_room` with pivot columns `condition`, `installed_at`)
6. **`User` (Tenant) 1:N `Lease`** (`hasMany` & `belongsTo`)
7. **`Lease` 1:N `Payment`** (`hasMany` & `belongsTo`)
8. **`User` Has-Many-Through `Payment`** (`hasManyThrough` via `Lease`)
9. **`Property` Has-Many-Through `Lease`** (`hasManyThrough` via `Room`)
10. **`Room` 1:N `MaintenanceRequest`** (`hasMany` & `belongsTo`)

---

## 3. How to Verify Implementation

Run the following commands in terminal:

```bash
# 1. Run fresh migrations with initial seed data
php artisan migrate:fresh --seed

# 2. Run automated test suite verifying all relationships
php artisan test --filter=DatabaseRelationshipsTest
```

---

## 4. Next Phase Roadmap (P02)

- Authentication system & role authorization (Owner vs Tenant vs Staff).
- CRUD views & controller logic for Properties, Rooms, and Facilities catalog.
- Monthly rent billing, QRIS payment simulation, and tenant maintenance tickets.
