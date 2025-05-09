<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\UnitItem;
use App\Http\Resources\BorrowingResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        return BorrowingResource::collection(
            Borrowing::with(['user', 'unitItem', 'returning'])->latest()->get()
        );
    }

    public function show($id)
    {
        return BorrowingResource::make(Borrowing::with(['user', 'unitItem', 'returning'])->findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:unit_items,id',
            'description' => 'required|string',
        ]);

        $unitItem = UnitItem::findOrFail($validated['unit_id']);

        if ($unitItem->status !== 'available') {
            return response()->json([
                'Message' => 'Barang tidak tersedia untuk dipinjam.'
            ], 422);
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $borrowing = Borrowing::create($validated);

        return BorrowingResource::make($borrowing)->additional([
            'Message' => 'Peminjaman berhasil diajukan. Tunggu persetujuan admin.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:borrowed,used,returned,rejected'
        ]);

        $borrowing = Borrowing::findOrFail($id);
        $unitItem  = $borrowing->unitItem;
        $item      = $unitItem->item;

        $status = $validated['status'];

        if ($status === 'borrowed' && $item->disposable) {
            $status = 'used';
        }

        $borrowing->update(['status' => $status]);

        if (in_array($status, ['returned', 'rejected'])) {
            $unitItem->update(['status' => 'available']);
        } else {
            $unitItem->update(['status' => $status]);
        }

        return BorrowingResource::make($borrowing)->additional([
            'Message' => 'Status peminjaman berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if (in_array($borrowing->status, ['borrowed', 'used'])) {
            $borrowing->unitItem->update([
                'status' => 'available',
            ]);
        }

        $borrowing->delete();

        return response()->json(['Message' => 'Peminjaman berhasil dihapus.']);
    }
}
