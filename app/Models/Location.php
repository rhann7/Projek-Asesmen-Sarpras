<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name'];

    public function unitItems()
    {
        return $this->hasMany(UnitItem::class);
    }
}
