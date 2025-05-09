<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ID'          => $this->id,
            'Name'        => $this->name,
            'Brand'       => $this->brand,
            'Origin'      => $this->origin,
            'Disposable'  => ucfirst($this->disposable ? 'Yes' : 'No'),
            'Category'    => $this->whenLoaded('category', fn ()
                          => optional($this->category)->name),
            'Units_Count' => $this->units_count,
            'Image'       => $this->image,
            'Created_At'  => $this->created_at->format('d-m-Y H:i'),
            'Updated_At'  => $this->updated_at->format('d-m-Y H:i'),
        ];
    }
}
