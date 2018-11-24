<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'question_id',
        'user_id',
        'vote'
    ];
}
