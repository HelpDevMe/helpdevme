<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    const types = [
        'deduction' => 0,
        'payment' => 1,
        'received' => 2
    ];

    public function receiver()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
