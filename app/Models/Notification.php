<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Notification extends Model
{
    protected $fillable = ['author_name', 'type', 'message', 'user_id'];

    // app/Models/Notification.php
public function users()
{
    return $this->belongsToMany(\App\Models\User::class, 'notification_user')
        ->withPivot('is_read', 'created_at', 'updated_at');
}


}
