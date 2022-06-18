<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use function Illuminate\Events\queueable;

/**
 * @mixin IdeHelperUser
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRolesAndAbilities;
    use Notifiable;
    use Billable;

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
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birthday' => 'date',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'author_id');
    }

    public function store(): HasOne
    {
        return $this->hasOne(Store::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeFirstByEmail(Builder $query, $value): Model|Builder|null
    {
        return $query->where('email', $value)->first();
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
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAvatarAttribute(): ?string
    {
        if (!isset($this->attributes['avatar'])) {
            return null;
        }

        if (Str::startsWith($this->attributes['avatar'], 'http')) {
            return $this->attributes['avatar'];
        }

        return Storage::disk('s3')->temporaryUrl(
            $this->attributes['avatar'],
            now()->addMinutes(30)
        );
    }

    protected static function booted()
    {
        static::updated(function ($customer) {
            if ($customer->hasStripeId()) {
                $customer->syncStripeCustomerDetails();
            }
        });
    }

    public function stripeName(): ?string
    {
        return $this->full_name;
    }
}
