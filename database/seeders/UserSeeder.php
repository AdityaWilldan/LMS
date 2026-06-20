<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data lama
        Dosen::truncate();
        Mahasiswa::truncate();

        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Buat akun dosen
        Dosen::create([
            'nama_dosen' => 'Dr. Ahmad',
            'email' => 'ahmad@univ.ac.id',
            'username' => 'ahmad',
            'password' => Hash::make('password'),
        ]);

        Dosen::create([
            'nama_dosen' => 'Dr. Siti',
            'email' => 'siti@univ.ac.id',
            'username' => 'siti',
            'password' => Hash::make('12345678'),
        ]);

        // Buat akun mahasiswa
        Mahasiswa::create([
            'nim' => '123456',
            'nama_mahasiswa' => 'Budi Santoso',
            'email' => 'budi@univ.ac.id',
            'username' => 'budi',
            'password' => Hash::make('password'),
            'status_aktif' => 'aktif',
        ]);

        Mahasiswa::create([
            'nim' => '789012',
            'nama_mahasiswa' => 'Ani Rahayu',
            'email' => 'ani@univ.ac.id',
            'username' => 'ani',
            'password' => Hash::make('12345678'),
            'status_aktif' => 'aktif',
        ]);
    }
}