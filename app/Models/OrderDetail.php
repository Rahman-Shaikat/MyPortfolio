<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $fillable = [
        'product', 'amount', 'currency', 'payment_method', 'payment_method_name',
        'payment_instructions', 'payment_reference', 'reference_fingerprint',
        'bank_sender_name', 'bank_last_four', 'screenshot_path',
    ];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2'];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
