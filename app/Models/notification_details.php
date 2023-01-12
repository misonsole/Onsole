<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\notifications;

class notification_details extends Model
{
    use HasFactory;

    protected $fillable = ['notification_id', 'assign_users', 'read_at','complaint', 'event', 'url','userid','name','image','complaint_id'];

    public function notifications()
    {
        return $this->hasone(notifications::class);
    }
}
