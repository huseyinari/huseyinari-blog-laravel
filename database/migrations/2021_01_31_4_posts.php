<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('postContent');
            $table->string('coverPhoto');
            $table->unsignedMediumInteger('viewCount')->default(0);
            $table->string('seo');
            $table->unsignedBigInteger('postOwner');
            $table->unsignedBigInteger('categoryId');
            $table->timestamps();

            $table->foreign('postOwner')->references('id')->on('Users');
            $table->foreign('categoryId')->references('id')->on('Categories');
            $table->unique('seo');
            $table->unique('title');
            $table->unique('coverPhoto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Posts');
    }
}
