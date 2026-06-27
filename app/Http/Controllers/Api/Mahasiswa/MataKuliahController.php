<?php 
namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa; // <--- TAMBAHKAN IMPORT INI

class MataKuliahController extends Controller 
{
    public function index() 
    { 
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        return response()->json(['data' => $mhs->kelas()->with('mataKuliah')->get()]); 
    } 
    
    public function show(int $id_kelas) 
    { 
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        return response()->json(['data' => $mhs->kelas()->with('mataKuliah', 'tugas', 'jadwal')->findOrFail($id_kelas)]); 
    }
}