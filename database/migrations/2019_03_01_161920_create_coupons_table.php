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

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');

            $table->string('title');
            $table->text('description');

            $table->string('image');

            $table->string('coupon')->nullable();
            $table->enum('type', ['Coupon', 'Discount'])->default('Coupon');

            $table->timestamp('start_date')->nullable();
            $table->timestamp('expiry_date')->nullable();

            $table->boolean('redeemed')->default(false);

            $table->text('terms')->nullable();
            $table->text('instructions')->nullable();

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
