<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    const ANALYZING = 0;
    const WARRANTY = 1;
    const PAYMENT = 2;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'user_id',
        'status',
        'user_ended',
        'freelancer_ended'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function talks()
    {
        return $this->hasMany('App\Talk');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag')
            ->withTimestamps();
    }
    
    public function posts()
    {
        return $this->hasManyThrough('App\Post', 'App\Talk');
    }

    public function comments()
    {
        return $this->posts->where('type', \App\Post::types['comment']);
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
}
