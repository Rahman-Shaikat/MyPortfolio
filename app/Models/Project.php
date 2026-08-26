<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'slug',
    'url',
    'description',
    'role',
    'contribution',
    'challenges',
    'responsibilities',
    'outcome',
    'contribution_type',
    'technologies',
    'preview_image',
    'is_personal',
    'sort_order',
    'status',
])]
class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_personal' => false,
        'contribution_type' => 'contributor',
        'sort_order' => 0,
        'status' => true,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'technologies' => 'array',
            'responsibilities' => 'array',
            'is_personal' => 'boolean',
            'sort_order' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }
}
