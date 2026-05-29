<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of maintenance records.
     */
    public function index(Request $request)
    {
        $query = Maintenance::with(['perangkat', 'user']);

        if ($request->has('perangkat_id')) {
            $query->where('perangkat_id', $request->perangkat_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $maintenance = $query->orderBy('tanggal', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Daftar maintenance.',
            'data' => $maintenance->items(),
            'meta' => [
                'current_page' => $maintenance->currentPage(),
                'total' => $maintenance->total(),
                'per_page' => $maintenance->perPage(),
            ],
        ], 200);
    }

    /**
     * Store a newly created maintenance record.
     * user_id is auto-filled from the authenticated user (teknisi).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'perangkat_id' => 'required|exists:perangkat,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:perbaikan,perawatan',
            'keterangan' => 'required|string',
            'biaya' => 'nullable|numeric|min:0',
            'status' => 'sometimes|in:pending,dikerjakan,selesai',
        ]);

        $validated['user_id'] = $request->user()->id;

        $maintenance = Maintenance::create($validated);
        $maintenance->load(['perangkat', 'user']);

        return response()->json([
            'success' => true,
            'message' => 'Maintenance berhasil dicatat.',
            'data' => $maintenance,
        ], 201);
    }

    /**
     * Update maintenance status.
     * Uses DB::transaction when status changes to 'selesai' to update device condition.
     */
    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::find($id);

        if (!$maintenance) {
            return response()->json([
                'success' => false,
                'message' => 'Maintenance tidak ditemukan.',
                'errors' => null,
            ], 404);
        }

        $validated = $request->validate([
            'tanggal' => 'sometimes|date',
            'jenis' => 'sometimes|in:perbaikan,perawatan',
            'keterangan' => 'sometimes|string',
            'biaya' => 'nullable|numeric|min:0',
            'status' => 'sometimes|in:pending,dikerjakan,selesai',
            'kondisi_setelah' => 'sometimes|in:baik,rusak_ringan,rusak_berat,tidak_aktif',
        ]);

        // If status is being set to 'selesai', use transaction to also update perangkat kondisi
        if (isset($validated['status']) && $validated['status'] === 'selesai') {
            DB::transaction(function () use ($maintenance, $validated) {
                $kondisi = $validated['kondisi_setelah'] ?? 'baik';
                unset($validated['kondisi_setelah']);

                $maintenance->update($validated);

                // Update kondisi perangkat after maintenance is completed
                $maintenance->perangkat->update(['kondisi' => $kondisi]);
            });
        } else {
            unset($validated['kondisi_setelah']);
            $maintenance->update($validated);
        }

        $maintenance->load(['perangkat', 'user']);

        return response()->json([
            'success' => true,
            'message' => 'Maintenance berhasil diupdate.',
            'data' => $maintenance,
        ], 200);
    }

    /**
     * Remove the specified maintenance record.
     */
    public function destroy($id)
    {
        $maintenance = Maintenance::find($id);

        if (!$maintenance) {
            return response()->json([
                'success' => false,
                'message' => 'Maintenance tidak ditemukan.',
                'errors' => null,
            ], 404);
        }

        $maintenance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Maintenance berhasil dihapus.',
            'data' => null,
        ], 200);
    }
}
