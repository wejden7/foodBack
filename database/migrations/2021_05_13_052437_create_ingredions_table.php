<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredions', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('image');
            $table->timestamps();

            $table->unsignedBigInteger('categorie_id');

            $table->foreign('categorie_id')->references('id')->on('categorie_ingredions')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredions');
    }
}
