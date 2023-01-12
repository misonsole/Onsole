<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'subcategory', 'type', 'dep', 'nature', 'message', 'doc', 'userid', 'username', 'status', 'month', 'complaint' ,'date' ,'time', 'approve_by', 'update_time'];
}
