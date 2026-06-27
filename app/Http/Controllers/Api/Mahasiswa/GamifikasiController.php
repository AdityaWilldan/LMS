<?php
namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\UploadTugas;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GamifikasiController extends Controller
{
    public function profil()
    {
        /** @var Mahasiswa $mhs */
        $mhs = Auth::guard('mahasiswa')->user();

        $totalUpload = UploadTugas::where('id_mahasiswa', $mhs->id_mahasiswa)->count();
        
        $totalHadir = Absensi::where('id_mahasiswa', $mhs->id_mahasiswa)
            ->where('status', 'Hadir')
            ->count();

        $bonusNilai = DB::table('upload_tugas')
            ->join('penilaian', 'upload_tugas.id_upload', '=', 'penilaian.id_upload')
            ->where('upload_tugas.id_mahasiswa', $mhs->id_mahasiswa)
            ->sum(DB::raw('FLOOR(penilaian.nilai / 10)'));

        $poinUpload = $totalUpload * 10;
        $poinHadir = $totalHadir * 5;
        $totalPoin = $poinUpload + $poinHadir + $bonusNilai;

        $rank = $this->hitungRank($totalPoin);

        return response()->json([
            'data' => [
                'mahasiswa' => [
                    'id_mahasiswa' => $mhs->id_mahasiswa,
                    'nama' => $mhs->nama_mahasiswa,
                    'nim' => $mhs->nim,
                    'foto' => $mhs->foto_url ?? asset('images/default-avatar.png'),
                ],
                'stats' => [
                    'total_upload' => $totalUpload,
                    'total_hadir' => $totalHadir,
                    'bonus_nilai' => $bonusNilai,
                    'total_poin' => $totalPoin,
                ],
                'rank' => $rank,
            ]
        ]);
    }

    public function leaderboard()
    {
        $mahasiswa = Mahasiswa::select('id_mahasiswa', 'nama_mahasiswa', 'nim', 'foto')
            ->withCount([
                'uploadTugas',
                'absensi as total_hadir' => function($q) {
                    $q->where('status', 'Hadir');
                }
            ])
            ->with('uploadTugas.penilaian')
            ->get();

        $leaderboard = $mahasiswa->map(function($mhs) {
            $poinUpload = $mhs->upload_tugas_count * 10;
            $poinHadir = $mhs->total_hadir * 5;
            
            $bonusNilai = 0;
            foreach ($mhs->uploadTugas as $upload) {
                if ($upload->penilaian && $upload->penilaian->nilai) {
                    $bonusNilai += floor($upload->penilaian->nilai / 10);
                }
            }

            $totalPoin = $poinUpload + $poinHadir + $bonusNilai;
            $rank = $this->hitungRank($totalPoin);

            return [
                'id_mahasiswa' => $mhs->id_mahasiswa,
                'nama' => $mhs->nama_mahasiswa,
                'nim' => $mhs->nim,
                'foto' => $mhs->foto_url ?? asset('images/default-avatar.png'),
                'total_upload' => $mhs->upload_tugas_count,
                'total_hadir' => $mhs->total_hadir,
                'total_poin' => $totalPoin,
                'rank' => $rank,
            ];
        });

        $leaderboard = $leaderboard->sortByDesc('total_poin')->values();

        $leaderboard = $leaderboard->map(function($item, $index) {
            $item['posisi'] = $index + 1;
            return $item;
        });

        return response()->json([
            'data' => $leaderboard->take(50)
        ]);
    }

    /**
     * Hitung rank berdasarkan poin
     * Menggunakan gambar PNG dari folder public/images/
     */
    private function hitungRank($poin)
    {
        if ($poin >= 1001) {
            return [
                'nama' => 'Sage',
                'warna' => '#8E44AD',       // Ungu gelap (bijaksana)
                'warna_bg' => 'linear-gradient(135deg, #8E44AD 0%, #9B59B6 100%)',
                'gambar' => asset('images/sage-removebg-preview.png'),
                'min_poin' => 1001,
                'max_poin' => null,
            ];
        } elseif ($poin >= 501) {
            return [
                'nama' => 'Great',
                'warna' => '#FFD700',       // Emas
                'warna_bg' => 'linear-gradient(135deg, #FFD700 0%, #FFA500 100%)',
                'gambar' => asset('images/great-removebg-preview.png'),
                'min_poin' => 501,
                'max_poin' => 1000,
            ];
        } elseif ($poin >= 201) {
            return [
                'nama' => 'Master',
                'warna' => '#9B59B6',       // Ungu
                'warna_bg' => 'linear-gradient(135deg, #9B59B6 0%, #8E44AD 100%)',
                'gambar' => asset('images/master-removebg-preview.png'),
                'min_poin' => 201,
                'max_poin' => 500,
            ];
        } elseif ($poin >= 101) {
            return [
                'nama' => 'Platinum',
                'warna' => '#3498DB',       // Biru
                'warna_bg' => 'linear-gradient(135deg, #3498DB 0%, #2980B9 100%)',
                'gambar' => asset('images/platinum-removebg-preview.png'),
                'min_poin' => 101,
                'max_poin' => 200,
            ];
        } elseif ($poin >= 51) {
            return [
                'nama' => 'Gold',
                'warna' => '#F39C12',       // Oranye emas
                'warna_bg' => 'linear-gradient(135deg, #F39C12 0%, #E67E22 100%)',
                'gambar' => asset('images/gold-removebg-preview.png'),
                'min_poin' => 51,
                'max_poin' => 100,
            ];
        } elseif ($poin >= 21) {
            return [
                'nama' => 'Silver',
                'warna' => '#95A5A6',       // Abu perak
                'warna_bg' => 'linear-gradient(135deg, #BDC3C7 0%, #95A5A6 100%)',
                'gambar' => asset('images/silver-removebg-preview.png'),
                'min_poin' => 21,
                'max_poin' => 50,
            ];
        } else {
            return [
                'nama' => 'Bronze',
                'warna' => '#CD7F32',       // Coklat perunggu
                'warna_bg' => 'linear-gradient(135deg, #CD7F32 0%, #A0522D 100%)',
                'gambar' => asset('images/bronze-removebg-preview.png'),
                'min_poin' => 0,
                'max_poin' => 20,
            ];
        }
    }
}