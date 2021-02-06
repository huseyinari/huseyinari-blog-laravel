<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ratings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('star');
            $table->unsignedBigInteger('postId');
            $table->unsignedBigInteger('userId');
            $table->timestamps();

            $table->foreign('postId')->references('id')->on('Posts');
            $table->foreign('userId')->references('id')->on('Users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Ratings');
    }
}
