<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardLabel>
 */
class CardLabelFactory extends Factory
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
            "name" => $this->faker->word(),
            "colorCode" => $this->faker->hexColor(),
        ];
    }
}
