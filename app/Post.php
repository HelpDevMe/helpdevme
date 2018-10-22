<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $with = ['user'];

    protected $fillable = [
        'body',
        'budget',
        'question_id',
        'user_id',
        'receiver_id'
    ];

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id');
    }
}
