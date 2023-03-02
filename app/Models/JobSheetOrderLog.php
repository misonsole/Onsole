<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSheetOrderLog extends Model
{
    use HasFactory;

    protected $fillable = ['Job_Id', 'fromd', 'transfer_to', 'timed', 'user', 'status', 'output', 'temp3'];

    public $timestamps = true;
}
