<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_one');
            $table->integer('user_two');
            $table->timestamps();
        });

        Schema::create('messages', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('chat_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('content');
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
        Schema::drop('chats');
        Schema::drop('messages');
    }
}
