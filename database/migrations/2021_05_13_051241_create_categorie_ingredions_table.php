<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieIngredionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorie_ingredions', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamps();

            $table->unsignedBigInteger('categorie_unite_id');

            $table->foreign('categorie_unite_id')->references('id')->on('categorie_unites')
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
        Schema::dropIfExists('categorie_ingredions');
    }
}
