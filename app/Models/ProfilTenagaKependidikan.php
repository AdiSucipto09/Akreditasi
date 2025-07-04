<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilTenagaKependidikan extends Model
{
    protected $table = 'profil_tenaga_kependidikan';

    protected $fillable = [
        'user_id',
        'nama',
        'nipy',
        'kualifikasi_pendidikan',
        'jabatan',
        'bidang_keahlian',
        'kesesuaian_bidang_kerja',
        'tahun_akademik_id'
    ];
}
