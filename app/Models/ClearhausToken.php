<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearhausToken extends Model
{
    use HasFactory;
    protected $table = 'clearhaus_access_tokens';
    protected $casts = ['expired_at' => 'datetime'];
    protected $guarded = [];
}
