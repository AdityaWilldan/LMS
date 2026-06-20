<?php
namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller
{
    public function tugas($id)
    {
        $tugas = Tugas::findOrFail($id);

        // Cek apakah file ada
        if (!$tugas->file_materi || !Storage::exists($tugas->file_materi)) {
            abort(404, 'File tidak ditemukan');
        }

        // Opsional: cek akses untuk mahasiswa hanya bisa download dari tugas yang diikuti
        // Jika login sebagai mahasiswa, cek apakah mahasiswa mengambil kelas tersebut
        if (Auth::guard('mahasiswa')->check()) {
            $mahasiswa = Auth::guard('mahasiswa')->user();
            $kelasIds = $mahasiswa->kelas->pluck('id_kelas')->toArray();
            if (!in_array($tugas->id_kelas, $kelasIds)) {
                abort(403, 'Anda tidak memiliki akses ke tugas ini');
            }
        }

        // Jika login sebagai dosen, cek apakah dosen pengampu matkul tersebut
        if (Auth::guard('dosen')->check()) {
            $dosen = Auth::guard('dosen')->user();
            $matkulIds = $dosen->mataKuliah->pluck('id_matkul')->toArray();
            $kelas = $tugas->kelas;
            if (!$kelas || !in_array($kelas->id_matkul, $matkulIds)) {
                abort(403, 'Anda tidak memiliki akses ke tugas ini');
            }
        }

        // Jika tidak login sama sekali, tolak akses
        if (!Auth::guard('dosen')->check() && !Auth::guard('mahasiswa')->check()) {
            abort(403, 'Silakan login terlebih dahulu');
        }

        // Download file
        $path = Storage::path($tugas->file_materi);
        $originalName = basename($tugas->file_materi);
        
        return response()->download($path, $originalName);
    }
}