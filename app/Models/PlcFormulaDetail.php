<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlcFormulaDetail extends Model
{
    use HasFactory;

    protected $fillable = ['oh_id', 'p_id', 'dep', 'pcpd', 'noe', 'role_name', 'aspd', 'nowd', 'pds', 'ilo', 'dloh1', 'idloh1', 'foh', 'idloh2', 't_oh1', 'capacity', 'dloh2', 'idloh3', 'dloh3', 't_oh2', 'un_a_oh'];

    public $timestamps = true;
}
