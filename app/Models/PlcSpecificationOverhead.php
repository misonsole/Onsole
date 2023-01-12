<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcSpecificationOverhead extends Model
{
    use HasFactory;

    protected $fillable = ['specification_id','value-set','description','remarks','pair','material'];

    public $timestamps = true;
}
