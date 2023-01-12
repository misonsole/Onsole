<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;

    protected $fillable = ['season', 'last', 'color', 'status', 'sample', 'article', 'product', 'image', 'sequence', 'date', 'sq_no'];

    public $timestamps = true;
}
