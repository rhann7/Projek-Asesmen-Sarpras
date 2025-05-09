<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = ['user_id', 'unit_id', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(UnitItem::class);
    }

    public function returning()
    {
        return $this->hasOne(Returning::class);
    }
}
