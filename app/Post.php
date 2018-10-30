<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body',
        'budget',
        'comment',
        'talk_id'
    ];

    public function talk()
    {
        return $this->belongsTo('App\Talk');
    }
}
