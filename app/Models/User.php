<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static firstByEmailOrUsername($username)
 * @property string first_name
 * @property string|null last_name
 * @property integer id
 * @property string|null avatar
 */
class User extends Authenticatable {

    use HasApiTokens, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birthday'  => 'date',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
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
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getFullNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }

    public function getAvatarAttribute()
    {
        if (Str::startsWith($this->attributes['avatar'], 'http')) {
            return $this->attributes['avatar'];
        }

        return $this->attributes['avatar']
            ? Storage::disk('s3')->temporaryUrl($this->attributes['avatar'], now()->addMinutes(5))
            : null;
    }
}
