<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spend extends Model
{

    protected $fillable = [
        'title', 'description', 'pay_date', 'price', 'status', 'trip_id'
    ];
    public function users(){
        return $this->belongsToMany('App\User')->withPivot('price');
    }
    public function trip(){
        return $this->hasOne('App\Trip');
    }
}
