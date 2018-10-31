<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body',
        'budget',
        'comment',
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
