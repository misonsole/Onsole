<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcLocation extends Model
{
    use HasFactory;

    protected $fillable = ['location_no'];

    public $timestamps = true;
}
