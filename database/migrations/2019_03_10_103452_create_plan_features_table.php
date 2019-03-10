<?php

declare (strict_types = 1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('plan_features', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade')->onUpdate('cascade');

            $table->string('name');
            $table->string('value');
            $table->text('description')->nullable();

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
        Schema::dropIfExists('plan_features');
    }
}
