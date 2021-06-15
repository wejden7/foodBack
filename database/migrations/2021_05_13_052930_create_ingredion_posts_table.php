<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredionPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredion_posts', function (Blueprint $table) {
            $table->double('count',8,2);
            $table->timestamps();

            $table->unsignedBigInteger('post_id');

            $table->foreign('post_id')->references('id')->on('posts')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->unsignedBigInteger('ingredion_id');

            $table->foreign('ingredion_id')->references('id')->on('ingredions')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->unsignedBigInteger('unite_id');

            $table->foreign('unite_id')->references('id')->on('unites')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->primary(['post_id','ingredion_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredion_posts');
    }
}
