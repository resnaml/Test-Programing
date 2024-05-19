<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $guarded = ['id'];

    public function customer(){
        return $this->belongsTo('App\Customer','cust_id');
    }

    public function salesDet(){
        return $this->belongsTo('App\SalesDet');
    }
}
