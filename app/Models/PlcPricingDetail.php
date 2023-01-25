<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcPricingDetail extends Model
{
    use HasFactory;

    protected $fillable = ['costing_id','item_code','description','uom','division','subdivision','output','cut_code','fac_qty','total_qty','material','process','total','rate','value','profit','price'];

    public $timestamps = true;
}
