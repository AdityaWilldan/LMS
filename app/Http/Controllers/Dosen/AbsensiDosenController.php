<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiDosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelas = $dosen->mataKuliah->flatMap->kelas;
        return view('dosen.absensi.index', compact('kelas'));
    }

    public function create($id_kelas)
    {
        $kelas = Kelas::with('mahasiswa')->findOrFail($id_kelas);
        return view('dosen.absensi.create', compact('kelas'));
    }

    public function store(Request $request, $id_kelas)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|array',
            'status.*' => 'in:Hadir,Izin,Sakit,Alpha',
        ]);

        $kelas = Kelas::findOrFail($id_kelas);
        $mahasiswaIds = $kelas->mahasiswa->pluck('id_mahasiswa');

        foreach ($mahasiswaIds as $id) {
            if (isset($request->status[$id])) {
                Absensi::create([
                    'id_mahasiswa' => $id,
                    'id_kelas' => $id_kelas,
                    'tanggal' => $request->tanggal,
                    'status' => $request->status[$id],
                ]);
            }
        }

        return redirect()->route('dosen.absensi.index')->with('success', 'Absensi berhasil disimpan');
    }
}