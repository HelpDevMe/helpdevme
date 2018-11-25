<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'budget',
        'type',
        'post_id',
        'user_id',
        'confirmed',
        'receiver_id'
    ];

    const types = [
        'deduction' => 0,
        'payment' => 1,
        'received' => 2,
        'fund' => 3
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
