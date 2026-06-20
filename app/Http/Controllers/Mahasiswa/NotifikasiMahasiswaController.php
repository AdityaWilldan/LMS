<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class NotifikasiMahasiswaController extends Controller
{
    public function index()
    {
        /** @var Mahasiswa $mahasiswa */
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $notifikasi = $mahasiswa->notifikasi()->orderBy('tanggal_kirim', 'desc')->get();
        // Tandai sudah dibaca
        $mahasiswa->notifikasi()->update(['status_baca' => 'sudah']);
        return view('mahasiswa.notifikasi.index', compact('notifikasi'));
    }
}