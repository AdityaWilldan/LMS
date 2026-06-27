<?php 
// app/Http/Controllers/Api/Mahasiswa/JadwalController.php
namespace App\Http\Controllers\Api\Mahasiswa;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
class JadwalController extends Controller {
    public function index() {
        $mhs = Auth::guard('mahasiswa')->user();
        $jadwal = Jadwal::whereIn('id_kelas', $mhs->kelas->pluck('id_kelas'))->with('kelas.mataKuliah')->orderBy('hari')->orderBy('jam_mulai')->get();
        return response()->json(['data' => $jadwal]);
    }
}
?>