<?php

namespace Database\Factories;

use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlayerNote>
 */
class PlayerNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PlayerNote::class;

    public function definition(): array
    {
        return [
            'player_id' => User::factory(),
            'author_id' => User::factory(),
            'content' => $this->faker->paragraphs(3, true),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }

    public function fromAgent(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'author_id' => User::factory()->create(['role' => 'support_agent'])
            ];
        });
    }

    public function recent(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });
    }
}
