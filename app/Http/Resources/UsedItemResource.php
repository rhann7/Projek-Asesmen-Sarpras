<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsedItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ID'          => $this->id,
            'User'        => $this->whenLoaded('user', function () {
                return [
                    'ID'    => $this->user->id,
                    'Name'  => $this->user->name,
                    'Class' => $this->user->class,
                ];
            }),
            'Item'        => $this->whenLoaded('unit', function () {
                return [
                    'Unit_ID'   => $this->unit->id,
                    'Unit_Code' => $this->unit->unit_code,
                    'Name'      => optional($this->unit->item)->name,
                    'Brand'     => optional($this->unit->item)->brand,
                ];
            }),
            'Description' => $this->description,
            'Used_At'     => $this->created_at->format('d-m-Y H:i'),
        ];
    }
}
