<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcSizeRange extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    public $timestamps = true;
}
