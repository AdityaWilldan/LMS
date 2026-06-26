<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\SesiAbsen;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiMahasiswaController extends Controller
{
    public function index()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kelas = $mahasiswa->kelas()->with('mataKuliah')->get();
        $today = Carbon::today()->toDateString();
        $mode = session('absensi_mode', 'hari_ini');

        foreach ($kelas as $k) {
            $query = SesiAbsen::where('id_kelas', $k->id_kelas)->where('aktif', true);
            if ($mode == 'hari_ini') {
                $query->where('tanggal', $today);
            }
            $sesiList = $query->orderBy('tanggal', 'desc')->get();

            // Tambahkan properti 'sudah_absen' untuk setiap sesi
            foreach ($sesiList as $sesi) {
                $sesi->sudah_absen = Absensi::where('id_kelas', $k->id_kelas)
                                        ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                                        ->whereDate('tanggal', $sesi->tanggal)
                                        ->exists();
            }

            $k->sesi_list = $sesiList;
            $k->sesi_aktif = $sesiList->count() > 0;

            // Untuk mode hari ini, kita tetap butuh properti 'sudah_absen' di level kelas
            if ($mode == 'hari_ini') {
                $k->sudah_absen = Absensi::where('id_kelas', $k->id_kelas)
                                        ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                                        ->whereDate('tanggal', $today)
                                        ->exists();
            }
        }

        $absensi = $mahasiswa->absensi()->with('kelas.mataKuliah')->orderBy('tanggal', 'desc')->get();
        return view('mahasiswa.absensi.index', compact('kelas', 'absensi', 'mode'));
    }

    public function absen(Request $request, $id_kelas)
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $mode = session('absensi_mode', 'hari_ini');

        if ($mode == 'hari_ini') {
            $tanggal = Carbon::today()->toDateString();
            $sesi = SesiAbsen::where('id_kelas', $id_kelas)
                            ->where('tanggal', $tanggal)
                            ->where('aktif', true)
                            ->first();
            if (!$sesi) {
                return back()->withErrors('Tidak ada sesi aktif hari ini.');
            }
        } else {
            $tanggal = $request->input('tanggal');
            if (!$tanggal) {
                return back()->withErrors('Tanggal tidak valid.');
            }
            $sesi = SesiAbsen::where('id_kelas', $id_kelas)
                            ->where('tanggal', $tanggal)
                            ->where('aktif', true)
                            ->first();
            if (!$sesi) {
                return back()->withErrors('Sesi tidak aktif atau tidak ditemukan.');
            }
        }

        $existing = Absensi::where('id_kelas', $id_kelas)
                            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                            ->whereDate('tanggal', $tanggal)
                            ->exists();
        if ($existing) {
            return back()->withErrors('Anda sudah absen untuk tanggal ini.');
        }

        Absensi::create([
            'id_mahasiswa' => $mahasiswa->id_mahasiswa,
            'id_kelas' => $id_kelas,
            'tanggal' => $tanggal,
            'status' => 'Hadir',
        ]);

        return redirect()->route('mahasiswa.absensi.index')->with('success', 'Absen berhasil!');
    }
}