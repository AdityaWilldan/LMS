<?php 
namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\UploadTugas;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa; // <--- TAMBAHKAN IMPORT INI

class NilaiController extends Controller 
{
    public function index() 
    { 
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        return response()->json(['data' => $mhs->uploadTugas()->with('tugas', 'penilaian')->get()]); 
    }

    public function nilaiAkhir() 
    {
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        
        $nilaiAkhir = $mhs->kelas()->with('mataKuliah')->get()->map(function($k) use ($mhs) {
            $uploads = UploadTugas::whereIn('id_tugas', $k->tugas->pluck('id_tugas'))->where('id_mahasiswa', $mhs->id_mahasiswa)->with('penilaian')->get();
            $avg = $uploads->filter(fn($u) => $u->penilaian && !is_null($u->penilaian->nilai))->avg(fn($u) => $u->penilaian->nilai);
            return ['mata_kuliah' => $k->mataKuliah->nama_matkul, 'nilai' => $avg ? round($avg, 2) : '-', 'sks' => $k->mataKuliah->sks];
        });
        return response()->json(['data' => $nilaiAkhir]);
    }
}