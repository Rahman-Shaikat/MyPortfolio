<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = ['pending', 'completed', 'cancelled'];

    protected $fillable = ['reference', 'submission_hash', 'payload_hash', 'name', 'phone', 'email', 'status', 'completed_at', 'cancelled_at'];

    protected $attributes = ['status' => 'pending'];

    protected function casts(): array
    {
        return ['completed_at' => 'datetime', 'cancelled_at' => 'datetime'];
    }

    public function detail(): HasOne
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('id');
    }
}
