<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tugas;
use App\Models\UploadTugas;

class ApiMahasiswaController extends Controller
{
    /**
     * Mendapatkan daftar tugas yang belum dikerjakan oleh mahasiswa yang login.
     * Response berupa JSON untuk diproses oleh JavaScript di frontend.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tugasBelumDikerjakan()
    {
        /** @var \App\Models\Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kelasIds = $mahasiswa->kelas->pluck('id_kelas')->toArray();

        // Ambil semua tugas dari kelas yang diambil mahasiswa
        $tugas = Tugas::whereIn('id_kelas', $kelasIds)->with('kelas')->get();

        $belumDikerjakan = [];
        foreach ($tugas as $t) {
            // Cek apakah sudah ada upload untuk tugas ini
            $upload = UploadTugas::where('id_tugas', $t->id_tugas)
                                ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                                ->first();

            if (!$upload) {
                $belumDikerjakan[] = [
                    'id' => $t->id_tugas,
                    'judul' => $t->judul_tugas,
                    'deadline' => $t->deadline->format('d/m/Y H:i'),
                    'deadline_timestamp' => $t->deadline->timestamp,
                    'kelas' => $t->kelas->nama_kelas ?? '-',
                    'is_expired' => $t->deadline < now(),
                ];
            }
        }

        return response()->json($belumDikerjakan);
    }
}