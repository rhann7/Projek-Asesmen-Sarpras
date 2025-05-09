<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ID'         => $this->id,
            'Name'       => $this->name,
            'Email'      => $this->email,
            'Role'       => ucfirst($this->role),
            'Origin'     => $this->origin,
            'Created_At' => $this->created_at->format('d-m-Y H:i'),
            'Updated_At' => $this->updated_at->format('d-m-Y H:i'),
        ];
    }
}
