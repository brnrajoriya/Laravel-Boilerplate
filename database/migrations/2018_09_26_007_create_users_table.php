<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('email', 255)->unique()->nullable();
            $table->string('mobile', 20)->unique()->nullable();
            $table->string('username')->unique();
            $table->string('refer_key', 20)->unique();
            $table->string('referred_by_key', 20)->nullable();
            $table->string('password', 255);
            $table->string('image', 255)->nullable();
            $table->boolean('is_email_approved')->default(false);
            $table->boolean('is_mobile_approved')->default(false);
            $table->boolean('is_profile_approved')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
