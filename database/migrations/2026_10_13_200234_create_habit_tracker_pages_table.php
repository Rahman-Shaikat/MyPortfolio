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
        Schema::create('habit_tracker_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_image')->nullable();
            $table->string('planner_image')->nullable();
            $table->string('history_image')->nullable();
            $table->string('analytics_image')->nullable();
            $table->string('video_url', 2048)->default('https://youtu.be/_N37glNeUms');
            $table->decimal('usd_regular_price', 10, 2)->default(15);
            $table->decimal('usd_offer_price', 10, 2)->default(5);
            $table->decimal('bdt_regular_price', 10, 2)->default(1800);
            $table->decimal('bdt_offer_price', 10, 2)->default(500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_tracker_pages');
    }
};
