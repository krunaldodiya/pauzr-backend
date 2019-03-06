<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onUpdate('cascade')->onDelete('cascade');

            $table->string('title');
            $table->text('description');
            $table->string('type')->default('discount');
            $table->string('coupon')->nullable();
            $table->string('logo')->nullable();
            $table->text('link')->nullable();
            $table->text('aff_link')->nullable();

            $table->timestamp('start_date')->nullable();
            $table->timestamp('expiry_date')->nullable();

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
        Schema::dropIfExists('coupons');
    }
}
