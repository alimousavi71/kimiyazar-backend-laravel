<?php

namespace App\Repositories\Setting;

use App\Models\Setting;
use Illuminate\Support\Collection;

/**
 * Repository implementation for Setting model
 */
class SettingRepository implements SettingRepositoryInterface
{
    /**
     * Get all settings.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Setting::all();
    }

    /**
     * Find setting by key.
     *
     * @param string $key
     * @return Setting|null
     */
    public function findByKey(string $key): ?Setting
    {
        return Setting::where('key', $key)->first();
    }

    /**
     * Get setting value by key.
     *
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public function getValue(string $key, ?string $default = null): ?string
    {
        $setting = $this->findByKey($key);
        return $setting?->value ?? $default;
    }

    /**
     * Update or create a setting.
     *
     * @param string $key
     * @param string|null $value
     * @return Setting
     */
    public function updateOrCreate(string $key, ?string $value): Setting
    {
        return Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Update multiple settings at once.
     *
     * @param array<string, string|null> $settings
     * @return void
     */
    public function updateMultiple(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->updateOrCreate($key, $value);
        }
    }

    /**
     * Get all settings as key-value array.
     *
     * @return array<string, string|null>
     */
    public function getAllAsArray(): array
    {
        return Setting::pluck('value', 'key')->toArray();
    }
}
