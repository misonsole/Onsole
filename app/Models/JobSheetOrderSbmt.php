<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSheetOrderSbmt extends Model
{
    use HasFactory;

    protected $fillable = ['Job_Id', 'status', 'Last_No', 'Color', 's1', 's2', 's3', 's4', 's5', 's6', 's7', 's8', 's9', 's10', 'total'];

    public $timestamps = true;
}
