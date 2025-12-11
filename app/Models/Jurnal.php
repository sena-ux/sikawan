<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $table = "t_jurnal";
    protected $guarded = ["id"];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'user_id', 'user_id');
    }

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class, 'id_dokumen', 'id');
    }

}
