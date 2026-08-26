<?php

namespace App\Models;

use Database\Factories\PublicationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'publisher',
    'published_at',
    'description',
    'image',
    'url',
    'sort_order',
    'status',
])]
class Publication extends Model
{
    /** @use HasFactory<PublicationFactory> */
    use HasFactory;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'sort_order' => 0,
        'status' => true,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'sort_order' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', true);
    }
}
