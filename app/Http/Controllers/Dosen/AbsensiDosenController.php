<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\SesiAbsen;
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

    // ===== Manajemen Sesi Absen =====
    public function sesiIndex()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelasIds = $dosen->mataKuliah->flatMap->kelas->pluck('id_kelas');
        $sesi = SesiAbsen::whereIn('id_kelas', $kelasIds)->with('kelas')->orderBy('tanggal', 'desc')->get();
        return view('dosen.absensi.sesi.index', compact('sesi'));
    }

    public function sesiCreate()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelas = $dosen->mataKuliah->flatMap->kelas;
        return view('dosen.absensi.sesi.create', compact('kelas'));
    }

    public function sesiStore(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'tanggal' => 'required|date',
            'aktif' => 'sometimes|boolean',
        ]);

        SesiAbsen::create([
            'id_kelas' => $request->id_kelas,
            'tanggal' => $request->tanggal,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()->route('dosen.absensi.sesi.index')->with('success', 'Sesi absen berhasil dibuat');
    }

    public function sesiToggle($id_sesi)
    {
        $sesi = SesiAbsen::findOrFail($id_sesi);
        $sesi->aktif = !$sesi->aktif;
        $sesi->save();
        return back()->with('success', 'Status sesi diubah');
    }

    public function rekap($id_kelas, $tanggal = null)
    {
        $kelas = Kelas::with('mahasiswa')->findOrFail($id_kelas);
        $tanggal = $tanggal ?? date('Y-m-d');

        $absensi = Absensi::where('id_kelas', $id_kelas)
                        ->whereDate('tanggal', $tanggal)
                        ->get()
                        ->keyBy('id_mahasiswa');

        $mahasiswa = $kelas->mahasiswa;
        return view('dosen.absensi.rekap', compact('kelas', 'mahasiswa', 'absensi', 'tanggal'));
    }

    // ===== Mode Absensi =====
    public function toggleMode()
    {
        $mode = session('absensi_mode', 'hari_ini');
        $newMode = ($mode == 'hari_ini') ? 'bebas' : 'hari_ini';
        session(['absensi_mode' => $newMode]);
        return back()->with('success', 'Mode absensi diubah menjadi: ' . ucfirst($newMode));
    }
}