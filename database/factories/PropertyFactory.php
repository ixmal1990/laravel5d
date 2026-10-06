<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'property_type_id' => PropertyType::factory(),
            'owner_id' => User::factory()->state(['role' => 'owner']),
            'name' => 'SmartKost ' . $this->faker->city() . ' ' . $this->faker->streetName(),
            'address' => $this->faker->address(),
            'city' => 'Banjarbaru',
            'description' => $this->faker->paragraph(),
            'rules' => '1. Dilarang membawa hewan peliharaan. 2. Jam malam pukul 23:00 WITA.',
        ];
    }
}
