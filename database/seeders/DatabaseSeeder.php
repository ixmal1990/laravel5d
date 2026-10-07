<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Lease;
use App\Models\MaintenanceRequest;
use App\Models\Payment;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Room;
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
        // 1. Create Owner User
        $owner = User::create([
            'name' => 'Muhammad Ixmal Alimudin',
            'email' => 'ixmal@smartkost.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'phone' => '081234567890',
            'address' => 'Jl. Ahmad Yani KM 36, Banjarbaru',
        ]);

        UserProfile::create([
            'user_id' => $owner->id,
            'nik' => '6371012809900001',
            'emergency_contact' => '089876543210',
            'occupation' => 'Pemilik Kost & Pengusaha',
            'bio' => 'Owner & Property Manager SmartKost System',
            'avatar_url' => 'https://avatars.githubusercontent.com/u/204449595?v=4',
        ]);

        // Create 3 Tenant Users with Profiles
        $tenants = User::factory(3)->create(['role' => 'tenant']);
        foreach ($tenants as $tenant) {
            UserProfile::factory()->create(['user_id' => $tenant->id]);
        }

        // 2. Create Property Types
        $typeData = [
            ['name' => 'Kost Putra', 'slug' => 'kost-putra', 'description' => 'Khusus hunian mahasiswa & pekerja pria'],
            ['name' => 'Kost Putri', 'slug' => 'kost-putri', 'description' => 'Khusus hunian mahasiswi & pekerja wanita dengan akses keamanan 24 jam'],
            ['name' => 'Kost Exclusive Campur', 'slug' => 'kost-exclusive', 'description' => 'Kost bebas dengan fasilitas lengkap setara hotel bintang 3'],
            ['name' => 'Kontrakan Rumah', 'slug' => 'kontrakan-rumah', 'description' => 'Rumah sewa keluarga 2-3 kamar tidur'],
        ];

        $propertyTypes = [];
        foreach ($typeData as $t) {
            $propertyTypes[] = PropertyType::create($t);
        }

        // 3. Create Properties
        $property1 = Property::create([
            'property_type_id' => $propertyTypes[2]->id, // Kost Exclusive Campur
            'owner_id' => $owner->id,
            'name' => 'SmartKost Executive Banjarbaru',
            'address' => 'Jl. Uniska No. 12, Sei Besar, Banjarbaru',
            'city' => 'Banjarbaru',
            'description' => 'Kost exclusive terdekat dari kampus UNISKA Banjarbaru dengan fasilitas lengkap, AC, Wi-Fi 100Mbps, dan parkir mobil luas.',
            'rules' => '1. Dilarang merokok di dalam kamar. 2. Tamu berkunjung maksimal pukul 22:00 WITA. 3. Menjaga kebersihan area bersama.',
        ]);

        // 4. Create Rooms
        $roomsData = [
            ['room_number' => 'A-101', 'room_type' => 'Deluxe AC', 'monthly_rate' => 1200000.00, 'status' => 'occupied', 'size_m2' => 16],
            ['room_number' => 'A-102', 'room_type' => 'Deluxe AC', 'monthly_rate' => 1200000.00, 'status' => 'occupied', 'size_m2' => 16],
            ['room_number' => 'A-103', 'room_type' => 'Standard Fan', 'monthly_rate' => 850000.00, 'status' => 'occupied', 'size_m2' => 12],
            ['room_number' => 'B-201', 'room_type' => 'VIP Balcony', 'monthly_rate' => 1600000.00, 'status' => 'available', 'size_m2' => 20],
            ['room_number' => 'B-202', 'room_type' => 'VIP Balcony', 'monthly_rate' => 1600000.00, 'status' => 'maintenance', 'size_m2' => 20],
        ];

        $rooms = [];
        foreach ($roomsData as $r) {
            $r['property_id'] = $property1->id;
            $rooms[] = Room::create($r);
        }

        // 5. Create Facilities & Attach to Rooms (Pivot facility_room)
        $facilityData = [
            ['name' => 'AC 1PK Inverter', 'icon' => 'fa-snowflake', 'description' => 'Pendingin ruangan hemat listrik'],
            ['name' => 'Wi-Fi High-Speed 100Mbps', 'icon' => 'fa-wifi', 'description' => 'Koneksi internet serat optik tanpa kuota'],
            ['name' => 'Kamar Mandi Dalam', 'icon' => 'fa-bath', 'description' => 'Shower & toilet duduk di dalam kamar'],
            ['name' => 'Water Heater', 'icon' => 'fa-shower', 'description' => 'Pemanas air mandi terintegrasi'],
            ['name' => 'Kasur Springbed Queen Size', 'icon' => 'fa-bed', 'description' => 'Kasur nyaman kualitas premium'],
        ];

        $facilities = [];
        foreach ($facilityData as $f) {
            $facilities[] = Facility::create($f);
        }

        foreach ($rooms as $room) {
            $room->facilities()->attach(collect($facilities)->pluck('id')->take(3), [
                'condition' => 'good',
                'installed_at' => now()->subMonths(3),
            ]);
        }

        // 6. Create Leases & Payments for Occupied Rooms
        foreach ($tenants as $index => $tenant) {
            $occupiedRoom = $rooms[$index];

            $lease = Lease::create([
                'lease_code' => 'LSE-202610' . sprintf('%03d', $index + 1),
                'tenant_id' => $tenant->id,
                'room_id' => $occupiedRoom->id,
                'start_date' => now()->startOfMonth()->toDateString(),
                'end_date' => now()->startOfMonth()->addMonths(6)->toDateString(),
                'monthly_rent_snapshot' => $occupiedRoom->monthly_rate,
                'deposit_amount' => 500000.00,
                'status' => 'active',
            ]);

            Payment::create([
                'payment_code' => 'PAY-202610' . sprintf('%03d', $index + 1),
                'lease_id' => $lease->id,
                'period_month' => now()->format('Y-m'),
                'amount' => $lease->monthly_rent_snapshot + $lease->deposit_amount,
                'method' => 'qris',
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        // 7. Create Maintenance Request
        MaintenanceRequest::create([
            'ticket_code' => 'TCK-202610001',
            'room_id' => $rooms[4]->id, // B-202
            'tenant_id' => $tenants[0]->id,
            'title' => 'AC Kurang Dingin & Perlu Servis Freon',
            'description' => 'AC di kamar B-202 terasa hanya menghembuskan angin biasa dan indikator perbaikan menyala.',
            'priority' => 'high',
            'status' => 'in_progress',
            'resolved_at' => null,
        ]);
    }
}
