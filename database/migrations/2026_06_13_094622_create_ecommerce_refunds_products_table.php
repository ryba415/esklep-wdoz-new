<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ecommerce_refunds_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ecommerce_refund_id')
                ->constrained('ecommerce_refunds')
                ->cascadeOnDelete();
            $table->unsignedInteger('ecommerce_order_product_id')->index();
            $table->unsignedInteger('product_id')->index();
            $table->string('product_name', 500);
            $table->string('product_image_url', 1000)->nullable();
            $table->unsignedInteger('quantity');
            $table->decimal('price_gross', 10, 2);
            $table->decimal('value_gross', 10, 2);
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ecommerce_refunds_products');
    }
};
