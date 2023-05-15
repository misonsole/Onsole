<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcSubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'category_id'];

    public $timestamps = true;

    public function divisions()
    {
        return $this->belongsTo(Category::class);
    }
}
