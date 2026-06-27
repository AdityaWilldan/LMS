<?php 
// app/Http/Controllers/Dosen/TugasDosenController.php (CONTOH MODIFIKASI)
namespace App\Http\Controllers\Dosen;
use App\Http\Controllers\Controller;

class TugasDosenController extends Controller
{
    // HAPUS semua query database di sini.
    // Biarkan kosong atau hanya return view.
    public function index()
    {
        return view('dosen.tugas.index');
    }

    public function create()
    {
        return view('dosen.tugas.create');
    }

    public function edit($id)
    {
        // Kirim ID agar bisa dipakai di JS Blade jika perlu
        return view('dosen.tugas.edit', ['id_tugas' => $id]); 
    }

    // Method store, update, destroy HAPUS saja dari sini, 
    // karena sudah dihandle penuh oleh API Controller.
}