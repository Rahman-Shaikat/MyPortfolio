<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand_initials', 10)->nullable();
            $table->string('professional_title');
            $table->string('header_subtitle')->nullable();
            $table->string('availability_text')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('hero_title_line_one')->nullable();
            $table->string('hero_title_line_two')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('profile_caption')->nullable();
            $table->string('current_focus')->nullable();
            $table->string('core_strengths')->nullable();
            $table->json('orbit_skills')->nullable();
            $table->json('hero_metrics')->nullable();
            $table->text('about_title')->nullable();
            $table->text('about_paragraph_one')->nullable();
            $table->text('about_paragraph_two')->nullable();
            $table->json('about_highlights')->nullable();
            $table->text('skills_title')->nullable();
            $table->json('skills')->nullable();
            $table->text('services_title')->nullable();
            $table->json('services')->nullable();
            $table->text('projects_title')->nullable();
            $table->text('experience_title')->nullable();
            $table->json('experiences')->nullable();
            $table->text('contact_title')->nullable();
            $table->text('contact_description')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('x_url')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('resume')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
