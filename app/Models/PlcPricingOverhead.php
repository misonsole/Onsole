<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcPricingOverhead extends Model
{
    use HasFactory;

    protected $fillable = ['costing_id','value-set','description','remarks','pair','material'];

    public $timestamps = true;
}
