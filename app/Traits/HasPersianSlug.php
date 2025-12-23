<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Reusable trait to auto-generate slugs that keep Persian characters.
 *
 * Usage:
 *  - Add `use HasPersianSlug;` to a model.
 *  - Ensure the model has a `slug` column.
 *  - Optionally, override `getSlugSourceField()` to set the source field (default: `title`).
 *
 * Note: This is not applied to Category per request.
 */
trait HasPersianSlug
{
    /**
     * Boot the trait and hook into the model events.
     *
     * @return void
     */
    public static function bootHasPersianSlug(): void
    {
        static::creating(function ($model) {
            $model->ensureSlugIsSet();
        });

        static::updating(function ($model) {
            // Only regenerate when source changed and slug not manually set
            if ($model->isDirty($model->getSlugSourceField()) && !$model->isDirty('slug')) {
                $model->ensureSlugIsSet();
            }
        });

    }

    /**
     * Ensure slug is set if empty.
     * This works even when model events are disabled (e.g., in seeders with WithoutModelEvents).
     *
     * @return void
     */
    protected function ensureSlugIsSet(): void
    {
        if (empty($this->slug)) {
            $this->slug = $this->makePersianSlug($this->getSlugSourceValue());
        }
    }

    /**
     * Perform the actual insert query.
     * Override to ensure slug is set even when events are disabled.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return bool
     */
    protected function performInsert(\Illuminate\Database\Eloquent\Builder $query): bool
    {
        $this->ensureSlugIsSet();
        return parent::performInsert($query);
    }

    /**
     * Perform the actual update query.
     * Override to ensure slug is set even when events are disabled.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return int
     */
    protected function performUpdate(\Illuminate\Database\Eloquent\Builder $query): int
    {
        // Only regenerate when source changed and slug not manually set
        if ($this->isDirty($this->getSlugSourceField()) && !$this->isDirty('slug')) {
            $this->ensureSlugIsSet();
            }
        return parent::performUpdate($query);
    }

    /**
     * Get the field name used to generate the slug.
     *
     * @return string
     */
    protected function getSlugSourceField(): string
    {
        return property_exists($this, 'slugSource') ? $this->slugSource : 'title';
    }

    /**
     * Get the current value of the slug source field.
     *
     * @return string
     */
    protected function getSlugSourceValue(): string
    {
        $field = $this->getSlugSourceField();

        return (string) ($this->{$field} ?? '');
    }

    /**
     * Create a slug while preserving Persian characters and allowing existing slugs.
     *
     * Supports formats like:
     *  - slug-post
     *  - slug-vast-1
     *  - slug-vast-2
     *
     * @param string $value
     * @param string $separator
     * @return string
     */
    protected function makePersianSlug(string $value, string $separator = '-'): string
    {
        // Normalize common Arabic characters to Persian equivalents
        $value = str_replace(['ي', 'ك'], ['ی', 'ک'], $value);

        // Lowercase and trim
        $value = trim(mb_strtolower($value, 'UTF-8'));

        // Replace any whitespace or underscore with the separator
        $value = preg_replace('/[\s_]+/u', $separator, $value);

        // Allow Persian letters, English letters, digits, and separator; drop others
        $value = preg_replace('/[^0-9a-zA-Zآ-یءئإأؤۀکگپچژ\s' . preg_quote($separator, '/') . ']+/u', '', $value);

        // Collapse multiple separators
        $value = preg_replace('/' . preg_quote($separator, '/') . '+/', $separator, $value);

        // Trim separators
        $value = trim($value, $separator);

        // Fallback if empty
        return $value !== '' ? $value : Str::random(8);
    }
}

