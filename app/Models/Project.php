<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'style_id',
        'author_id',
        'forked_from',
        'published',
        'public',
    ];

    protected $casts = [
        'id' => 'integer',
        'style_id' => 'integer',
        'author_id' => 'integer',
        'forked_from' => 'integer',
        'published' => 'boolean',
        'public' => 'boolean',
    ];

    public static function newFactory()
    {
        return ProjectFactory::new();
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function rooms()
    {
        return $this->hasMany(\App\Models\Room::class);
    }

    public function style()
    {
        return $this->belongsTo(\App\Models\Style::class);
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function forkedFrom()
    {
        return $this->belongsTo(\App\Models\Project::class);
    }

//    public static function boot()
//    {
//        parent::boot();
//
//        self::created(function ($project) {
//            \Bouncer::allow(auth()->user())->toOwn($project);
//        });
//    }
}
