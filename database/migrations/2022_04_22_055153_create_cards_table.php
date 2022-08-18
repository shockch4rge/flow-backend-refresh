<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->text("description")->nullable();
            $table->integer("folder_index")->default(0);

            $table->dateTime("due_date")->nullable();

            $table->timestamps();
            $table->foreignUuid("folder_id")->constrained("folders")->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
};
