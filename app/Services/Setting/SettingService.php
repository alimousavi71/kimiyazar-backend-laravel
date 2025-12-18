<?php

namespace App\Services\Setting;

use App\Enums\Database\SettingKey;
use App\Repositories\Setting\SettingRepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Service class for Setting business logic
 */
class SettingService
{
    /**
     * @param SettingRepositoryInterface $repository
     */
    public function __construct(
        private readonly SettingRepositoryInterface $repository
    ) {
    }

    /**
     * Get all settings.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Get all settings grouped by category or as flat array.
     *
     * @return array<string, array<string, string|null>>
     */
    public function getAllGrouped(): array
    {
        $settings = $this->repository->getAllAsArray();
        $grouped = [];

        foreach (SettingKey::cases() as $key) {
            $grouped[$key->value] = $settings[$key->value] ?? null;
        }

        return $grouped;
    }

    /**
     * Get setting value by key.
     *
     * @param SettingKey|string $key
     * @param string|null $default
     * @return string|null
     */
    public function getValue(SettingKey|string $key, ?string $default = null): ?string
    {
        $keyValue = $key instanceof SettingKey ? $key->value : $key;
        return $this->repository->getValue($keyValue, $default);
    }

    /**
     * Update or create a setting.
     *
     * @param SettingKey|string $key
     * @param string|null $value
     * @return void
     */
    public function setValue(SettingKey|string $key, ?string $value): void
    {
        $keyValue = $key instanceof SettingKey ? $key->value : $key;
        $this->repository->updateOrCreate($keyValue, $value);
    }

    /**
     * Update multiple settings at once.
     *
     * @param array<string, string|null> $settings
     * @return void
     */
    public function updateMultiple(array $settings): void
    {
        // Validate that all keys are valid SettingKey enum values
        $validKeys = SettingKey::values();
        $filteredSettings = [];

        foreach ($settings as $key => $value) {
            if (in_array($key, $validKeys, true)) {
                $filteredSettings[$key] = $value;
            }
        }

        $this->repository->updateMultiple($filteredSettings);
    }

    /**
     * Get all available setting keys with their labels.
     *
     * @return array<string, string>
     */
    public function getAvailableKeys(): array
    {
        $keys = [];
        foreach (SettingKey::cases() as $key) {
            $keys[$key->value] = $key->label();
        }
        return $keys;
    }
}
