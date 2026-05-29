<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Perangkat;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of peminjaman records.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with('perangkat.ruangan');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('perangkat_id')) {
            $query->where('perangkat_id', $request->perangkat_id);
        }

        $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Daftar peminjaman.',
            'data' => $peminjaman->items(),
            'meta' => [
                'current_page' => $peminjaman->currentPage(),
                'total' => $peminjaman->total(),
                'per_page' => $peminjaman->perPage(),
            ],
        ], 200);
    }

    /**
     * Store a newly created peminjaman.
     * Validates device is in 'baik' condition and not currently borrowed.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'perangkat_id' => 'required|exists:perangkat,id',
            'nama_peminjam' => 'required|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'tanggal_pinjam' => 'required|date',
        ]);

        $perangkat = Perangkat::find($validated['perangkat_id']);

        // Perangkat harus dalam kondisi baik
        if ($perangkat->kondisi !== 'baik') {
            return response()->json([
                'success' => false,
                'message' => 'Perangkat tidak dapat dipinjam karena kondisi tidak baik (kondisi: ' . $perangkat->kondisi . ').',
                'errors' => null,
            ], 422);
        }

        // Perangkat tidak boleh sedang dipinjam
        $sedangDipinjam = Peminjaman::where('perangkat_id', $perangkat->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($sedangDipinjam) {
            return response()->json([
                'success' => false,
                'message' => 'Perangkat sedang dipinjam oleh orang lain.',
                'errors' => null,
            ], 422);
        }

        $validated['status'] = 'dipinjam';

        $peminjaman = Peminjaman::create($validated);
        $peminjaman->load('perangkat');

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil dicatat.',
            'data' => $peminjaman,
        ], 201);
    }

    /**
     * Mark a peminjaman as returned.
     */
    public function kembali($id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman tidak ditemukan.',
                'errors' => null,
            ], 404);
        }

        if ($peminjaman->status === 'dikembalikan') {
            return response()->json([
                'success' => false,
                'message' => 'Perangkat sudah dikembalikan sebelumnya.',
                'errors' => null,
            ], 422);
        }

        $peminjaman->update([
            'tanggal_kembali' => now()->toDateString(),
            'status' => 'dikembalikan',
        ]);

        $peminjaman->load('perangkat');

        return response()->json([
            'success' => true,
            'message' => 'Perangkat berhasil dikembalikan.',
            'data' => $peminjaman,
        ], 200);
    }

    /**
     * Remove the specified peminjaman record.
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman tidak ditemukan.',
                'errors' => null,
            ], 404);
        }

        $peminjaman->delete();

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil dihapus.',
            'data' => null,
        ], 200);
    }
}
