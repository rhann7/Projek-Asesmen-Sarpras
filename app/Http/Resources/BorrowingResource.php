<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BorrowingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ID'            => $this->id,
            'User'          => $this->whenLoaded('user', function () {
                return [
                    'ID'    => optional($this->user)->id,
                    'Name'  => optional($this->user)->name,
                    'Class' => optional($this->user)->class,
                ];
            }),
            'Item'          => $this->whenLoaded('unitItem', function () {
                return [
                    'ID'    => $this->unit_id,
                    'Code'  => optional($this->unitItem)->unit_code,
                    'Name'  => optional($this->unitItem?->item)->name,
                    'Brand' => optional($this->unitItem?->item)->brand,
                ];
            }),
            'Item_Location' => optional($this->unitItem?->location)->name,
            'Status'        => ucfirst($this->status),
            'Description'   => $this->description,
            'Borrowed_At'   => $this->created_at->format('d-m-Y H:i'),
            'Returned_At'   => $this->updated_at?->format('d-m-Y H:i'),
        ];
    }
}
