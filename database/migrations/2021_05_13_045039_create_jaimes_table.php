<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJaimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jaimes', function (Blueprint $table) {

            $table->unsignedBigInteger('post_id');

            $table->foreign('post_id')->references('id')->on('posts')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            
            $table->primary(['post_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jaimes');
    }
}
