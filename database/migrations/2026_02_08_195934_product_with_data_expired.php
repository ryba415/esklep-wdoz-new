<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ecommerce_products', function (Blueprint $table) {
            $table->date('short_expiration_date')->nullable()->after('vat_rate');

            $table->unsignedInteger('short_expiration_stock')->default(0)->after('short_expiration_date');

            $table->decimal('short_price_net', 10, 2)->nullable()->after('short_expiration_stock');
            $table->decimal('short_price_gross', 10, 2)->nullable()->after('short_price_net');

            $table->index('short_expiration_date');
        });

        Schema::table('ecommerce_basket_position', function (Blueprint $table) {
            $table->date('expiration_date')->nullable()->after('product_id');
        });

        Schema::table('ecommerce_order_position', function (Blueprint $table) {
            $table->date('expiration_date')->nullable()->after('product_id');
        });
    }

    public function down(): void
    {
        Schema::table('ecommerce_products', function (Blueprint $table) {
            $table->dropIndex(['short_expiration_date']);
            $table->dropColumn([
                'short_expiration_date',
                'short_expiration_stock',
                'short_price_net',
                'short_price_gross',
            ]);
        });

        Schema::table('ecommerce_basket_position', function (Blueprint $table) {
            $table->dropColumn('expiration_date');
        });

        Schema::table('ecommerce_order_position', function (Blueprint $table) {
            $table->dropColumn('expiration_date');
        });
    }
};
