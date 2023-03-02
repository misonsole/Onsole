<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['costing_id','item_code','description','uom','division','subdivision','output','cut_code','fac_qty','total_qty','material','color','color_id','process','total','rate','value','profit','price','created_at','updated_at'];

    public $timestamps = true;
}
