<?php 
// app/Http/Controllers/Api/Dosen/NilaiController.php
namespace App\Http\Controllers\Api\Dosen;
use App\Http\Controllers\Controller;
use App\Models\UploadTugas;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelasIds = $dosen->mataKuliah->flatMap->kelas->pluck('id_kelas');
        $uploadTugas = UploadTugas::whereHas('tugas', fn($q) => $q->whereIn('id_kelas', $kelasIds))
            ->with('tugas', 'mahasiswa', 'penilaian')->get();
        return response()->json(['data' => $uploadTugas]);
    }
    public function create(int $id_upload)
    {
        return response()->json(['data' => UploadTugas::findOrFail($id_upload)]);
    }
    public function store(Request $request, int $id_upload)
    {
        $request->validate(['nilai' => 'required|numeric|min:0|max:100', 'feedback' => 'nullable|string']);
        $penilaian = Penilaian::updateOrCreate(['id_upload' => $id_upload], $request->only(['nilai', 'feedback']));
        return response()->json(['message' => 'Nilai berhasil disimpan', 'data' => $penilaian]);
    }
}
?>