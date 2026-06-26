<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tugas;
use App\Models\Kelas;
use Carbon\Carbon;

class TugasSeeder extends Seeder
{
    public function run()
    {
        // Ambil kelas pertama (misal id=1)
        $kelas = Kelas::first();
        if (!$kelas) {
            $this->command->error('Tidak ada kelas. Buat kelas dulu.');
            return;
        }

        Tugas::create([
            'judul_tugas' => 'Tugas 1 - HTML Dasar',
            'deskripsi' => 'Buat halaman HTML sederhana dengan tag dasar',
            'deadline' => Carbon::now()->addDays(3),
            'id_kelas' => $kelas->id_kelas,
        ]);

        Tugas::create([
            'judul_tugas' => 'Tugas 2 - CSS Layout',
            'deskripsi' => 'Buat layout website menggunakan CSS flexbox',
            'deadline' => Carbon::now()->addDays(7),
            'id_kelas' => $kelas->id_kelas,
        ]);

        Tugas::create([
            'judul_tugas' => 'Tugas 3 - JavaScript Dasar',
            'deskripsi' => 'Buat fungsi manipulasi DOM',
            'deadline' => Carbon::now()->subDays(1), // sudah lewat
            'id_kelas' => $kelas->id_kelas,
        ]);
    }
}