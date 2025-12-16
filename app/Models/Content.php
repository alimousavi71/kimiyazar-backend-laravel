<?php

namespace App\Models;

use App\Enums\Database\ContentType;
use App\Traits\AppendsRandomStringOnSoftDelete;
use App\Traits\HasPersianSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Content
 *
 * @property int $id
 * @property ContentType $type
 * @property string $title
 * @property string $slug
 * @property string|null $body
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @property bool $is_active
 * @property int $visit_count
 * @property bool $is_undeletable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Content extends Model
{
    use HasFactory, SoftDeletes, HasPersianSlug, AppendsRandomStringOnSoftDelete;

    /**
     * The source field for slug generation.
     *
     * @var string
     */
    protected string $slugSource = 'title';

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
        'type',
        'title',
        'slug',
        'body',
        'seo_description',
        'seo_keywords',
        'is_active',
        'visit_count',
        'is_undeletable',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ContentType::class,
            'is_active' => 'boolean',
            'visit_count' => 'integer',
            'is_undeletable' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Check if content is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Increment visit count.
     *
     * @return void
     */
    public function incrementVisitCount(): void
    {
        $this->increment('visit_count');
    }

    /**
     * Scope to filter by type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param ContentType $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, ContentType $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to get only active content.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
