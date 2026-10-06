# Progress Report Phase P01 — Database Design and Table Relationships

## Identity

| Information | Detail |
|---|---|
| **Student Name** | Muhammad Ixmal Alimudin |
| **NPM** | 2410010280 |
| **Class** | TI 5D REG BJB |
| **Project Title** | RentPS — Sistem Informasi Penyewaan PlayStation & Console Gaming |
| **Phase** | P01: Database Design and Table Relationships |
| **Status** | ✅ Done (2026-10-06) |
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
2. **`Category` 1:N `Console`** (`hasMany` & `belongsTo`)
3. **`Console` N:M `Game`** (`belongsToMany` via `console_game` with pivot columns `installed_at`, `storage_size_gb`)
4. **`User` 1:N `Rental`** (`hasMany` & `belongsTo`)
5. **`Rental` N:M `Console`** (`belongsToMany` via `rental_items` with pivot columns `duration_days`, `subtotal`, `late_fee`)
6. **`Rental` 1:1 `Payment`** (`hasOne` & `belongsTo`)
7. **`User` Has-Many-Through `Payment`** (`hasManyThrough` via `Rental`)
8. **`Category` Has-Many-Through `RentalItem`** (`hasManyThrough` via `Console`)
9. **`Console` 1:N `MaintenanceLog`** (`hasMany` & `belongsTo`)

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

- Authentication system & role authorization (Admin vs Customer).
- CRUD views & controller logic for Consoles, Categories, and Games catalog.
- Rental booking workflow & QRIS payment processing simulation.
