<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perangkat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis', ['pc', 'laptop', 'printer', 'monitor', 'server', 'network', 'lainnya']);
            $table->string('merk');
            $table->string('serial_number')->unique();
            $table->foreignId('ruangan_id')->constrained('ruangan')->cascadeOnDelete();
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_aktif'])->default('baik');
            $table->date('tanggal_pembelian')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perangkat');
    }
};
