<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\SitasiLuaranPenelitianDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SitasiLuaranPenelitianDosenController extends Controller
{
    public function index()
    {
        return view('pages.sitasi_luaran_penelitian_dosen');
    }

    public function show()
    {
        if (Auth::user()->id) {
            $sitasi_luaran_penelitian_dosen = SitasiLuaranPenelitianDosen::where('user_id', Auth::user()->id)->get();

            // Ambil data dari tabel Komentar berdasarkan nama_tabel
            // dan prodi_id yang sesuai dengan user yang sedang login
            $tabel = (new SitasiLuaranPenelitianDosen())->getTable(); 
            $komentar = Komentar::where('nama_tabel', $tabel)->where('prodi_id', Auth::user()->id)->get();
        }
    
        return view('pages.sitasi_luaran_penelitian_dosen', compact('sitasi_luaran_penelitian_dosen', 'komentar'));
    }

    public function add(Request $request)
    {
        SitasiLuaranPenelitianDosen::create([
            'user_id' => Auth::user()->id,
            'nama' => $request->nama,
            'judul_artikel' => $request->judul_artikel,
            'jumlah_sitasi' => $request->jumlah_sitasi,
            'link_sitasi' => $request->link_sitasi,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $sitasi_luaran_penelitian_dosen = SitasiLuaranPenelitianDosen::find($id);
        $sitasi_luaran_penelitian_dosen->nama = $request->nama;
        $sitasi_luaran_penelitian_dosen->judul_artikel = $request->judul_artikel;
        $sitasi_luaran_penelitian_dosen->jumlah_sitasi = $request->jumlah_sitasi;
        $sitasi_luaran_penelitian_dosen->link_sitasi = $request->link_sitasi;
        $sitasi_luaran_penelitian_dosen->user_id = Auth::user()->id;
        $sitasi_luaran_penelitian_dosen->save();

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $sitasi_luaran_penelitian_dosen = SitasiLuaranPenelitianDosen::find($id);
        $sitasi_luaran_penelitian_dosen->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
