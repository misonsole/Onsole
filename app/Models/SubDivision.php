<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDivision extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'division_id'];

    public $timestamps = true;

    public function divisions()
    {
        return $this->belongsTo(Division::class);
    }
}
