<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'style_id',
        'author_id',
        'forked_from',
        'published',
        'public',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'style_id' => 'integer',
        'author_id' => 'integer',
        'forked_from' => 'integer',
        'published' => 'boolean',
        'public' => 'boolean',
    ];


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
}
