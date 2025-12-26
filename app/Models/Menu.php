<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property array|null $links
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'links',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'links' => 'array',
        ];
    }

    /**
     * Find menu by name.
     *
     * @param string $name
     * @return Menu|null
     */
    public static function findByName(string $name): ?Menu
    {
        return self::where('name', $name)->first();
    }

    /**
     * Find menu by type.
     *
     * @param string $type
     * @return Menu|null
     */
    public static function findByType(string $type): ?Menu
    {
        return self::where('type', $type)->first();
    }

    /**
     * Get all menus by type.
     *
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByType(string $type)
    {
        return self::where('type', $type)->get();
    }

    /**
     * Get links sorted by order.
     *
     * @return array
     */
    public function getOrderedLinks(): array
    {
        $links = $this->links ?? [];

        usort($links, function ($a, $b) {
            $orderA = $a['order'] ?? 0;
            $orderB = $b['order'] ?? 0;
            return $orderA <=> $orderB;
        });

        return $links;
    }
}
