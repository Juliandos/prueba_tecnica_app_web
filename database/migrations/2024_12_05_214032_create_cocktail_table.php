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
        Schema::create('cocktail', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('alcoholica')->nullable();
            $table->string('vaso')->nullable();
            $table->string('ruta_imagen')->nullable();
            $table->string('categoria')->nullable();
            $table->text('instrucciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cocktail');
    }
};
