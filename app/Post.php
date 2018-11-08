<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body',
        'budget',
        'type',
        'talk_id',
        'user_id'
    ];

    const status = [
        'payment' => 3
    ];

    const types = [
        'message' => 0,
        'comment' => 1,
        'warranty' => 2
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
