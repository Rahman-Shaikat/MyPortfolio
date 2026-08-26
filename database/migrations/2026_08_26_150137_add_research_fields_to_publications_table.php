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
        Schema::table('publications', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->json('authors')->nullable()->after('slug');
            $table->string('reference_url')->nullable()->after('url');
            $table->json('research_topics')->nullable()->after('reference_url');
            $table->text('contribution')->nullable()->after('research_topics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn([
                'slug',
                'authors',
                'reference_url',
                'research_topics',
                'contribution',
            ]);
        });
    }
};
