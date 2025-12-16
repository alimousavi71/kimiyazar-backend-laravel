<?php

namespace App\Traits;

/**
 * Trait to automatically append a random string to unique fields when a model is soft-deleted.
 *
 * This ensures that soft-deleted records do not block the creation of new records
 * with the same unique values, without requiring any manual intervention.
 *
 * Usage:
 *  - Add `use AppendsRandomStringOnSoftDelete;` to a model that uses SoftDeletes.
 *  - Define a protected property `$uniqueFieldsOnSoftDelete` as an array of field names.
 *  - Example: protected array $uniqueFieldsOnSoftDelete = ['email', 'username'];
 *
 * The trait will automatically append a random string to each specified field
 * when the model is soft-deleted.
 */
trait AppendsRandomStringOnSoftDelete
{
    /**
     * Boot the trait and hook into the model events.
     *
     * @return void
     */
    public static function bootAppendsRandomStringOnSoftDelete(): void
    {
        static::deleting(function ($model) {
            $model->appendRandomStringToUniqueFields();
        });
    }

    /**
     * Append random string to all configured unique fields.
     *
     * @return void
     */
    protected function appendRandomStringToUniqueFields(): void
    {
        // Only proceed if soft deleting (not force deleting)
        if ($this->isForceDeleting()) {
            return;
        }

        $fields = $this->getUniqueFieldsForSoftDelete();

        if (empty($fields)) {
            return;
        }

        $randomString = $this->generateRandomString();
        $updates = [];

        foreach ($fields as $field) {
            if (!isset($this->{$field}) || $this->{$field} === null) {
                continue;
            }

            $currentValue = (string) $this->{$field};
            $updates[$field] = $currentValue . $randomString;
        }

        if (!empty($updates)) {
            // Update the model attributes directly
            foreach ($updates as $field => $value) {
                $this->{$field} = $value;
            }

            // Save without triggering events to avoid recursion
            $this->saveQuietly();
        }
    }

    /**
     * Get the list of unique fields that should be modified on soft delete.
     *
     * @return array<string>
     */
    protected function getUniqueFieldsForSoftDelete(): array
    {
        if (!property_exists($this, 'uniqueFieldsOnSoftDelete')) {
            return [];
        }

        $fields = $this->uniqueFieldsOnSoftDelete;

        return is_array($fields) ? $fields : [];
    }

    /**
     * Generate a random string to append to unique fields.
     *
     * @return string
     */
    protected function generateRandomString(): string
    {
        return '_deleted_' . bin2hex(random_bytes(8));
    }
}

