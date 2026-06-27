<?php
namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;

class AbsensiDosenController extends Controller
{
    public function index()
    {
        return view('dosen.absensi.index');
    }

    public function create($id_kelas)
    {
        return view('dosen.absensi.create', ['id_kelas' => $id_kelas]);
    }

    public function sesiIndex()
    {
        return view('dosen.absensi.sesi.index');
    }

    public function sesiCreate()
    {
        return view('dosen.absensi.sesi.create');
    }

    public function rekap($id_kelas, $tanggal = null)
    {
        return view('dosen.absensi.rekap', [
            'id_kelas' => $id_kelas,
            'tanggal' => $tanggal ?? date('Y-m-d')
        ]);
    }
}