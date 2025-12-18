<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Modal
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $button_text
 * @property string|null $button_url
 * @property string $close_text
 * @property bool $is_rememberable
 * @property string|null $modalable_type
 * @property int|null $modalable_id
 * @property bool $is_published
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 * @property int $priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|null $modalable
 */
class Modal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
        'button_text',
        'button_url',
        'close_text',
        'is_rememberable',
        'modalable_type',
        'modalable_id',
        'is_published',
        'start_at',
        'end_at',
        'priority',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_rememberable' => 'boolean',
            'priority' => 'integer',
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }

    /**
     * Get the parent modalable model (polymorphic relation).
     *
     * @return MorphTo
     */
    public function modalable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Check if modal is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    /**
     * Check if modal should be shown based on date range.
     *
     * @return bool
     */
    public function isWithinDateRange(): bool
    {
        $now = Carbon::now();

        if ($this->start_at && $now->isBefore($this->start_at)) {
            return false;
        }

        if ($this->end_at && $now->isAfter($this->end_at)) {
            return false;
        }

        return true;
    }

    /**
     * Check if modal is currently active and within date range.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->isPublished() && $this->isWithinDateRange();
    }

    /**
     * Scope to get only published modals.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to filter by priority.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $priority
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPriority($query, int $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope to order by priority (descending) then by creation date.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderByDesc('priority')->orderByDesc('id');
    }

    /**
     * Scope to filter modals within date range.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithinDateRange($query)
    {
        $now = Carbon::now();

        return $query->where(function ($q) use ($now) {
            $q->whereNull('start_at')
                ->orWhere('start_at', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('end_at')
                ->orWhere('end_at', '>=', $now);
        });
    }

    /**
     * Scope to filter modals for a specific modalable model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $modalableType
     * @param int|null $modalableId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForModalable($query, string $modalableType, ?int $modalableId = null)
    {
        $query->where('modalable_type', $modalableType);

        if ($modalableId) {
            $query->where('modalable_id', $modalableId);
        }

        return $query;
    }
}
