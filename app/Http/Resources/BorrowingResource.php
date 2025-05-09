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
            'User_ID'       => $this->whenLoaded('unit', fn ()
                            => optional($this->user)->id),
            'User_Email'    => $this->whenLoaded('unit', fn ()
                            => optional($this->user)->email),
            'Item_ID'       => $this->whenLoaded('unit', fn ()
                            => optional($this->unit->item)->id),
            'Item_Code'     => $this->whenLoaded('unit', fn ()
                            => optional($this->unit)->unit_code),
            'Item_Location' => $this->whenLoaded('unit', fn ()
                            => optional($this->unit->location)->name),
            'Status'        => ucfirst($this->status),
            'Description'   => $this->description,
            'Borrowed_At'   => $this->created_at->format('d-m-Y H:i'),
            'Returned_At'   => $this->updated_at?->format('d-m-Y H:i'),
        ];
    }
}
