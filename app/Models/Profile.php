<?php

namespace App\Models;

use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'brand_initials',
    'professional_title',
    'header_subtitle',
    'availability_text',
    'seo_description',
    'hero_title_line_one',
    'hero_title_line_two',
    'hero_description',
    'profile_caption',
    'current_focus',
    'core_strengths',
    'orbit_skills',
    'hero_metrics',
    'about_title',
    'about_paragraph_one',
    'about_paragraph_two',
    'about_highlights',
    'skills_title',
    'skills',
    'services_title',
    'services',
    'projects_title',
    'experience_title',
    'experiences',
    'contact_title',
    'contact_description',
    'email',
    'phone',
    'location',
    'facebook_url',
    'instagram_url',
    'github_url',
    'linkedin_url',
    'medium_url',
    'x_url',
    'profile_image',
    'resume',
])]
class Profile extends Model
{
    /** @use HasFactory<ProfileFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'orbit_skills' => 'array',
            'hero_metrics' => 'array',
            'about_highlights' => 'array',
            'skills' => 'array',
            'services' => 'array',
            'experiences' => 'array',
        ];
    }
}
