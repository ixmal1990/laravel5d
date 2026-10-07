# Progress Report Phase P01 — Database Design and Table Relationships

## Assignment

**Assignment 1: Table Relationships** for SmartKost Management (Laravel, Blade).

| | |
|---|---|
| **Student** | Muhammad Ixmal Alimudin |
| **NPM** | 2410010280 |
| **Class** | TI 5D REG BJB |
| **Phase** | P01: Database Design and Table Relationships |
| **Status** | ✅ Done (2026-10-07) |
| **Fork / branch** | [ixmal1990/laravel5d](https://github.com/ixmal1990/laravel5d/tree/feature/database-relations) · `feature/database-relations` |

## What was done

| Job | Description | Status |
|---|---|---|
| J1 | Database design and ERD with Mermaid | ✅ Done |
| J2 | Migrations: 10 tables plus pivot tables | ✅ Done |
| J3 | Eloquent models and relationships | ✅ Done |
| J4 | Factories and seeders | ✅ Done |
| J5 | README and fork guide | ✅ Done |

Relationship types covered: One-to-One, One-to-Many, Many-to-Many, Many-to-Many with pivot data (`condition`, `installed_at`), and Has-Many-Through.

## Proof
- Progress report with proof for every job: [`docs/progress/P01-database-design.md`](https://github.com/ixmal1990/laravel5d/blob/feature/database-relations/docs/progress/P01-database-design.md)
- ERD: [`docs/database/erd.md`](https://github.com/ixmal1990/laravel5d/blob/feature/database-relations/docs/database/erd.md)
- Migrations: [`database/migrations`](https://github.com/ixmal1990/laravel5d/tree/feature/database-relations/database/migrations)
- Models: [`app/Models`](https://github.com/ixmal1990/laravel5d/tree/feature/database-relations/app/Models)
- Factories and seeders: [`database/factories`](https://github.com/ixmal1990/laravel5d/tree/feature/database-relations/database/factories), [`database/seeders`](https://github.com/ixmal1990/laravel5d/tree/feature/database-relations/database/seeders)

## How to verify
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
```

## Not done yet
- Automated tests
- Authentication, CRUD pages, and dashboard (planned for the next phases)
