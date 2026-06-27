<?php 
// app/Http/Controllers/Api/Dosen/MahasiswaController.php
namespace App\Http\Controllers\Api\Dosen;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();
        return response()->json(['data' => $dosen->mataKuliah->flatMap->kelas]);
    }
    public function show(int $id_kelas)
    {
        return response()->json(['data' => Kelas::with('mahasiswa')->findOrFail($id_kelas)]);
    }
}
?>