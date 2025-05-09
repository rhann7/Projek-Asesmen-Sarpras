<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        return Location::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Location::create($validated);

        return response()->json([
            'Message' => 'Location berhasil dibuat.'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $location = Location::find($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $location->update($validated);

        return response()->json([
            'Message' => 'Location berhasil diperbarui.'
        ], 200);
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return response()->json([
            'Message' => 'Location berhasil dihapus.'
        ], 200);
    }
}
