<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TugasDosenController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelasIds = $dosen->mataKuliah->flatMap->kelas->pluck('id_kelas');
        $tugas = Tugas::whereIn('id_kelas', $kelasIds)->with('kelas')->get();
        return view('dosen.tugas.index', compact('tugas'));
    }

    public function create()
    {
        $dosen = Auth::guard('dosen')->user();
        $kelas = $dosen->mataKuliah->flatMap->kelas;
        return view('dosen.tugas.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_tugas' => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'deadline'    => 'required|date|after:now',
            'id_kelas'    => 'required|exists:kelas,id_kelas',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240', // 10MB
        ]);

        $data = $request->only(['judul_tugas', 'deskripsi', 'deadline', 'id_kelas']);

        // Upload file materi
        if ($request->hasFile('file_materi')) {
            $path = $request->file('file_materi')->store('public/tugas');
            $data['file_materi'] = $path;
        }

        Tugas::create($data);
        return redirect()->route('dosen.tugas.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $tugas = Tugas::findOrFail($id);
        $dosen = Auth::guard('dosen')->user();
        $kelas = $dosen->mataKuliah->flatMap->kelas;
        return view('dosen.tugas.edit', compact('tugas', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);

        $request->validate([
            'judul_tugas' => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'deadline'    => 'required|date',
            'id_kelas'    => 'required|exists:kelas,id_kelas',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
        ]);

        $data = $request->only(['judul_tugas', 'deskripsi', 'deadline', 'id_kelas']);

        // Upload file baru jika ada
        if ($request->hasFile('file_materi')) {
            // Hapus file lama
            if ($tugas->file_materi) {
                Storage::delete($tugas->file_materi);
            }
            $path = $request->file('file_materi')->store('public/tugas');
            $data['file_materi'] = $path;
        }

        $tugas->update($data);
        return redirect()->route('dosen.tugas.index')->with('success', 'Tugas berhasil diubah');
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        // Hapus file fisik (di booted model sudah otomatis)
        $tugas->delete();
        return redirect()->route('dosen.tugas.index')->with('success', 'Tugas dihapus');
    }
}