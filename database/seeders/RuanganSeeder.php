<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    public function run(): void
    {
        $ruangan = [
            ['nama' => 'ICU', 'lantai' => 2, 'keterangan' => 'Intensive Care Unit'],
            ['nama' => 'UGD', 'lantai' => 1, 'keterangan' => 'Unit Gawat Darurat'],
            ['nama' => 'Radiologi', 'lantai' => 1, 'keterangan' => 'Ruang pemeriksaan radiologi'],
            ['nama' => 'Farmasi', 'lantai' => 1, 'keterangan' => 'Bagian farmasi dan apotek'],
            ['nama' => 'Laboratorium', 'lantai' => 2, 'keterangan' => 'Lab pemeriksaan klinis'],
            ['nama' => 'Ruang Server', 'lantai' => 3, 'keterangan' => 'Data center rumah sakit'],
            ['nama' => 'Administrasi', 'lantai' => 1, 'keterangan' => 'Ruang administrasi umum'],
        ];

        foreach ($ruangan as $r) {
            Ruangan::create($r);
        }
    }
}
