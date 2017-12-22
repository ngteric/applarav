<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = [
        'started', 'day', 'trip_id', 'user_id'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function trip(){
        return $this->hasOne('App\Trip');
    }
}
