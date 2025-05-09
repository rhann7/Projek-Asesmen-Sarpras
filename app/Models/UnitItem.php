<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitItem extends Model
{
    protected $fillable = ['unit_code', 'item_id', 'location_id', 'condition', 'status'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
