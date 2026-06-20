<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class MataKuliahMahasiswaController extends Controller
{
    public function index()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kelas = $mahasiswa->kelas()->with('mataKuliah')->get();
        return view('mahasiswa.matakuliah.index', compact('kelas'));
    }

    public function show(int $id_kelas)
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kelas = $mahasiswa->kelas()->with('mataKuliah', 'tugas', 'jadwal')->findOrFail($id_kelas);
        return view('mahasiswa.matakuliah.show', compact('kelas'));
    }
}