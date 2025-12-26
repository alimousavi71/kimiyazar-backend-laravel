<?php

namespace App\Models;

use App\Enums\Database\OrderStatus;
use App\Enums\Database\PaymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $customer_type
 * @property int|null $member_id
 * @property string|null $full_name
 * @property string|null $national_code
 * @property string|null $national_card_photo
 * @property string|null $phone
 * @property string|null $mobile
 * @property int $is_photo_sent
 * @property string|null $company_name
 * @property string|null $economic_code
 * @property int|null $registration_number
 * @property string|null $official_gazette_photo
 * @property int|null $country_id
 * @property int|null $state_id
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $receiver_full_name
 * @property string|null $delivery_method
 * @property string|null $address
 * @property int|null $product_id
 * @property int|null $quantity
 * @property string $unit
 * @property string|null $unit_price
 * @property string|null $product_description
 * @property int|null $payment_bank_id
 * @property string $payment_type
 * @property string $total_payment_amount
 * @property string|null $payment_date
 * @property string|null $payment_time
 * @property string|null $admin_note
 * @property OrderStatus $status
 * @property int $is_registered_service
 * @property int $is_viewed
 * @property int|null $created_at
 * @property-read Country|null $country
 * @property-read State|null $state
 * @property-read Bank|null $paymentBank
 * @property-read Product|null $product
 */
class Order extends Model
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
        'customer_type',
        'member_id',
        'full_name',
        'national_code',
        'national_card_photo',
        'phone',
        'mobile',
        'is_photo_sent',
        'company_name',
        'economic_code',
        'registration_number',
        'official_gazette_photo',
        'country_id',
        'state_id',
        'city',
        'postal_code',
        'receiver_full_name',
        'delivery_method',
        'address',
        'product_id',
        'quantity',
        'unit',
        'unit_price',
        'product_description',
        'payment_bank_id',
        'payment_type',
        'total_payment_amount',
        'payment_date',
        'payment_time',
        'admin_note',
        'status',
        'is_registered_service',
        'is_viewed',
        'created_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'payment_type' => PaymentType::class,
            'member_id' => 'integer',
            'country_id' => 'integer',
            'state_id' => 'integer',
            'product_id' => 'integer',
            'quantity' => 'integer',
            'unit_price' => 'decimal:0',
            'payment_bank_id' => 'integer',
            'is_photo_sent' => 'boolean',
            'is_registered_service' => 'boolean',
            'is_viewed' => 'boolean',
            'created_at' => 'integer',
        ];
    }

    /**
     * Get the country that owns the order.
     *
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Get the state that owns the order.
     *
     * @return BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * Get the bank associated with the order.
     *
     * @return BelongsTo
     */
    public function paymentBank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'payment_bank_id');
    }

    /**
     * Get the product associated with the order.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Scope to filter by customer type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $customerType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCustomerType($query, string $customerType)
    {
        return $query->where('customer_type', $customerType);
    }

    /**
     * Scope to filter by status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param OrderStatus $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfStatus($query, OrderStatus $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by payment type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param PaymentType $paymentType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfPaymentType($query, PaymentType $paymentType)
    {
        return $query->where('payment_type', $paymentType);
    }

    /**
     * Scope to get unviewed orders.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnviewed($query)
    {
        return $query->where('is_viewed', false);
    }
}
