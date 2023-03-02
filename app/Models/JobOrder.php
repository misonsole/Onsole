<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    protected $fillable = ['season', 'purpose', 'project', 'profit', 'product', 'progress', 'image', 'sequence', 'date', 'remarks', 'last', 'category', 'status', 'shape', 'sole', 'range_no', 'design_no', 'description', 'sequence', 'pricing'];

    public $timestamps = true;
}
