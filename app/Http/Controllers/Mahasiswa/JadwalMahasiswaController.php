<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class JadwalMahasiswaController extends Controller
{
    public function index()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kelasIds = $mahasiswa->kelas->pluck('id_kelas');
        $jadwal = Jadwal::whereIn('id_kelas', $kelasIds)
                    ->with('kelas.mataKuliah')
                    ->orderBy('hari')
                    ->orderBy('jam_mulai')
                    ->get();
        return view('mahasiswa.jadwal.index', compact('jadwal'));
    }
}