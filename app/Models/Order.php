<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'total',
        'customer_name',
        'customer_email',
        'address',
        'city',
        'zip_code',
        'tracking_number',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    /**
     * Relación: Un pedido tiene muchos artículos de pedido.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
