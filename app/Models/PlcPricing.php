<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcPricing extends Model
{
    use HasFactory;

    protected $fillable = ['overhead_id', 'season', 'purpose', 'profit', 'project', 'remarks', 'product', 'last', 'progress', 'image', 'sequence', 'date', 'category', 'status', 'shape', 'sole', 'range_no', 'design_no', 'designer', 'description', 'sequence', 'profit_price'];

    public $timestamps = true;
}
