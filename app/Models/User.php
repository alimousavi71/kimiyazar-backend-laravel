<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $country_code
 * @property string $password
 * @property bool $is_active
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $last_login
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'country_code',
        'password',
        'is_active',
        'email_verified_at',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get full name (first_name + last_name).
     *
     * @return string
     */
    public function getFullName(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Check if user is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Get full phone number with country code.
     *
     * @return string|null
     */
    public function getFullPhoneNumber(): ?string
    {
        if ($this->phone_number && $this->country_code) {
            return $this->country_code . $this->phone_number;
        }
        return null;
    }

    /**
     * Update last login timestamp.
     *
     * @return void
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login' => now()]);
    }

    /**
     * Scope to get only active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to find user by email or phone.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $emailOrPhone
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByEmailOrPhone($query, string $emailOrPhone)
    {
        return $query->where('email', $emailOrPhone)
            ->orWhere('phone_number', $emailOrPhone);
    }

    /**
     * Find a user by email or phone number for authentication.
     *
     * @param string $emailOrPhone
     * @return self|null
     */
    public static function findByEmailOrPhone(string $emailOrPhone): ?self
    {
        return self::byEmailOrPhone($emailOrPhone)->first();
    }

}
