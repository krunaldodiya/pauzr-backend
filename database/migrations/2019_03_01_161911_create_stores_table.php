<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');

            $table->enum('type', ['Offline', 'Online'])->default('Offline');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('city')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('top_brand')->default(false);
            $table->tinyInteger('sort_order')->default(0);

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
        Schema::dropIfExists('stores');
    }
}
