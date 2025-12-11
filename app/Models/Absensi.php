<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 't_absensi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'user_id', 'user_id');
    }
}
