# Panduan Commit, Push, dan Pull Request (GitHub Fork Guide)

Panduan ini berisi langkah-langkah untuk melakukan commit, push ke repositori fork `ixmal1990/laravel5d`, dan mengirimkan **Pull Request (PR)** ke repositori induk `mirzayogy/laravel5d`.

---

## 1. Persiapan Identitas Git Local

Buka terminal dan pastikan identitas Git sesuai dengan akun GitHub Anda:

```bash
git config --global user.name "ixmal1990"
git config --global user.email "ixmal1990@gmail.com"
```

---

## 2. Membuat Branch Fitur

Buat branch baru dengan nama `feature/database-relations`:

```bash
git checkout -b feature/database-relations
```

---

## 3. Commit Perubahan

Tambahkan seluruh file yang baru dibuat dan lakukan commit:

```bash
git add .
git commit -m "[Assignment 1] Table Relationships: SmartKost Management - Muhammad Ixmal Alimudin - 2410010280 - TI 5D REG BJB"
```

---

## 4. Push Branch ke GitHub Fork

Push branch `feature/database-relations` ke repositori `ixmal1990/laravel5d`:

```bash
git push -u origin feature/database-relations
```

---

## 5. Membuat Pull Request (PR) ke Upstream

1. Buka halaman GitHub fork Anda: [https://github.com/ixmal1990/laravel5d](https://github.com/ixmal1990/laravel5d).
2. Klik tombol **Compare & pull request** di atas branch `feature/database-relations`.
3. Pastikan **Base repository** mengarah ke `mirzayogy/laravel5d` branch `main`.
4. Isi judul PR:
   ```text
   [Assignment 1] Table Relationships: SmartKost Management - Muhammad Ixmal Alimudin - 2410010280 - TI 5D REG BJB
   ```
5. Salin dan tempel format deskripsi PR berikut:

```markdown
## Assignment
Assignment 1: Table Relationships (SmartKost — Sistem Informasi Manajemen Sewa Kost & Kontrakan).

| | |
|---|---|
| **Student** | Muhammad Ixmal Alimudin |
| **NPM** | 2410010280 |
| **Class** | TI 5D REG BJB |
| **Phase** | P01: Database Design and Table Relationships |
| **Status** | ✅ Done (2026-10-06) |
| **Fork / branch** | [ixmal1990/laravel5d (feature/database-relations)](https://github.com/ixmal1990/laravel5d/tree/feature/database-relations) |

## What was done
| Job | Description | Status |
|---|---|---|
| J1 | Database design & ERD (SmartKost Management) | ✅ Done |
| J2 | Migrations & schema definitions (10 tables) | ✅ Done |
| J3 | Models & Eloquent relationships (10 relationship types tested) | ✅ Done |
| J4 | Factories & seeders (PropertyTypes, Properties, Rooms, Facilities, Leases, Payments, Tickets) | ✅ Done |
| J5 | Automated Feature Test Suite & progress report | ✅ Done |

## Proof
- Progress report: [`docs/progress/P01-database-design.md`](https://github.com/ixmal1990/laravel5d/blob/feature/database-relations/docs/progress/P01-database-design.md)
- ERD documentation: [`docs/database/erd.md`](https://github.com/ixmal1990/laravel5d/blob/feature/database-relations/docs/database/erd.md)
- Relationship unit/feature test suite: [`tests/Feature/DatabaseRelationshipsTest.php`](https://github.com/ixmal1990/laravel5d/blob/feature/database-relations/tests/Feature/DatabaseRelationshipsTest.php)

## How to verify
```bash
php artisan migrate:fresh --seed
php artisan test
```
```

6. Klik tombol **Create pull request**.
