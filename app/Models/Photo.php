<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Photo
 *
 * @property int $id
 * @property string|null $photoable_type
 * @property int|null $photoable_id
 * @property string $file_path
 * @property string $file_name
 * @property string|null $original_name
 * @property int|null $file_size
 * @property string|null $mime_type
 * @property int|null $width
 * @property int|null $height
 * @property string|null $alt
 * @property int $sort_order
 * @property bool $is_primary
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read string $url
 * @property-read Model|null $photoable
 */
class Photo extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'photoable_type',
        'photoable_id',
        'file_path',
        'file_name',
        'original_name',
        'file_size',
        'mime_type',
        'width',
        'height',
        'alt',
        'sort_order',
        'is_primary',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['url'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
            'sort_order' => 'integer',
            'is_primary' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get the parent photoable model (polymorphic relation).
     *
     * @return MorphTo
     */
    public function photoable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the full URL of the photo.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Check if photo is primary.
     *
     * @return bool
     */
    public function isPrimary(): bool
    {
        return $this->is_primary;
    }

    /**
     * Scope to get only primary photos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope to order by sort order.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
