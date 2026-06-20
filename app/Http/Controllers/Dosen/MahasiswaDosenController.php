<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class MahasiswaDosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelas = $dosen->mataKuliah->flatMap->kelas;
        return view('dosen.mahasiswa.index', compact('kelas'));
    }

    public function show(int $id_kelas)
    {
        $kelas = Kelas::with('mahasiswa')->findOrFail($id_kelas);
        return view('dosen.mahasiswa.show', compact('kelas'));
    }
}