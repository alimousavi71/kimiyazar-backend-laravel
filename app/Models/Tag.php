<?php

namespace App\Models;

use App\Traits\AppendsRandomStringOnSoftDelete;
use App\Traits\HasPersianSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Tag extends Model
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
        'title',
        'slug',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Get all of the contents that are assigned this tag.
     */
    public function contents(): MorphToMany
    {
        return $this->morphedByMany(Content::class, 'tagable', 'tagables')
            ->withTimestamps();
    }

    /**
     * Get all tagables (polymorphic relationships) for this tag.
     *
     * @return HasMany
     */
    public function tagables(): HasMany
    {
        return $this->hasMany(Tagable::class, 'tag_id');
    }
}

