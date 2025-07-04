<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenelitianMahasiswa extends Model
{
    protected $table = 'penelitian_mahasiswa';

    protected $fillable = [
        'user_id',
        'judul_penelitian',
        'nama_mahasiswa',
        'nama_pembimbing',
        'tingkat',
        'sumber_dana',
        'bentuk_dana',
        'jumlah_dana',
        'kesesuaian_roadmap',
        'tahun_akademik_id'
    ];
}
