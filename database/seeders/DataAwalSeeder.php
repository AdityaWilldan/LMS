<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Tugas;
use Illuminate\Support\Facades\DB; // <-- gunakan DB
use Carbon\Carbon;

class DataAwalSeeder extends Seeder
{
    public function run()
    {
        // 1. Mata Kuliah
        $matkul1 = MataKuliah::create([
            'kode_matkul' => 'MK101',
            'nama_matkul' => 'Pemrograman Web',
            'sks' => 3,
            'id_dosen' => 1,
        ]);

        $matkul2 = MataKuliah::create([
            'kode_matkul' => 'MK102',
            'nama_matkul' => 'Basis Data',
            'sks' => 3,
            'id_dosen' => 2,
        ]);

        // 2. Kelas
        $kelas1 = Kelas::create([
            'nama_kelas' => 'A',
            'semester' => 1,
            'tahun_ajaran' => '2024/2025',
            'id_matkul' => $matkul1->id_matkul,
        ]);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'B',
            'semester' => 1,
            'tahun_ajaran' => '2024/2025',
            'id_matkul' => $matkul2->id_matkul,
        ]);

        // 3. Mahasiswa_Kelas (pakai DB::table)
        DB::table('mahasiswa_kelas')->insert([
            [
                'id_mahasiswa' => 1, // Budi
                'id_kelas' => $kelas1->id_kelas,
            ],
            [
                'id_mahasiswa' => 2, // Ani
                'id_kelas' => $kelas2->id_kelas,
            ],
        ]);

        // 4. Jadwal
        Jadwal::create([
            'id_kelas' => $kelas1->id_kelas,
            'hari' => 'Senin',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
            'ruangan' => 'R.101',
        ]);

        Jadwal::create([
            'id_kelas' => $kelas2->id_kelas,
            'hari' => 'Rabu',
            'jam_mulai' => '10:00:00',
            'jam_selesai' => '12:00:00',
            'ruangan' => 'R.202',
        ]);

        // 5. Tugas
        Tugas::create([
            'judul_tugas' => 'Tugas 1 - HTML & CSS',
            'deskripsi' => 'Buat halaman web sederhana',
            'deadline' => Carbon::now()->addDays(7),
            'id_kelas' => $kelas1->id_kelas,
        ]);

        Tugas::create([
            'judul_tugas' => 'Tugas 1 - Normalisasi Basis Data',
            'deskripsi' => 'Normalisasikan tabel hingga 3NF',
            'deadline' => Carbon::now()->addDays(10),
            'id_kelas' => $kelas2->id_kelas,
        ]);
    }
}