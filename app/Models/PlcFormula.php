<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcFormula extends Model
{
    use HasFactory;

    protected $fillable = ['owner'];

    public $timestamps = true;
}
