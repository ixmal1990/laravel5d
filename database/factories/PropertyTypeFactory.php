<?php

namespace Database\Factories;

use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyType>
 */
class PropertyTypeFactory extends Factory
{
    protected $model = PropertyType::class;

    public function definition(): array
    {
        $name = 'Kost ' . $this->faker->unique()->word() . ' Type';
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
        ];
    }
}
