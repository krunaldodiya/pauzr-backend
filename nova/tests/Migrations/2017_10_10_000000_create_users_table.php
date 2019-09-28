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
            $table->uuid('id')->primary();

            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('dob')->default("01-01-1990");
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();

            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();

            $table->boolean('intro_completed')->default(false);
            $table->boolean('profile_completed')->default(false);
            $table->boolean('status')->default(true);

            $table->string('version')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('restricted')->default('Yes');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
