<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['job_order_id', 'item_code', 'description', 'uom', 'type', 'tools', 'usages', 'material','quantity'];

    public $timestamps = true;
}
