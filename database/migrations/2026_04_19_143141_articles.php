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
        Schema::table('article', function (Blueprint $table) {
            $table->text('img_name')->after('content')->nullable();
            $table->string('seo_url')->after('content')->nullable();
            $table->string('seo_title')->after('seo_url')->nullable();
            $table->text('seo_description')->after('seo_title')->nullable();
        });

        Schema::table(' article_category', function (Blueprint $table) {
            $table->text('seo_url')->after('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
