<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperForgotPassword
 */
class ForgotPassword extends Model
{
    protected $table = 'password_resets';

    protected $primaryKey = 'email';

    protected $fillable = [
        'email',
        'token',
    ];

    public $incrementing = false;
}
