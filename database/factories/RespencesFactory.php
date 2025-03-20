<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Tickets;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Respences>
 */
class RespencesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => Tickets::inRandomOrder()->first()->id ?? Tickets::factory(),
            'user_id' => User::where('role', 'agent')->inRandomOrder()->first()->id ?? User::factory(),
            'message' => $this->faker->text(200),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
