<?php

declare (strict_types = 1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price')->default('0.00');

            $table->integer('trial_days')->default(7);
            $table->enum('subscription_period', ['Weekly', 'Monthly', 'Quarterly', 'Biannually', 'Annually']);

            $table->mediumInteger('sort_order')->unsigned()->default(0);
            $table->boolean('active')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
}
