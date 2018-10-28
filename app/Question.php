<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    const ANALYZING = 0;
    const WARRANTY = 1;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'user_id',
        'status_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
