<?php
namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;

class TugasMahasiswaController extends Controller
{
    public function index()
    {
        return view('mahasiswa.tugas.index');
    }

    public function tugasByKelas(int $id_kelas)
    {
        return view('mahasiswa.tugas.bykelas', ['id_kelas' => $id_kelas]);
    }

    public function show(int $id_tugas)
    {
        return view('mahasiswa.tugas.show', ['id_tugas' => $id_tugas]);
    }
}