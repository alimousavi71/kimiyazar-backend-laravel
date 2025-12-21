<?php

namespace App\Models;

use App\Enums\Database\ProductStatus;
use App\Enums\Database\ProductUnit;
use App\Enums\Database\CurrencyCode;
use App\Traits\AppendsRandomStringOnSoftDelete;
use App\Traits\HasPersianSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $sale_description
 * @property ProductUnit $unit
 * @property int|null $category_id
 * @property bool $is_published
 * @property string|null $body
 * @property string|null $price_label
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property ProductStatus $status
 * @property int $sort_order
 * @property string|null $current_price
 * @property CurrencyCode|null $currency_code
 * @property Carbon|null $price_updated_at
 * @property Carbon|null $price_effective_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Photo> $photos
 */
class Product extends Model
{
    use HasFactory, SoftDeletes, HasPersianSlug, AppendsRandomStringOnSoftDelete;

    /**
     * The source field for slug generation.
     *
     * @var string
     */
    protected string $slugSource = 'name';

    /**
     * Unique fields that should be modified when the model is soft-deleted.
     *
     * @var array<string>
     */
    protected array $uniqueFieldsOnSoftDelete = ['slug'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'sale_description',
        'unit',
        'category_id',
        'is_published',
        'body',
        'price_label',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
        'sort_order',
        'current_price',
        'currency_code',
        'price_updated_at',
        'price_effective_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'unit' => ProductUnit::class,
            'status' => ProductStatus::class,
            'currency_code' => CurrencyCode::class,
            'category_id' => 'integer',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'current_price' => 'decimal:0',
            'price_updated_at' => 'datetime',
            'price_effective_date' => 'date',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the category that owns the product.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get all of the photos for the product.
     *
     * @return MorphMany
     */
    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'photoable')->ordered();
    }

    /**
     * Check if product is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    /**
     * Scope to get only published products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to filter by status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param ProductStatus $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfStatus($query, ProductStatus $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by category.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}
