<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($validated);

        return response()->json([
            'Message' => 'Kategori berhasil dibuat.'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update($validated);

        return response()->json([
            'Message' => 'Kategori berhasil diperbarui.'
        ], 200);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'Message' => 'Kategori berhasil dihapus.'
        ], 200);
    }
}
