<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\notification_details;

class notifications extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'event_at', 'read_at', 'complaint_id'];

    public function notification_details()
    {
        return $this->belongsTo(notification_details::class);
    }
}
