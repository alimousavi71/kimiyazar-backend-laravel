<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, State> $states
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Order> $orders
 */
class Country extends Model
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
        'code',
    ];

    /**
     * Get all states for the country.
     *
     * @return HasMany
     */
    public function states(): HasMany
    {
        return $this->hasMany(State::class, 'country_id');
    }

    /**
     * Get all orders for the country.
     *
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'country_id');
    }
}
