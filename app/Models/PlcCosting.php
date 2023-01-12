<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcCosting extends Model
{
    use HasFactory;

    protected $fillable = ['season', 'purpose', 'profit', 'project', 'product', 'progress', 'image', 'sequence', 'date', 'category', 'status', 'shape', 'sole', 'range_no', 'design_no', 'description', 'sequence'];

    public $timestamps = true;
}
