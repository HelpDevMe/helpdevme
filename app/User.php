<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Finance;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function talks()
    {
        return $this->hasMany('App\Talk');
    }

    public function posts()
    {
        return $this->hasManyThrough('App\Post', 'App\Talk');
    }

    public function comments()
    {
        return $this->posts->where('type', \App\Post::types['comment']);
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    public function deposit(float $budget)
    {
        DB::beginTransaction();

        /**
         * Salvar o saldo atual do usuário
         */
        $value = number_format($budget, 2, '.', '');

        $this->amount += $value;
        $deposit = $this->save();

        /**
         * Salva o histórico de transações
         */
        $transaction = $this->finances()->create([
            'user_id' => auth()->id(),
            'receiver_id' => auth()->id(),
            'type' => Finance::types['fund'],
            'budget' => $value,
            'confirmed' => 0
        ]);

        if ($deposit && $transaction) {
            DB::commit();

            return $transaction;
        } else {
            DB::rollBack();

            return false;
        }
    }
}
