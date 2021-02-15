<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Answers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Answers', function (Blueprint $table) {
            $table->id();
            $table->string('nameSurname');
            $table->string('answerContent');
            $table->unsignedBigInteger('commentId');
            $table->boolean('isAdminAnswer')->default(0);
            $table->timestamps();

            $table->foreign('commentId')->references('id')->on('Comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Answers');
    }
}
