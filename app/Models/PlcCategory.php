<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcCategory extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    public $timestamps = true;

    public function subdivisions()
    {
        return $this->hasMany(PlcSubCategory::class);
    }
}
