<?php

namespace App;

use App\Post;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    const status = [
        'active' => 0,
        'inactive' => 1
    ];

    protected $fillable = [
        'user_id',
        'question_id',
        'receiver_id'
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    
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
