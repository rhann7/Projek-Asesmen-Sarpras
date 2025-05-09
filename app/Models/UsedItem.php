<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsedItem extends Model
{
    protected $fillable = ['unit_id', 'user_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(UnitItem::class);
    }
}
