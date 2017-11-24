<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function spends(){
        return $this->belongsToMany('App\Spend')->withPivot('price');
    }

    public function balance(){
        return $this->hasOne('App\Balance');
    }
    public function part(){
        return $this->hasOne('App\Part');
    }

}
