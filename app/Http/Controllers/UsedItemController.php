<?php

namespace App\Http\Controllers;

use App\Models\UsedItem;
use App\Models\UnitItem;
use App\Http\Resources\UsedItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsedItemController extends Controller
{
    public function index()
    {
        return UsedItemResource::collection(
            UsedItem::with(['user', 'unit.item'])->latest()->get()
        );
    }

    public function show($id)
    {
        return UsedItemResource::make(
            UsedItem::with(['user', 'unit.item'])->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id'     => 'required|exists:unit_items,id',
            'description' => 'required|string',
        ]);

        $unit = UnitItem::with('item')->findOrFail($validated['unit_id']);

        if (!$unit->item->disposable) {
            return response()->json(['Message' => 'Barang ini bukan barang sekali pakai.'], 422);
        }

        if ($unit->status !== 'used') {
            return response()->json(['Message' => 'Barang ini belum digunakan atau belum disetujui.'], 422);
        }

        $validated['user_id'] = Auth::id();

        $usedItem = UsedItem::create($validated);

        return UsedItemResource::make($usedItem)->additional([
            'Message' => 'Penggunaan barang berhasil dicatat.'
        ]);
    }

    public function destroy($id)
    {
        $usedItem = UsedItem::findOrFail($id);
        $usedItem->delete();

        return response()->json(['Message' => 'Data penggunaan berhasil dihapus.']);
    }
}
