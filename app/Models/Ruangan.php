<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';

    protected $fillable = [
        'nama',
        'lantai',
        'keterangan',
    ];

    public function perangkat()
    {
        return $this->hasMany(Perangkat::class);
    }
}
