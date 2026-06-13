<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ecommerce_refunds', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('order_id')->index();
            $table->string('order_identity', 30)->index();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->string('status', 50)->default('new')->index();
            $table->decimal('total_value_gross', 10, 2)->default(0);
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecommerce_refunds');
    }
};
