<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_tag', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignUuid("card_id")->constrained("cards")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid("tag_id")->constrained("tags")->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_tag');
    }
}
