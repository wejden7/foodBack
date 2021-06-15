<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment');
            $table->bigInteger("id_repondre")->nullable();
            $table->enum('type', array('comment', 'repondre',));
            $table->timestamps();

            $table->unsignedBigInteger('post_id');

            $table->foreign('post_id')->references('id')->on('posts')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('comments');
    }
}
