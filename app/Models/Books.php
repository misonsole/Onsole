<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'book_name'];

    public function Role()
    {
        return $this->belongsTo('App\Models\RoleName', 'role', 'id');
    }
}
