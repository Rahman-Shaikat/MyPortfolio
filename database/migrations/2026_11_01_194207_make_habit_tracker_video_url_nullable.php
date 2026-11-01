<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('habit_tracker_pages', function (Blueprint $table) {
            $table->string('video_url', 2048)->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('habit_tracker_pages')->whereNull('video_url')->exists()) {
            throw new RuntimeException('Set a video URL before rolling back video nullability.');
        }

        Schema::table('habit_tracker_pages', function (Blueprint $table) {
            $table->string('video_url', 2048)->nullable(false)->default('https://youtu.be/_N37glNeUms')->change();
        });
    }
};
