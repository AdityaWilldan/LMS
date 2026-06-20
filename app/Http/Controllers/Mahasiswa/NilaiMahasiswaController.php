<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\UploadTugas;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class NilaiMahasiswaController extends Controller
{
    public function index()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $uploads = $mahasiswa->uploadTugas()->with('tugas', 'penilaian')->get();
        return view('mahasiswa.nilai.index', compact('uploads'));
    }

    public function nilaiAkhir()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kelas = $mahasiswa->kelas()->with('mataKuliah')->get();
        $nilaiAkhir = [];

        foreach ($kelas as $k) {
            $tugasIds = $k->tugas->pluck('id_tugas');
            $uploads = UploadTugas::whereIn('id_tugas', $tugasIds)
                                ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                                ->with('penilaian')
                                ->get();
            $totalNilai = $uploads->filter(function($u) {
                return $u->penilaian && !is_null($u->penilaian->nilai);
            })->avg(function($u) {
                return $u->penilaian->nilai;
            });

            $nilaiAkhir[] = [
                'mata_kuliah' => $k->mataKuliah->nama_matkul,
                'nilai' => $totalNilai ? round($totalNilai, 2) : '-',
                'sks' => $k->mataKuliah->sks,
            ];
        }

        return view('mahasiswa.nilai.akhir', compact('nilaiAkhir'));
    }
}