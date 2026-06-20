<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class AbsensiMahasiswaController extends Controller
{
    public function index()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $absensi = $mahasiswa->absensi()->with('kelas.mataKuliah')->orderBy('tanggal', 'desc')->get();
        return view('mahasiswa.absensi.index', compact('absensi'));
    }
}