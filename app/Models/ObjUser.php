<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjUser extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department', 'lead_name', 'emp_code'];
}
