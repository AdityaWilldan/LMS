<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetGamifikasiSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('🗑️ Menghapus data Gamifikasi...');

        // Nonaktifkan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data dari tabel-tabel gamifikasi
        DB::table('absensi')->truncate();
        DB::table('penilaian')->truncate();
        DB::table('upload_tugas')->truncate();
        DB::table('tugas')->truncate();
        DB::table('sesi_absen')->truncate();
        DB::table('jadwal')->truncate();
        DB::table('mahasiswa_kelas')->truncate();
        DB::table('kelas')->truncate();
        DB::table('mata_kuliah')->truncate();
        DB::table('mahasiswa')->truncate();
        DB::table('dosen')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ Data Gamifikasi berhasil dihapus!');
        $this->command->info('💡 Sekarang Anda bisa menjalankan seeder lain jika diperlukan.');
    }
}