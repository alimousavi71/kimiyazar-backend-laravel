<?php

namespace App\Models;

use App\Enums\Database\SettingKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property SettingKey $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'key' => SettingKey::class,
        ];
    }

    /**
     * Find setting by key.
     *
     * @param SettingKey|string $key
     * @return Setting|null
     */
    public static function findByKey(SettingKey|string $key): ?Setting
    {
        $keyValue = $key instanceof SettingKey ? $key->value : $key;
        return self::where('key', $keyValue)->first();
    }

    /**
     * Get setting value by key.
     *
     * @param SettingKey|string $key
     * @param string|null $default
     * @return string|null
     */
    public static function getValue(SettingKey|string $key, ?string $default = null): ?string
    {
        $setting = self::findByKey($key);
        return $setting?->value ?? $default;
    }

    /**
     * Set setting value by key.
     *
     * @param SettingKey|string $key
     * @param string|null $value
     * @return Setting
     */
    public static function setValue(SettingKey|string $key, ?string $value): Setting
    {
        $keyValue = $key instanceof SettingKey ? $key->value : $key;
        return self::updateOrCreate(
            ['key' => $keyValue],
            ['value' => $value]
        );
    }

    /**
     * Get all settings as key-value array.
     *
     * @return array<string, string|null>
     */
    public static function getAllAsArray(): array
    {
        return self::pluck('value', 'key')->toArray();
    }
}
