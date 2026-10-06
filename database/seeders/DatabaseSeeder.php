<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Console;
use App\Models\Game;
use App\Models\MaintenanceLog;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\RentalItem;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin & Staff Users
        $admin = User::create([
            'name' => 'Muhammad Ixmal Alimudin',
            'email' => 'ixmal@rentps.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Ahmad Yani KM 36, Banjarbaru',
        ]);

        UserProfile::create([
            'user_id' => $admin->id,
            'nik' => '6371012809900001',
            'emergency_contact' => '089876543210',
            'bio' => 'Owner & Administrator RentPS System',
            'avatar_url' => 'https://avatars.githubusercontent.com/u/204449595?v=4',
        ]);

        // Create 3 Customer Users with Profiles
        $customers = User::factory(3)->create(['role' => 'customer']);
        foreach ($customers as $customer) {
            UserProfile::factory()->create(['user_id' => $customer->id]);
        }

        // 2. Create Console Categories
        $categoriesData = [
            [
                'name' => 'PlayStation 4 Slim',
                'slug' => 'ps4-slim',
                'description' => 'Konsol PS4 Slim hemat daya dengan koleksi game terlengkap',
                'base_daily_rate' => 50000.00,
            ],
            [
                'name' => 'PlayStation 4 Pro',
                'slug' => 'ps4-pro',
                'description' => 'Konsol PS4 Pro mendukung grafis 4K HDR',
                'base_daily_rate' => 75000.00,
            ],
            [
                'name' => 'PlayStation 5 Digital Edition',
                'slug' => 'ps5-digital',
                'description' => 'Konsol generasi terbaru ultra-fast SSD 120fps',
                'base_daily_rate' => 120000.00,
            ],
            [
                'name' => 'PlayStation 5 Disc Edition',
                'slug' => 'ps5-disc',
                'description' => 'Konsol PS5 flagship dengan 4K Ultra HD Blu-ray',
                'base_daily_rate' => 150000.00,
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[] = Category::create($cat);
        }

        // 3. Create Consoles
        $consoles = [];
        $serialCounter = 101;
        foreach ($categories as $cat) {
            for ($i = 1; $i <= 2; $i++) {
                $consoles[] = Console::create([
                    'category_id' => $cat->id,
                    'serial_number' => 'SN-PS-' . $serialCounter++,
                    'name' => $cat->name . ' Unit #' . $i,
                    'status' => 'available',
                    'daily_rate' => $cat->base_daily_rate,
                    'condition' => 'excellent',
                ]);
            }
        }

        // 4. Create Games Catalog
        $gamesData = [
            ['title' => 'eFootball 2026', 'publisher' => 'Konami', 'genre' => 'Sports', 'min_age_rating' => 3, 'storage_req_gb' => 45],
            ['title' => 'EA Sports FC 26', 'publisher' => 'EA Sports', 'genre' => 'Sports', 'min_age_rating' => 3, 'storage_req_gb' => 60],
            ['title' => 'God of War Ragnarok', 'publisher' => 'Sony Interactive', 'genre' => 'Action-Adventure', 'min_age_rating' => 18, 'storage_req_gb' => 110],
            ['title' => 'Grand Theft Auto V', 'publisher' => 'Rockstar Games', 'genre' => 'Open World', 'min_age_rating' => 18, 'storage_req_gb' => 95],
            ['title' => 'Tekken 8', 'publisher' => 'Bandai Namco', 'genre' => 'Fighting', 'min_age_rating' => 13, 'storage_req_gb' => 80],
            ['title' => 'Gran Turismo 7', 'publisher' => 'Sony Interactive', 'genre' => 'Racing', 'min_age_rating' => 3, 'storage_req_gb' => 110],
        ];

        $games = [];
        foreach ($gamesData as $g) {
            $games[] = Game::create($g);
        }

        // 5. Attach Games to Consoles (Pivot table console_game)
        foreach ($consoles as $console) {
            $selectedGames = collect($games)->random(3);
            foreach ($selectedGames as $game) {
                $console->games()->attach($game->id, [
                    'installed_at' => now()->subDays(rand(1, 30)),
                    'storage_size_gb' => $game->storage_req_gb,
                ]);
            }
        }

        // 6. Create Maintenance Logs for Consoles
        foreach (array_slice($consoles, 0, 3) as $console) {
            MaintenanceLog::create([
                'console_id' => $console->id,
                'service_date' => now()->subWeeks(2)->toDateString(),
                'technician_name' => 'Budi Service Station',
                'cost' => 150000.00,
                'issue_description' => 'Pembersihan debu kipas pendingin dan penggantian stik controller #2',
                'action_taken' => 'Deep cleaning, ganti kompot stik analog DualSense',
            ]);
        }

        // 7. Create Sample Rental Transactions & Payments
        foreach ($customers as $index => $customer) {
            $rentedConsole = $consoles[$index];
            $rentedConsole->update(['status' => 'rented']);

            $rental = Rental::create([
                'rental_code' => 'RNT-202610' . sprintf('%03d', $index + 1),
                'user_id' => $customer->id,
                'start_time' => now(),
                'end_time' => now()->addDays(2),
                'total_price' => $rentedConsole->daily_rate * 2,
                'deposit_amount' => 50000.00,
                'status' => 'active',
            ]);

            RentalItem::create([
                'rental_id' => $rental->id,
                'console_id' => $rentedConsole->id,
                'duration_days' => 2,
                'daily_rate_snapshot' => $rentedConsole->daily_rate,
                'subtotal' => $rentedConsole->daily_rate * 2,
                'late_fee' => 0.00,
            ]);

            Payment::create([
                'payment_code' => 'PAY-202610' . sprintf('%03d', $index + 1),
                'rental_id' => $rental->id,
                'method' => 'qris',
                'amount' => $rental->total_price + $rental->deposit_amount,
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }
    }
}
