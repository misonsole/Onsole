<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcPricingProcess extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','remarks','ps_id','date','status'];

    public $timestamps = true;
}
