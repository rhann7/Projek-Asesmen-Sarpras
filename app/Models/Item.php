<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'brand', 'origin', 'disposable', 'category_id', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function unit()
    {
        return $this->hasMany(UnitItem::class);
    }
}
