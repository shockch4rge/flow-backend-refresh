<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "folder_id" => Folder::all()->random()->id,
            "name" => $this->faker->word,
            "description" => $this->faker->sentence(),
        ];
    }

    // override this method to set folder indexes after all cards are created,
    // as we can't do that in the definition() method
    protected function callAfterMaking(Collection $instances, ?Model $parent = null)
    {
        $instances->each(function (Card $card){
            $card->folder_index = Card::where('folder_id', $card->folder_id)->count();
            $card->save();
        });
    }
}
