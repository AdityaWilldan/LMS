<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\UploadTugas;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiDosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelasIds = $dosen->mataKuliah->flatMap->kelas->pluck('id_kelas');
        $uploadTugas = UploadTugas::whereHas('tugas', function($q) use ($kelasIds) {
            $q->whereIn('id_kelas', $kelasIds);
        })->with('tugas', 'mahasiswa', 'penilaian')->get();
        return view('dosen.nilai.index', compact('uploadTugas'));
    }

    public function create(int $id_upload)
    {
        $upload = UploadTugas::findOrFail($id_upload);
        return view('dosen.nilai.create', compact('upload'));
    }

    public function store(Request $request, int $id_upload)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $upload = UploadTugas::findOrFail($id_upload);
        $penilaian = Penilaian::where('id_upload', $id_upload)->first();
        if ($penilaian) {
            $penilaian->update($request->only(['nilai', 'feedback']));
        } else {
            Penilaian::create([
                'id_upload' => $id_upload,
                'nilai' => $request->nilai,
                'feedback' => $request->feedback,
            ]);
        }
        return redirect()->route('dosen.nilai.index')->with('success', 'Nilai berhasil disimpan');
    }
}