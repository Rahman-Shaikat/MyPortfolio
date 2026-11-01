<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    public const OPTIONS = [
        'bkash_bdt' => ['name' => 'bKash', 'type' => 'bkash', 'currency' => 'BDT'],
        'bank_bdt' => ['name' => 'Bank transfer', 'type' => 'bank', 'currency' => 'BDT'],
        'bank_usd' => ['name' => 'International bank transfer', 'type' => 'bank', 'currency' => 'USD'],
    ];

    protected $fillable = ['code', 'name', 'type', 'currency', 'instructions', 'enabled'];

    protected $attributes = ['enabled' => false];

    protected function casts(): array
    {
        return ['enabled' => 'boolean'];
    }
}
