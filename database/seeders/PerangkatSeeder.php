<?php

namespace Database\Seeders;

use App\Models\Perangkat;
use Illuminate\Database\Seeder;

class PerangkatSeeder extends Seeder
{
    public function run(): void
    {
        $perangkat = [
            [
                'nama' => 'PC Pendaftaran 01',
                'jenis' => 'pc',
                'merk' => 'Lenovo ThinkCentre',
                'serial_number' => 'LNV-PC-001',
                'ruangan_id' => 7, // Administrasi
                'kondisi' => 'baik',
                'tanggal_pembelian' => '2023-03-15',
            ],
            [
                'nama' => 'Laptop Dokter ICU',
                'jenis' => 'laptop',
                'merk' => 'Dell Latitude 5540',
                'serial_number' => 'DLL-LP-001',
                'ruangan_id' => 1, // ICU
                'kondisi' => 'baik',
                'tanggal_pembelian' => '2023-06-20',
            ],
            [
                'nama' => 'Printer Farmasi',
                'jenis' => 'printer',
                'merk' => 'Epson L3210',
                'serial_number' => 'EPS-PR-001',
                'ruangan_id' => 4, // Farmasi
                'kondisi' => 'baik',
                'tanggal_pembelian' => '2023-01-10',
            ],
            [
                'nama' => 'Monitor Radiologi PACS',
                'jenis' => 'monitor',
                'merk' => 'LG 27UK850',
                'serial_number' => 'LG-MN-001',
                'ruangan_id' => 3, // Radiologi
                'kondisi' => 'baik',
                'tanggal_pembelian' => '2022-11-05',
            ],
            [
                'nama' => 'Server Utama RS',
                'jenis' => 'server',
                'merk' => 'HPE ProLiant DL380',
                'serial_number' => 'HPE-SV-001',
                'ruangan_id' => 6, // Ruang Server
                'kondisi' => 'baik',
                'tanggal_pembelian' => '2022-08-01',
            ],
            [
                'nama' => 'Switch Core Network',
                'jenis' => 'network',
                'merk' => 'Cisco Catalyst 9300',
                'serial_number' => 'CSC-NW-001',
                'ruangan_id' => 6, // Ruang Server
                'kondisi' => 'baik',
                'tanggal_pembelian' => '2022-08-01',
            ],
            [
                'nama' => 'PC Laboratorium 01',
                'jenis' => 'pc',
                'merk' => 'HP ProDesk 400',
                'serial_number' => 'HP-PC-001',
                'ruangan_id' => 5, // Laboratorium
                'kondisi' => 'rusak_ringan',
                'tanggal_pembelian' => '2023-02-20',
            ],
            [
                'nama' => 'Printer UGD',
                'jenis' => 'printer',
                'merk' => 'Brother DCP-T720DW',
                'serial_number' => 'BRO-PR-001',
                'ruangan_id' => 2, // UGD
                'kondisi' => 'baik',
                'tanggal_pembelian' => '2023-05-12',
            ],
            [
                'nama' => 'Laptop Admin Keuangan',
                'jenis' => 'laptop',
                'merk' => 'ASUS ExpertBook',
                'serial_number' => 'ASS-LP-001',
                'ruangan_id' => 7, // Administrasi
                'kondisi' => 'rusak_berat',
                'tanggal_pembelian' => '2021-09-30',
            ],
            [
                'nama' => 'Access Point UGD',
                'jenis' => 'network',
                'merk' => 'Ubiquiti UniFi AP',
                'serial_number' => 'UBQ-NW-001',
                'ruangan_id' => 2, // UGD
                'kondisi' => 'baik',
                'tanggal_pembelian' => '2023-04-18',
            ],
        ];

        foreach ($perangkat as $p) {
            Perangkat::create($p);
        }
    }
}
