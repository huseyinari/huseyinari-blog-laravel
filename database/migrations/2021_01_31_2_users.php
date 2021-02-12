<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Users', function (Blueprint $table) {
            $table->id();
            $table->string('nameSurname');
            $table->string('email');
            $table->string('password');
            $table->boolean('isActive');
            // --------- sadece yazarların özellikleri-------
            $table->text('about')->nullable(true);
            $table->string('instagramAddress')->nullable(true);
            $table->string('youtubeAddress')->nullable(true);
            $table->string('facebookAddress')->nullable(true);
            $table->string('twitterAddress')->nullable(true);
            $table->string('photo')->nullable(true);
            // ------------------------------------
            $table->unsignedBigInteger('roleId');
            $table->timestamps();

            $table->foreign('roleId')->references('id')->on('Roles');
            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Users');
    }
}
