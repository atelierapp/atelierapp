<?php

namespace App\Models;

use App\Builders\UserBuilder;
use App\Models\Scopes\CountryScope;
use App\Traits\Models\HasMediasRelation;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Silber\Bouncer\Database\HasRolesAndAbilities;

/**
 * @mixin Eloquent
 * @property Variation $shopping_cart
 * @property int $id
 * @property Store|null $store
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasRolesAndAbilities;
    use HasMediasRelation;
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
        'country',
        'locale',
        'is_accepted_terms',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birthday' => 'date',
        'is_active' => 'boolean',
        'is_accepted_terms' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->country)) {
                $model->country = config('app.country');
            }
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new CountryScope());
        static::updated(function ($customer) {
            if ($customer->hasStripeId()) {
                $customer->syncStripeCustomerDetails();
            }
        });
    }

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

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

    public function shopping_cart(): BelongsToMany
    {
        return $this->belongsToMany(Variation::class, 'shopping_cart')->with('product')->using(ShoppingCart::class);
    }

    public function scopeFirstByEmail(Builder $query, $value): Model|Builder|null
    {
        return $query->where('email', $value)->first();
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function stripeName(): ?string
    {
        return $this->full_name;
    }
}
