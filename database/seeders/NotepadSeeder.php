<?php

namespace Database\Seeders;

use App\Models\Components\Notepad;
use Illuminate\Database\Seeder;

class NotepadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notepad::factory()->count(10)->create();
    }
}
