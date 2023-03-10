<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcJobOrder extends Model
{
    use HasFactory;

    protected $fillable = ['season', 'purpose', 'profit', 'project', 'remarks', 'product', 'last', 'progress', 'image', 'sequence', 'date', 'category', 'status', 'shape', 'sole', 'range_no', 'design_no', 'description', 'sequence'];

    public $timestamps = true;
}
