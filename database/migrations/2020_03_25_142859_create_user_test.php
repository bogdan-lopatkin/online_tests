<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_test', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('test_id')->index();
            $table->enum('status',['none','started','completed']);
            $table->integer('mark');
            $table->json('picked_answers');
            $table->timestamps();
      //      $table->foreign('user_id')->references('id')->on('users');
        //    $table->foreign('test_id')->references('id')->on('tests');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_test');
    }
}
