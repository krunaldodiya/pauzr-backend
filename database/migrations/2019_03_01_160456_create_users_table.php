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
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile', 10)->unique()->nullable();
            $table->string('password');
            $table->timestamp('dob')->nullable();
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->string('avatar')->nullable();
            $table->string('city')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_merchant')->default(false);
            $table->boolean('status')->default(false);
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
