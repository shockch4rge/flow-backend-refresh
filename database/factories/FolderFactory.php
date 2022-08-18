<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Folder>
 */
class FolderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "board_id" => Board::all()->random()->id,
            "name" => $this->faker->word,
            "description" => $this->faker->sentence,
        ];
    }

    protected function callAfterMaking(Collection $instances, ?Model $parent = null)
    {
        $instances->each(function (Folder $folder){
            $folder->board_index = Folder::where('board_id', $folder->board_id)->count();
            $folder->save();
        });
    }
}
