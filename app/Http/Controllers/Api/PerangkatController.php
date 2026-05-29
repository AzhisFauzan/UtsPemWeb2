<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Perangkat;
use Illuminate\Http\Request;

class PerangkatController extends Controller
{
    /**
     * Display a listing of perangkat with optional filters.
     */
    public function index(Request $request)
    {
        $query = Perangkat::with('ruangan');

        // Filter by ruangan_id
        if ($request->has('ruangan_id')) {
            $query->where('ruangan_id', $request->ruangan_id);
        }

        // Filter by kondisi
        if ($request->has('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter by jenis
        if ($request->has('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $perangkat = $query->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Daftar perangkat.',
            'data' => $perangkat->items(),
            'meta' => [
                'current_page' => $perangkat->currentPage(),
                'total' => $perangkat->total(),
                'per_page' => $perangkat->perPage(),
            ],
        ], 200);
    }

    /**
     * Display the specified perangkat with maintenance & peminjaman history.
     */
    public function show($id)
    {
        $perangkat = Perangkat::with(['ruangan', 'maintenance.user', 'peminjaman'])->find($id);

        if (!$perangkat) {
            return response()->json([
                'success' => false,
                'message' => 'Perangkat tidak ditemukan.',
                'errors' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail perangkat.',
            'data' => $perangkat,
        ], 200);
    }

    /**
     * Store a newly created perangkat.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:pc,laptop,printer,monitor,server,network,lainnya',
            'merk' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:perangkat,serial_number',
            'ruangan_id' => 'required|exists:ruangan,id',
            'kondisi' => 'sometimes|in:baik,rusak_ringan,rusak_berat,tidak_aktif',
            'tanggal_pembelian' => 'nullable|date',
        ]);

        $perangkat = Perangkat::create($validated);
        $perangkat->load('ruangan');

        return response()->json([
            'success' => true,
            'message' => 'Perangkat berhasil ditambahkan.',
            'data' => $perangkat,
        ], 201);
    }

    /**
     * Update the specified perangkat.
     */
    public function update(Request $request, $id)
    {
        $perangkat = Perangkat::find($id);

        if (!$perangkat) {
            return response()->json([
                'success' => false,
                'message' => 'Perangkat tidak ditemukan.',
                'errors' => null,
            ], 404);
        }

        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'jenis' => 'sometimes|required|in:pc,laptop,printer,monitor,server,network,lainnya',
            'merk' => 'sometimes|required|string|max:255',
            'serial_number' => 'sometimes|required|string|max:255|unique:perangkat,serial_number,' . $perangkat->id,
            'ruangan_id' => 'sometimes|required|exists:ruangan,id',
            'kondisi' => 'sometimes|in:baik,rusak_ringan,rusak_berat,tidak_aktif',
            'tanggal_pembelian' => 'nullable|date',
        ]);

        $perangkat->update($validated);
        $perangkat->load('ruangan');

        return response()->json([
            'success' => true,
            'message' => 'Perangkat berhasil diupdate.',
            'data' => $perangkat,
        ], 200);
    }

    /**
     * Remove the specified perangkat.
     */
    public function destroy($id)
    {
        $perangkat = Perangkat::find($id);

        if (!$perangkat) {
            return response()->json([
                'success' => false,
                'message' => 'Perangkat tidak ditemukan.',
                'errors' => null,
            ], 404);
        }

        $perangkat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Perangkat berhasil dihapus.',
            'data' => null,
        ], 200);
    }
}
