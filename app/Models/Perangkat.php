<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    use HasFactory;

    protected $table = 'perangkat';

    protected $fillable = [
        'nama',
        'jenis',
        'merk',
        'serial_number',
        'ruangan_id',
        'kondisi',
        'tanggal_pembelian',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function maintenance()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
