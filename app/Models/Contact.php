<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $text
 * @property string|null $email
 * @property string|null $mobile
 * @property bool $is_read
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'text',
        'email',
        'mobile',
        'is_read',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    /**
     * Check if contact is read.
     *
     * @return bool
     */
    public function isRead(): bool
    {
        return $this->is_read;
    }

    /**
     * Mark contact as read.
     *
     * @return void
     */
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}

