<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of ruangan.
     */
    public function index()
    {
        $ruangan = Ruangan::withCount('perangkat')->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Daftar ruangan.',
            'data' => $ruangan->items(),
            'meta' => [
                'current_page' => $ruangan->currentPage(),
                'total' => $ruangan->total(),
                'per_page' => $ruangan->perPage(),
            ],
        ], 200);
    }

    /**
     * Store a newly created ruangan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lantai' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        $ruangan = Ruangan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ruangan berhasil ditambahkan.',
            'data' => $ruangan,
        ], 201);
    }

    /**
     * Update the specified ruangan.
     */
    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan tidak ditemukan.',
                'errors' => null,
            ], 404);
        }

        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'lantai' => 'sometimes|required|integer',
            'keterangan' => 'nullable|string',
        ]);

        $ruangan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ruangan berhasil diupdate.',
            'data' => $ruangan,
        ], 200);
    }

    /**
     * Remove the specified ruangan.
     */
    public function destroy($id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan tidak ditemukan.',
                'errors' => null,
            ], 404);
        }

        // Validasi: tidak boleh hapus jika masih ada perangkat
        if ($ruangan->perangkat()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan tidak dapat dihapus karena masih memiliki perangkat.',
                'errors' => null,
            ], 422);
        }

        $ruangan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ruangan berhasil dihapus.',
            'data' => null,
        ], 200);
    }
}
