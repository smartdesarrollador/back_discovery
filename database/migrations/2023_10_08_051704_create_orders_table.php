<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->text('address');
            $table->text('first_name');
            $table->text('last_name');
            $table->string('dni');
            $table->string('district_name');
            $table->string('district_id');
            $table->string('phoneNumber');
            $table->string('shipping_cost');
            $table->string('status')->default('PROCESANDO');
            $table->string('unix_timestamp');
            $table->boolean('is_free_shipping');
            $table->decimal('total');
            $table->text('additionalInformation');
            $table->string('tracking_code');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
