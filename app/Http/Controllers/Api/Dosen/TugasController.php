<?php 
namespace App\Http\Controllers\Api\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelasIds = $dosen->mataKuliah->flatMap->kelas->pluck('id_kelas');
        $tugas = Tugas::whereIn('id_kelas', $kelasIds)->with('kelas')->get();
        return response()->json(['data' => $tugas]);
    }

    public function show($id)
    {
        $tugas = Tugas::with('kelas')->findOrFail($id);
        return response()->json(['data' => $tugas]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_tugas' => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'deadline'    => 'required|date|after_or_equal:today', // Diperlonggar
            'id_kelas'    => 'required|exists:kelas,id_kelas',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $data = $request->only(['judul_tugas', 'deskripsi', 'deadline', 'id_kelas']);
        if ($request->hasFile('file_materi')) {
            $data['file_materi'] = $request->file('file_materi')->store('public/tugas');
        }

        $tugas = Tugas::create($data);
        return response()->json(['message' => 'Tugas berhasil ditambahkan', 'data' => $tugas], 201);
    }

    public function update(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);
        $request->validate([
            'judul_tugas' => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'deadline'    => 'required|date', // Tidak ada after:now untuk edit
            'id_kelas'    => 'required|exists:kelas,id_kelas',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $data = $request->only(['judul_tugas', 'deskripsi', 'deadline', 'id_kelas']);
        if ($request->hasFile('file_materi')) {
            if ($tugas->file_materi) Storage::delete($tugas->file_materi);
            $data['file_materi'] = $request->file('file_materi')->store('public/tugas');
        }

        $tugas->update($data);
        return response()->json(['message' => 'Tugas berhasil diubah', 'data' => $tugas]);
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();
        return response()->json(['message' => 'Tugas dihapus']);
    }
}