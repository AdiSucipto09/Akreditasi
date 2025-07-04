<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluasiPelaksanaan extends Model
{
    protected $table = 'evaluasi_pelaksanaan';
    protected $fillable = ['user_id', 'nomor_ptk', 'kategori_ptk', 'rencana_penyelesaian', 'realisasi_perbaikan', 'penanggungjawab_perbaikan','tahun_akademik_id'];
}
