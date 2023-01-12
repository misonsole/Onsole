<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcLastNumber extends Model
{
    use HasFactory;

    protected $fillable = ['last_no'];
    
    public $timestamps = true;
}
