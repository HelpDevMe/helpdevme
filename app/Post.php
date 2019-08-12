<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body',
        'budget',
        'status',
        'type',
        'talk_id',
        'user_id'
    ];

    const status = [
        'analyzing' => 0,
        'refused' => 1,
        'accept' => 2,
        'payment' => 3,
        'finalized' => 4
    ];

    const types = [
        'message' => 0,
        'comment' => 1,
        'alert' => 2
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
