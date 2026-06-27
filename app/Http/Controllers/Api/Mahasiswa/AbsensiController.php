<?php 
namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SesiAbsen;
use App\Models\Absensi;
use App\Models\Mahasiswa; // <--- TAMBAHKAN IMPORT INI
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        /** @var Mahasiswa $mahasiswa */ // <--- TAMBAHKAN PHPDOC INI
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        $kelas = $mahasiswa->kelas()->with('mataKuliah')->get();
        $today = Carbon::today()->toDateString();
        $mode = session('absensi_mode', 'hari_ini');

        foreach ($kelas as $k) {
            $query = SesiAbsen::where('id_kelas', $k->id_kelas)->where('aktif', true);
            if ($mode == 'hari_ini') $query->where('tanggal', $today);
            
            $sesiList = $query->orderBy('tanggal', 'desc')->get();
            foreach ($sesiList as $sesi) {
                $sesi->sudah_absen = Absensi::where('id_kelas', $k->id_kelas)
                    ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)->whereDate('tanggal', $sesi->tanggal)->exists();
            }
            $k->sesi_list = $sesiList;
            $k->sesi_aktif = $sesiList->count() > 0;
        }
        
        $absensi = $mahasiswa->absensi()->with('kelas.mataKuliah')->orderBy('tanggal', 'desc')->get();
        return response()->json(['data' => ['kelas' => $kelas, 'absensi' => $absensi, 'mode' => $mode]]);
    }

    // Tambahkan type hint 'int' pada $id_kelas untuk menghilangkan warning P1132
    public function absen(Request $request, int $id_kelas) 
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $mode = session('absensi_mode', 'hari_ini');
        $tanggal = ($mode == 'hari_ini') ? Carbon::today()->toDateString() : $request->input('tanggal');

        $sesi = SesiAbsen::where('id_kelas', $id_kelas)->where('tanggal', $tanggal)->where('aktif', true)->first();
        if (!$sesi) return response()->json(['message' => 'Sesi tidak aktif'], 400);

        if (Absensi::where('id_kelas', $id_kelas)->where('id_mahasiswa', $mahasiswa->id_mahasiswa)->whereDate('tanggal', $tanggal)->exists()) {
            return response()->json(['message' => 'Anda sudah absen'], 400);
        }

        $absen = Absensi::create(['id_mahasiswa' => $mahasiswa->id_mahasiswa, 'id_kelas' => $id_kelas, 'tanggal' => $tanggal, 'status' => 'Hadir']);
        return response()->json(['message' => 'Absen berhasil!', 'data' => $absen]);
    }
}