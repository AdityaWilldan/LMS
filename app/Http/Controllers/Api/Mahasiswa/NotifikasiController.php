<?php 
namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa; // <--- TAMBAHKAN IMPORT INI

class NotifikasiController extends Controller 
{
    public function index() 
    {
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();
        
        $notif = $mhs->notifikasi()->orderBy('tanggal_kirim', 'desc')->get();
        $mhs->notifikasi()->update(['status_baca' => 'sudah']);
        return response()->json(['data' => $notif]);
    }
}