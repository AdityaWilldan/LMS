<?php
namespace App\Http\Controllers\Api\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\SesiAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelas = $dosen->mataKuliah->flatMap->kelas;
        return response()->json(['data' => $kelas]);
    }

    public function create($id_kelas)
    {
        $kelas = Kelas::with('mahasiswa', 'mataKuliah')->findOrFail($id_kelas);
        return response()->json(['data' => $kelas]);
    }

    public function store(Request $request, $id_kelas)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|array',
            'status.*' => 'in:Hadir,Izin,Sakit,Alpha',
        ]);

        $kelas = Kelas::findOrFail($id_kelas);
        
        foreach ($kelas->mahasiswa->pluck('id_mahasiswa') as $id) {
            if (isset($request->status[$id])) {
                Absensi::updateOrCreate(
                    ['id_mahasiswa' => $id, 'id_kelas' => $id_kelas, 'tanggal' => $request->tanggal],
                    ['status' => $request->status[$id]]
                );
            }
        }

        return response()->json(['message' => 'Absensi berhasil disimpan']);
    }

    public function sesiIndex()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelasIds = $dosen->mataKuliah->flatMap->kelas->pluck('id_kelas');
        $sesi = SesiAbsen::whereIn('id_kelas', $kelasIds)
            ->with('kelas')
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $mode = session('absensi_mode', 'hari_ini');
        
        return response()->json([
            'data' => $sesi,
            'mode' => $mode
        ]);
    }

    public function sesiCreate()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelas = $dosen->mataKuliah->flatMap->kelas;
        return response()->json(['data' => $kelas]);
    }

    public function sesiStore(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'tanggal' => 'required|date',
            'aktif' => 'sometimes|boolean',
        ]);

        $sesi = SesiAbsen::create([
            'id_kelas' => $request->id_kelas,
            'tanggal' => $request->tanggal,
            'aktif' => $request->boolean('aktif'),
        ]);

        return response()->json(['message' => 'Sesi absen berhasil dibuat', 'data' => $sesi], 201);
    }

    public function sesiToggle($id_sesi)
    {
        $sesi = SesiAbsen::findOrFail($id_sesi);
        $sesi->aktif = !$sesi->aktif;
        $sesi->save();
        
        return response()->json([
            'message' => 'Status sesi diubah',
            'data' => $sesi
        ]);
    }

    public function rekap($id_kelas, $tanggal = null)
    {
        $kelas = Kelas::with('mahasiswa')->findOrFail($id_kelas);
        $tanggal = $tanggal ?? date('Y-m-d');

        $absensi = Absensi::where('id_kelas', $id_kelas)
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('id_mahasiswa');

        return response()->json([
            'data' => [
                'kelas' => $kelas,
                'mahasiswa' => $kelas->mahasiswa,
                'absensi' => $absensi,
                'tanggal' => $tanggal
            ]
        ]);
    }

    public function toggleMode()
    {
        $mode = session('absensi_mode', 'hari_ini');
        $newMode = ($mode == 'hari_ini') ? 'bebas' : 'hari_ini';
        session(['absensi_mode' => $newMode]);
        
        return response()->json([
            'message' => 'Mode absensi diubah',
            'mode' => $newMode
        ]);
    }
}