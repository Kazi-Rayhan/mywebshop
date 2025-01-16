<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function message_sender()
    {
        return $this->belongsTo(User::class, 'sender');
    }
    public function message_receiver()
    {
        return $this->belongsTo(User::class, 'receiver');
    }
}
