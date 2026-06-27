<?php 
namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\UploadTugas;
use App\Models\Penilaian; // ✅ TAMBAHKAN IMPORT INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Mahasiswa;

class TugasController extends Controller
{
    public function index()
    {
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        return response()->json(['data' => $mhs->kelas()->with('mataKuliah')->withCount('tugas')->get()]);
    }

    public function tugasByKelas(int $id_kelas)
    {
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        $kelas = $mhs->kelas()->with('mataKuliah')->findOrFail($id_kelas);
        
        // Ambil semua tugas di kelas ini
        $tugas = Tugas::where('id_kelas', $id_kelas)->get();
        
        // TAMBAHKAN INFO UPLOAD UNTUK SETIAP TUGAS
        $tugasWithUpload = $tugas->map(function($t) use ($mhs) {
            $upload = UploadTugas::where('id_tugas', $t->id_tugas)
                ->where('id_mahasiswa', $mhs->id_mahasiswa)
                ->first();
            $t->upload = $upload;
            return $t;
        });
        
        return response()->json(['data' => ['kelas' => $kelas, 'tugas' => $tugasWithUpload]]);
    }

    public function show(int $id_tugas)
    {
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        $tugas = Tugas::with('kelas.mataKuliah')->findOrFail($id_tugas);
        $upload = UploadTugas::where('id_tugas', $id_tugas)
            ->where('id_mahasiswa', $mhs->id_mahasiswa)
            ->first();
        
        return response()->json([
            'data' => [
                'tugas' => $tugas,
                'upload' => $upload,
                'now' => Carbon::now()->toIso8601String()
            ]
        ]);
    }

    public function upload(Request $request, int $id_tugas)
    {
        $tugas = Tugas::findOrFail($id_tugas);
        
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        if (Carbon::now()->greaterThan($tugas->deadline)) {
            return response()->json(['message' => 'Melewati deadline'], 400);
        }
        
        $request->validate(['link' => 'required|url']);
        
        $upload = UploadTugas::where('id_tugas', $id_tugas)
            ->where('id_mahasiswa', $mhs->id_mahasiswa)
            ->first();
        
        if ($upload) {
            $upload->update([
                'nama_file' => $request->link,
                'tanggal_upload' => Carbon::now(),
                'status' => 'terkumpul',
            ]);
            $message = 'Unggahan berhasil diubah';
        } else {
            $upload = UploadTugas::create([
                'id_tugas' => $id_tugas,
                'id_mahasiswa' => $mhs->id_mahasiswa,
                'nama_file' => $request->link,
                'tanggal_upload' => Carbon::now(),
                'status' => 'terkumpul',
            ]);
            $message = 'Tugas berhasil diunggah';
        }
        
        return response()->json(['message' => $message, 'data' => $upload]);
    }

    public function deleteUpload(int $id_tugas)
    {
        $tugas = Tugas::findOrFail($id_tugas);
        
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        if (Carbon::now()->greaterThan($tugas->deadline)) {
            return response()->json(['message' => 'Tidak dapat menghapus karena melewati deadline'], 400);
        }
        
        $upload = UploadTugas::where('id_tugas', $id_tugas)
            ->where('id_mahasiswa', $mhs->id_mahasiswa)
            ->first();
        
        if ($upload) {
            // ✅ HAPUS PENILAIAN TERKAIT TERLEBIH DAHULU
            Penilaian::where('id_upload', $upload->id_upload)->delete();
            
            // ✅ BARU HAPUS UPLOAD
            $upload->delete();
            return response()->json(['message' => 'Unggahan dihapus']);
        }
        
        return response()->json(['message' => 'Tidak ada unggahan'], 404);
    }

    public function tugasBelumDikerjakan()
    {
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        $tugas = Tugas::whereIn('id_kelas', $mhs->kelas->pluck('id_kelas'))->with('kelas')->get();
        
        $belum = $tugas->filter(fn($t) => !UploadTugas::where('id_tugas', $t->id_tugas)->where('id_mahasiswa', $mhs->id_mahasiswa)->exists())
            ->map(fn($t) => [
                'id' => $t->id_tugas, 
                'judul' => $t->judul_tugas, 
                'deadline' => $t->deadline->format('d/m/Y H:i'), 
                'deadline_timestamp' => $t->deadline->timestamp,
                'kelas' => $t->kelas->nama_kelas ?? '-',
                'is_expired' => $t->deadline < now()
            ]);
            
        return response()->json(['data' => $belum]);
    }
}