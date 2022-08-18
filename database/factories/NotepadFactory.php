<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notepad>
 */
class NotepadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "card_id" => Card::all()->random()->id,
            "title" => $this->faker->sentence,
            "description" => $this->faker->paragraph,
        ];
    }
}
