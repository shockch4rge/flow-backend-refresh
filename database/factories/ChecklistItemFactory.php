<?php

namespace Database\Factories;

use App\Models\Components\Checklist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChecklistItem>
 */
class ChecklistItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "checklist_id" => Checklist::all()->random()->id,
            "name" => $this->faker->word,
            "checked" => $this->faker->boolean,
            "dueDate" => $this->faker->dateTime,
        ];
    }
}
