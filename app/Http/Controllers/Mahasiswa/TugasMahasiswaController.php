<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\UploadTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Mahasiswa;

class TugasMahasiswaController extends Controller
{
    // Halaman index: card per mata kuliah
    public function index()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kelas = $mahasiswa->kelas()->with('mataKuliah')->withCount('tugas')->get();
        return view('mahasiswa.tugas.index', compact('kelas'));
    }

    // Halaman detail tugas per kelas (tambahkan int pada parameter)
    public function tugasByKelas(int $id_kelas)
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $kelas = $mahasiswa->kelas()->with('mataKuliah')->findOrFail($id_kelas);
        $tugas = Tugas::where('id_kelas', $id_kelas)->get();
        return view('mahasiswa.tugas.bykelas', compact('kelas', 'tugas'));
    }

    // Halaman detail satu tugas
    public function show(int $id_tugas)
    {
        $tugas = Tugas::findOrFail($id_tugas);
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $upload = UploadTugas::where('id_tugas', $id_tugas)
                            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                            ->first();
        return view('mahasiswa.tugas.show', compact('tugas', 'upload'));
    }

    // Upload tugas
    public function upload(Request $request, int $id_tugas)
    {
        $tugas = Tugas::findOrFail($id_tugas);
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (Carbon::now()->greaterThan($tugas->deadline)) {
            return back()->withErrors('Melewati batas waktu pengumpulan');
        }

        $request->validate([
            'link' => 'required|url',
        ]);

        $upload = UploadTugas::where('id_tugas', $id_tugas)
                            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                            ->first();

        if ($upload) {
            $upload->update([
                'nama_file' => $request->link,
                'tanggal_upload' => Carbon::now(),
                'status' => 'terkumpul',
            ]);
            $message = 'Unggahan berhasil diubah';
        } else {
            UploadTugas::create([
                'id_tugas' => $id_tugas,
                'id_mahasiswa' => $mahasiswa->id_mahasiswa,
                'nama_file' => $request->link,
                'tanggal_upload' => Carbon::now(),
                'status' => 'terkumpul',
            ]);
            $message = 'Tugas berhasil diunggah';
        }

        return redirect()->route('mahasiswa.tugas.show', $id_tugas)->with('success', $message);
    }

    // Hapus upload
    public function deleteUpload(int $id_tugas)
    {
        $tugas = Tugas::findOrFail($id_tugas);
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (Carbon::now()->greaterThan($tugas->deadline)) {
            return back()->withErrors('Tidak dapat menghapus karena melewati deadline');
        }

        $upload = UploadTugas::where('id_tugas', $id_tugas)
                            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                            ->first();

        if ($upload) {
            $upload->delete();
            return back()->with('success', 'Unggahan dihapus');
        }

        return back()->withErrors('Tidak ada unggahan');
    }
}