<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objectives extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'title', 'description', 'weightage', 'comment', 'department','emp_code','review','totalscore'];

    public $timestamps = false;
}
