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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('role')->nullable()->after('description');
            $table->text('contribution')->nullable()->after('role');
            $table->text('challenges')->nullable()->after('contribution');
            $table->json('responsibilities')->nullable()->after('challenges');
            $table->text('outcome')->nullable()->after('responsibilities');
            $table->string('contribution_type')->default('contributor')->after('outcome');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'contribution',
                'challenges',
                'responsibilities',
                'outcome',
                'contribution_type',
            ]);
        });
    }
};
