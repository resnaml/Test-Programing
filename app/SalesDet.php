<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesDet extends Model
{
    protected $guarded = ['id'];

    public function sales(){
        return $this->belongsTo('App\Sales','sales_id');
    }

    public function barang(){
        return $this->belongsTo('App\Barang','barang_id');
    }

}
