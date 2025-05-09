<?php

namespace App\Http\Controllers;

use App\Models\UnitItem;
use App\Http\Resources\UnitItemResource;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UnitItemController extends Controller
{
    public function index()
    {
        return UnitItemResource::collection(UnitItem::with('item', 'location')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'     => 'required|exists:items,id',
            'location_id' => 'required|exists:locations,id',
            'quantity'    => 'required|integer|min:1',
        ]);

        $units = [];

        for ($i = 0; $i < $validated['quantity']; $i++) {
            do {
                $unitCode = strtoupper(Str::random(6));
            } while (UnitItem::where('unit_code', $unitCode)->exists());

            $units[] = UnitItem::create([
                'item_id'     => $validated['item_id'],
                'location_id' => $validated['location_id'],
                'unit_code'   => $unitCode
            ])->id;
        }

        $createdUnits = UnitItem::with(['item', 'location'])->whereIn('id', $units)->get();

        return UnitItemResource::collection($createdUnits)->additional([
            'Message' => 'Barang berhasil ditambahkan.',
            'Meta' => [
                'Quantity' => $validated['quantity']
            ]
        ]);
    }

    public function update(Request $request, UnitItem $unitItem)
    {
        $validated = $request->validate([
            'location_id' => 'sometimes|exists:locations,id',
            'condition'   => 'sometimes|in:good,bad,broken',
            'status'      => 'sometimes|in:available,borrowed,used,repaired,lost',
        ]);

        $unitItem->update($validated);

        return UnitItemResource::make($unitItem)->additional([
            'Message' => 'Barang berhasil diperbaharui.'
        ]);
    }

    public function destroy(UnitItem $unitItem)
    {
        $unitItem->delete();

        return response()->json([
            'Message' => 'Unit barang berhasil dihapus.'
        ]);
    }
}
