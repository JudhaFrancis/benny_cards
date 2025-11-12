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
        Schema::table('product_reviews', function (Blueprint $table) {
             $table->string('reviewer_name', 255)->nullable()->after('user_id');
        $table->string('title', 255)->nullable()->after('reviewer_name');
        $table->text('description')->nullable()->after('title');
        $table->string('image', 255)->nullable()->after('description');
        $table->tinyInteger('rating')->default(0)->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_reviews', function (Blueprint $table) {
                    $table->dropColumn(['reviewer_name', 'title', 'description', 'image', 'rating']);

        });
    }
};