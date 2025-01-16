<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function children()
    {
        return $this->hasMany(Ticket::class, 'parent_id')->latest();
    }
    public function parent()
    {
        return $this->belongsTo(Ticket::class, 'parent_id');
    }
    public function scopeParents($query)
    {
        return $query->where('parent_id', null);
    }
}
