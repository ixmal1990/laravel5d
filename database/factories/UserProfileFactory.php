<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserProfile>
 */
class UserProfileFactory extends Factory
{
    protected $model = UserProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nik' => $this->faker->numerify('6371############'),
            'emergency_contact' => $this->faker->phoneNumber(),
            'occupation' => $this->faker->randomElement(['Mahasiswa UNISKA', 'Karyawan Swasta', 'PNS', 'Wirausaha']),
            'bio' => $this->faker->sentence(),
            'avatar_url' => 'https://i.pravatar.cc/150?u=' . $this->faker->uuid(),
        ];
    }
}
