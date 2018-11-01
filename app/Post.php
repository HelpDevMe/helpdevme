<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const MESSAGE = 0;
    const COMMENT = 1;
    const ALERT = 2;

    protected $fillable = [
        'body',
        'budget',
        'type',
        'talk_id',
        'user_id'
    ];

    public function talk()
    {
        return $this->belongsTo('App\Talk');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
