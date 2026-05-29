<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenance';

    protected $fillable = [
        'perangkat_id',
        'user_id',
        'tanggal',
        'jenis',
        'keterangan',
        'biaya',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'biaya' => 'decimal:2',
    ];

    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
