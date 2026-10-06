<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'publisher' => $this->faker->company(),
            'genre' => $this->faker->randomElement(['Sports', 'Action', 'RPG', 'Racing', 'Fighting']),
            'min_age_rating' => $this->faker->randomElement([3, 7, 13, 18]),
            'storage_req_gb' => $this->faker->numberBetween(30, 150),
        ];
    }
}
