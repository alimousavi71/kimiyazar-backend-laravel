<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Bank
 *
 * @property int $id
 * @property string $name
 * @property string|null $logo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Order> $orders
 */
class Bank extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'logo',
    ];

    /**
     * Get all orders for the bank.
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'payment_bank_id');
    }
}
