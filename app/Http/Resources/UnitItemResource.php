<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ID'             => $this->id,
            'Unit_Code'      => $this->unit_code,
            'Item_ID'        => $this->item_id,
            'Item_Name'      => optional($this->item)->name,
            'Item_Brand'     => optional($this->item)->brand,
            'Item_Origin'    => optional($this->item)->origin,
            'Location_ID'    => $this->location_id,
            'Location'       => $this->whenLoaded('location', fn ()
                             => optional($this->location)->name),
            'Condition'      => ucfirst($this->condition),
            'Status'         => ucfirst($this->status),
            'Created_At'     => $this->created_at->format('d-m-Y H:i'),
            'Updated_At'     => $this->updated_at->format('d-m-Y H:i'),
        ];
    }
}
