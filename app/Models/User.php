<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

/**
 * @method static firstByEmailOrUsername($username)
 * @property string first_name
 * @property string|null last_name
 * @property integer id
 * @property string|null avatar
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRolesAndAbilities;
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'phone',
        'birthday',
        'is_active',
        'avatar',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birthday' => 'date',
        'is_active' => 'boolean',
    ];

    public static function newFactory()
    {
        return UserFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'author_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeFirstByEmailOrUsername(Builder $query, $value)
    {
        return $query
            ->where('email', $value)
            ->orWhere('username', $value)
            ->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getFullNameAttribute(): string
    {
        return "$this->first_name $this->last_name";
    }

    public function getAvatarAttribute()
    {
        if (!isset($this->attributes['avatar'])) {
            return null;
        }

        if (Str::startsWith($this->attributes['avatar'], 'http')) {
            return $this->attributes['avatar'];
        }

        return Storage::disk('s3')->temporaryUrl(
            $this->attributes['avatar'],
            now()->addMinutes(5)
        );
    }
}
