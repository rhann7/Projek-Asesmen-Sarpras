<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Returning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturningController extends Controller
{
    public function index()
    {
        return Returning::with(['borrowing.unitItem.masterItem', 'user'])->get();
    }

    public function show($id)
    {
        return Returning::with(['borrowing.unitItem.masterItem', 'user'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrowing_id' => 'required|exists:borrowings,id',
            'description' => 'nullable|string',
        ]);

        $borrowing = Borrowing::with('unitItem')->findOrFail($validated['borrowing_id']);

        if ($borrowing->status !== 'borrowed') {
            return response()->json([
                'Message' => 'Barang belum dalam status dipinjam atau sudah dikembalikan.'
            ], 400);
        }

        $validated['user_id'] = Auth::id();

        $returning = Returning::create($validated);

        $borrowing->update(['status' => 'returned']);
        $borrowing->unitItem->update(['status' => 'available']);

        return response()->json([
            'message' => 'Pengembalian berhasil dicatat.',
            'data' => $returning->load(['borrowing.unitItem.item', 'user'])
        ]);
    }
}
