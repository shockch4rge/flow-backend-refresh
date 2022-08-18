<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->text("content")->required();
            
            $table->timestamps();
            $table->foreignUuid("author_id")->constrained("users")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignUuid("card_id")->constrained("cards")->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};