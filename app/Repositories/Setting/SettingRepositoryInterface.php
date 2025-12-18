<?php

namespace App\Repositories\Setting;

use App\Models\Setting;
use Illuminate\Support\Collection;

/**
 * Interface for Setting Repository
 */
interface SettingRepositoryInterface
{
    /**
     * Get all settings.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find setting by key.
     *
     * @param string $key
     * @return Setting|null
     */
    public function findByKey(string $key): ?Setting;

    /**
     * Get setting value by key.
     *
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public function getValue(string $key, ?string $default = null): ?string;

    /**
     * Update or create a setting.
     *
     * @param string $key
     * @param string|null $value
     * @return Setting
     */
    public function updateOrCreate(string $key, ?string $value): Setting;

    /**
     * Update multiple settings at once.
     *
     * @param array<string, string|null> $settings
     * @return void
     */
    public function updateMultiple(array $settings): void;

    /**
     * Get all settings as key-value array.
     *
     * @return array<string, string|null>
     */
    public function getAllAsArray(): array;
}
