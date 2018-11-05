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
        'status_id'
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
}
