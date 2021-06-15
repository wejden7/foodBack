<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string("message");
            $table->timestamps();

            $table->unsignedBigInteger('user_send_id');
            $table->unsignedBigInteger('user_received_id');

            $table->foreign('user_send_id')->references('id')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('user_received_id')->references('id')->on('users')
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
        Schema::dropIfExists('chats');
    }
}
