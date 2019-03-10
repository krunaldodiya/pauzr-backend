<?php

declare (strict_types = 1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('plan_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade')->onUpdate('cascade');

            $table->string('name');
            $table->text('description')->nullable();

            $table->dateTime('trial_ends_at')->nullable();
            $table->dateTime('subscription_starts_at')->nullable();
            $table->dateTime('subscription_ends_at')->nullable();

            $table->enum('payment_type', ['cash', 'card', 'e_wallet', 'net_banking']);
            $table->enum('payment_status', ['pending', 'paid']);
            $table->enum('subscription_status', ['active', 'expired', 'canceled']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_subscriptions');
    }
}
