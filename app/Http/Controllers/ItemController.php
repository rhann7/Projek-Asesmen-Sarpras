<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Resources\ItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $item = Item::with('category')->withCount('units')->get();

        return ItemResource::collection($item);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'brand'       => 'required|string|max:255',
            'origin'      => 'required|string|max:255',
            'disposable'  => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('items', 'public');
            $validated['image'] = $image;
        }

        $item = Item::create($validated);

        return ItemResource::make($item)->additional([
            'Message' => 'Item berhasil dibuat.'
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'brand'       => 'sometimes|string|max:255',
            'origin'      => 'sometimes|string|max:255',
            'disposable'  => 'sometimes|boolean',
            'category_id' => 'sometimes|exists:categories,id',
            'image'       => 'sometimes|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
    
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($validated);

        return ItemResource::make($item)->additional([
            'Message' => 'Item berhasil diperbaharui.'
        ]);
    }

    public function destroy(Item $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'Message' => 'Item berhasil dihapus.'
        ]);
    }
}
