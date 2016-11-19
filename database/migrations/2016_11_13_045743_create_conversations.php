<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->increments('id');

            /**
             * The user who initiated the conversation.
             */
            $table->integer('initiator_id')->unsigned();
            $table->foreign('initiator_id')->references('id')->on('users');

            /**
             * The user who responds to the conversation.
             */
            $table->integer('respondent_id')->unsigned();
            $table->foreign('respondent_id')->references('id')->on('users');

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
        Schema::dropIfExists('conversations');
    }
}
