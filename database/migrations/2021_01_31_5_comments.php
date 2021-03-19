<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Comments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Comments', function (Blueprint $table) {
            $table->id();
            $table->string('nameSurname');
            $table->string('commentContent');
            $table->unsignedBigInteger('postId');
            $table->boolean('isAdminComment')->default(0);
            $table->timestamps();

            $table->foreign('postId')->references('id')->on('Posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Comments');
    }
}
