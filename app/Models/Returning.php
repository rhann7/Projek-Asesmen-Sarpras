<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Returning extends Model
{
    protected $fillable = ['borrowing_id', 'proof_image'];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}
