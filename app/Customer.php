<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['id'];

    public function sales(){
        return $this->hasMany('App\Sales');
    }
}
