<?php

namespace App\Models;

use App\Enums\Database\BannerPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Banner
 *
 * @property int $id
 * @property string $name
 * @property string|null $banner_file
 * @property string|null $link
 * @property BannerPosition $position
 * @property string|null $target_type
 * @property int|null $target_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|null $target
 */
class Banner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'banner_file',
        'link',
        'position',
        'target_type',
        'target_id',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'position' => BannerPosition::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the parent target model (polymorphic relation).
     *
     * @return MorphTo
     */
    public function target(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Check if banner is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Scope to get only active banners.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by position.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param BannerPosition $position
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPosition($query, BannerPosition $position)
    {
        return $query->where('position', $position->value);
    }
}

