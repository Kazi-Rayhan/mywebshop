<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = json_encode(explode(',', $value));
    }

    public function getValueAttribute($value)
    {
        if ($value) {
            return json_decode($value);
        }
    }
}
