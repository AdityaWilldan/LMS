<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class GamifikasiSeeder extends Seeder
{
    /**
     * SEEDER GAMIFIKASI
     * 
     * Sistem Poin:
     * - Upload tugas: 10 poin per tugas
     * - Hadir absensi: 5 poin per kehadiran
     * - Bonus nilai: floor(nilai / 10)
     * 
     * Rank:
     * - Bronze: 0-20 poin
     * - Silver: 21-50 poin
     * - Gold: 51-100 poin
     * - Platinum: 101-200 poin
     * - Master: 201-500 poin
     * - Great: 501-1000 poin
     * - Sage: 1001+ poin
     */
    public function run()
    {
        $this->command->info('🎮 Memulai Gamifikasi Seeder...');

        // Nonaktifkan foreign key sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Bersihkan data lama (kecuali users)
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

        $this->seedDosen();
        $this->seedMataKuliah();
        $this->seedKelas();
        $this->seedMahasiswa();
        $this->seedMahasiswaKelas();
        $this->seedJadwal();
        $this->seedTugas();
        $this->seedSesiAbsen();
        $this->seedUploadTugas();
        $this->seedPenilaian();
        $this->seedAbsensi();

        $this->command->info('✅ Gamifikasi Seeder selesai!');
        $this->showSummary();
    }

    /**
     * 6 Dosen
     */
    private function seedDosen()
    {
        $this->command->info('👨‍🏫 Membuat data dosen...');
        
        $dosen = [
            ['nama_dosen' => 'Dr. Ahmad Fauzi, M.Kom.', 'email' => 'ahmad@univ.ac.id', 'username' => 'ahmad', 'password' => Hash::make('password')],
            ['nama_dosen' => 'Dr. Siti Nurhaliza, M.T.', 'email' => 'siti@univ.ac.id', 'username' => 'siti', 'password' => Hash::make('password')],
            ['nama_dosen' => 'Prof. Budi Santoso, Ph.D.', 'email' => 'budi.dosen@univ.ac.id', 'username' => 'budidosen', 'password' => Hash::make('password')],
            ['nama_dosen' => 'Dr. Rina Kartika, M.Sc.', 'email' => 'rina@univ.ac.id', 'username' => 'rina', 'password' => Hash::make('password')],
            ['nama_dosen' => 'Dr. Doni Prasetyo, M.Kom.', 'email' => 'doni@univ.ac.id', 'username' => 'doni', 'password' => Hash::make('password')],
            ['nama_dosen' => 'Dr. Maya Anggraini, M.T.', 'email' => 'maya@univ.ac.id', 'username' => 'maya', 'password' => Hash::make('password')],
        ];

        foreach ($dosen as $d) {
            DB::table('dosen')->insert($d);
        }
    }

    /**
     * 8 Mata Kuliah
     */
    private function seedMataKuliah()
    {
        $this->command->info('📚 Membuat mata kuliah...');
        
        $matkul = [
            ['kode_matkul' => 'MK101', 'nama_matkul' => 'Pemrograman Web', 'sks' => 3, 'id_dosen' => 1],
            ['kode_matkul' => 'MK102', 'nama_matkul' => 'Basis Data', 'sks' => 3, 'id_dosen' => 2],
            ['kode_matkul' => 'MK103', 'nama_matkul' => 'Algoritma & Pemrograman', 'sks' => 4, 'id_dosen' => 3],
            ['kode_matkul' => 'MK104', 'nama_matkul' => 'Jaringan Komputer', 'sks' => 3, 'id_dosen' => 4],
            ['kode_matkul' => 'MK105', 'nama_matkul' => 'Sistem Operasi', 'sks' => 3, 'id_dosen' => 5],
            ['kode_matkul' => 'MK106', 'nama_matkul' => 'Rekayasa Perangkat Lunak', 'sks' => 3, 'id_dosen' => 6],
            ['kode_matkul' => 'MK107', 'nama_matkul' => 'Kecerdasan Buatan', 'sks' => 3, 'id_dosen' => 3],
            ['kode_matkul' => 'MK108', 'nama_matkul' => 'Keamanan Informasi', 'sks' => 3, 'id_dosen' => 4],
        ];

        foreach ($matkul as $m) {
            DB::table('mata_kuliah')->insert($m);
        }
    }

    /**
     * 8 Kelas (1 per mata kuliah)
     */
    private function seedKelas()
    {
        $this->command->info('🏫 Membuat kelas...');
        
        $kelas = [];
        for ($i = 1; $i <= 8; $i++) {
            $kelas[] = [
                'nama_kelas' => 'Kelas ' . chr(64 + $i), // A, B, C, D, E, F, G, H
                'semester' => 1,
                'tahun_ajaran' => '2024/2025',
                'id_matkul' => $i,
            ];
        }

        foreach ($kelas as $k) {
            DB::table('kelas')->insert($k);
        }
    }


    private function seedMahasiswa()
    {
        $this->command->info('🎓 Membuat mahasiswa...');
        
        $mahasiswa = [
            // SAGE (target: 1300+ poin)
            // Upload 50 tugas (500) + Hadir 80x (400) + Bonus nilai 400 = 1300
            ['nim' => '2024001', 'nama_mahasiswa' => 'Raka Wijaya', 'email' => 'raka@student.ac.id', 'username' => 'raka', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            
            // GREAT (target: 760 poin)
            // Upload 30 tugas (300) + Hadir 50x (250) + Bonus 210 = 760
            ['nim' => '2024002', 'nama_mahasiswa' => 'Dewi Lestari', 'email' => 'dewi@student.ac.id', 'username' => 'dewi', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            
            // MASTER x2 (target: 350 poin)
            ['nim' => '2024003', 'nama_mahasiswa' => 'Andi Pratama', 'email' => 'andi@student.ac.id', 'username' => 'andi', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            ['nim' => '2024004', 'nama_mahasiswa' => 'Sari Wulandari', 'email' => 'sari@student.ac.id', 'username' => 'sari', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            
            // PLATINUM x3 (target: 150 poin)
            ['nim' => '2024005', 'nama_mahasiswa' => 'Bambang Hermawan', 'email' => 'bambang@student.ac.id', 'username' => 'bambang', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            ['nim' => '2024006', 'nama_mahasiswa' => 'Citra Dewi', 'email' => 'citra@student.ac.id', 'username' => 'citra', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            ['nim' => '2024007', 'nama_mahasiswa' => 'Dimas Saputra', 'email' => 'dimas@student.ac.id', 'username' => 'dimas', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            
            // GOLD x3 (target: 75 poin)
            ['nim' => '2024008', 'nama_mahasiswa' => 'Eka Putri', 'email' => 'eka@student.ac.id', 'username' => 'eka', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            ['nim' => '2024009', 'nama_mahasiswa' => 'Fajar Nugroho', 'email' => 'fajar@student.ac.id', 'username' => 'fajar', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            ['nim' => '2024010', 'nama_mahasiswa' => 'Gita Savitri', 'email' => 'gita@student.ac.id', 'username' => 'gita', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            
            // SILVER x3 (target: 35 poin)
            ['nim' => '2024011', 'nama_mahasiswa' => 'Hadi Kurniawan', 'email' => 'hadi@student.ac.id', 'username' => 'hadi', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            ['nim' => '2024012', 'nama_mahasiswa' => 'Indah Permata', 'email' => 'indah@student.ac.id', 'username' => 'indah', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            ['nim' => '2024013', 'nama_mahasiswa' => 'Joko Susilo', 'email' => 'joko@student.ac.id', 'username' => 'joko', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            
            // BRONZE x2 (target: 10 poin)
            ['nim' => '2024014', 'nama_mahasiswa' => 'Kartika Sari', 'email' => 'kartika@student.ac.id', 'username' => 'kartika', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
            ['nim' => '2024015', 'nama_mahasiswa' => 'Lukman Hakim', 'email' => 'lukman@student.ac.id', 'username' => 'lukman', 'password' => Hash::make('password'), 'status_aktif' => 'aktif'],
        ];

        foreach ($mahasiswa as $m) {
            DB::table('mahasiswa')->insert($m);
        }
    }

    /**
     * Assign mahasiswa ke kelas
     * Sage & Great ambil banyak matkul, Bronze ambil sedikit
     */
    private function seedMahasiswaKelas()
    {
        $this->command->info('🔗 Mengaitkan mahasiswa ke kelas...');
        
        $assignments = [
            // SAGE (Raka) - ambil 6 matkul
            ['id_mahasiswa' => 1, 'id_kelas' => 1],
            ['id_mahasiswa' => 1, 'id_kelas' => 2],
            ['id_mahasiswa' => 1, 'id_kelas' => 3],
            ['id_mahasiswa' => 1, 'id_kelas' => 4],
            ['id_mahasiswa' => 1, 'id_kelas' => 5],
            ['id_mahasiswa' => 1, 'id_kelas' => 6],
            
            // GREAT (Dewi) - ambil 5 matkul
            ['id_mahasiswa' => 2, 'id_kelas' => 1],
            ['id_mahasiswa' => 2, 'id_kelas' => 2],
            ['id_mahasiswa' => 2, 'id_kelas' => 3],
            ['id_mahasiswa' => 2, 'id_kelas' => 4],
            ['id_mahasiswa' => 2, 'id_kelas' => 5],
            
            // MASTER x2 - ambil 4 matkul
            ['id_mahasiswa' => 3, 'id_kelas' => 1],
            ['id_mahasiswa' => 3, 'id_kelas' => 2],
            ['id_mahasiswa' => 3, 'id_kelas' => 3],
            ['id_mahasiswa' => 3, 'id_kelas' => 4],
            ['id_mahasiswa' => 4, 'id_kelas' => 1],
            ['id_mahasiswa' => 4, 'id_kelas' => 2],
            ['id_mahasiswa' => 4, 'id_kelas' => 5],
            ['id_mahasiswa' => 4, 'id_kelas' => 6],
            
            // PLATINUM x3 - ambil 3 matkul
            ['id_mahasiswa' => 5, 'id_kelas' => 1],
            ['id_mahasiswa' => 5, 'id_kelas' => 2],
            ['id_mahasiswa' => 5, 'id_kelas' => 3],
            ['id_mahasiswa' => 6, 'id_kelas' => 1],
            ['id_mahasiswa' => 6, 'id_kelas' => 4],
            ['id_mahasiswa' => 6, 'id_kelas' => 5],
            ['id_mahasiswa' => 7, 'id_kelas' => 2],
            ['id_mahasiswa' => 7, 'id_kelas' => 3],
            ['id_mahasiswa' => 7, 'id_kelas' => 6],
            
            // GOLD x3 - ambil 2 matkul
            ['id_mahasiswa' => 8, 'id_kelas' => 1],
            ['id_mahasiswa' => 8, 'id_kelas' => 2],
            ['id_mahasiswa' => 9, 'id_kelas' => 1],
            ['id_mahasiswa' => 9, 'id_kelas' => 3],
            ['id_mahasiswa' => 10, 'id_kelas' => 2],
            ['id_mahasiswa' => 10, 'id_kelas' => 4],
            
            // SILVER x3 - ambil 2 matkul
            ['id_mahasiswa' => 11, 'id_kelas' => 1],
            ['id_mahasiswa' => 11, 'id_kelas' => 2],
            ['id_mahasiswa' => 12, 'id_kelas' => 3],
            ['id_mahasiswa' => 12, 'id_kelas' => 4],
            ['id_mahasiswa' => 13, 'id_kelas' => 1],
            ['id_mahasiswa' => 13, 'id_kelas' => 5],
            
            // BRONZE x2 - ambil 1 matkul
            ['id_mahasiswa' => 14, 'id_kelas' => 1],
            ['id_mahasiswa' => 15, 'id_kelas' => 2],
        ];

        foreach ($assignments as $a) {
            DB::table('mahasiswa_kelas')->insert($a);
        }
    }

    /**
     * Jadwal untuk setiap kelas
     */
    private function seedJadwal()
    {
        $this->command->info('📅 Membuat jadwal...');
        
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $jamMulai = ['08:00:00', '10:00:00', '13:00:00', '15:00:00'];
        
        for ($i = 1; $i <= 8; $i++) {
            DB::table('jadwal')->insert([
                'id_kelas' => $i,
                'hari' => $hari[$i % 5],
                'jam_mulai' => $jamMulai[$i % 4],
                'jam_selesai' => date('H:i:s', strtotime($jamMulai[$i % 4]) + 7200),
                'ruangan' => 'R.' . sprintf('%03d', 100 + $i),
            ]);
        }
    }

    /**
     * 7 Tugas per kelas (total 56 tugas)
     */
    private function seedTugas()
    {
        $this->command->info('📝 Membuat tugas...');
        
        $judulTugas = [
            'Tugas 1 - Pengantar',
            'Tugas 2 - Dasar-Dasar',
            'Tugas 3 - Implementasi',
            'Tugas 4 - Studi Kasus',
            'Tugas 5 - Proyek Mini',
            'Tugas 6 - Analisis',
            'Tugas 7 - Proyek Akhir',
        ];

        for ($kelasId = 1; $kelasId <= 8; $kelasId++) {
            foreach ($judulTugas as $index => $judul) {
                DB::table('tugas')->insert([
                    'judul_tugas' => $judul . ' - Kelas ' . chr(64 + $kelasId),
                    'deskripsi' => "Deskripsi untuk tugas {$judul} pada kelas " . chr(64 + $kelasId),
                    'deadline' => Carbon::now()->addDays(7 + ($index * 3)),
                    'id_kelas' => $kelasId,
                ]);
            }
        }
    }

    /**
     * Sesi absen untuk setiap kelas (10 sesi per kelas, tanggal mundur)
     */
    private function seedSesiAbsen()
    {
        $this->command->info('📆 Membuat sesi absen...');
        
        for ($kelasId = 1; $kelasId <= 8; $kelasId++) {
            for ($i = 0; $i < 15; $i++) {
                DB::table('sesi_absen')->insert([
                    'id_kelas' => $kelasId,
                    'tanggal' => Carbon::now()->subDays($i)->format('Y-m-d'),
                    'aktif' => $i < 10 ? 1 : 0, // 10 sesi aktif, 5 tidak
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Upload tugas berdasarkan rank target
     */
    private function seedUploadTugas()
    {
        $this->command->info('📤 Membuat upload tugas...');
        
        // Jumlah upload per mahasiswa (sesuai target rank)
        $uploadCount = [
            1 => 50,  // SAGE (Raka) - 50 upload × 10 = 500 poin
            2 => 30,  // GREAT (Dewi) - 30 upload × 10 = 300 poin
            3 => 18,  // MASTER (Andi) - 18 upload × 10 = 180 poin
            4 => 17,  // MASTER (Sari) - 17 upload × 10 = 170 poin
            5 => 10,  // PLATINUM (Bambang) - 10 upload × 10 = 100 poin
            6 => 9,   // PLATINUM (Citra)
            7 => 8,   // PLATINUM (Dimas)
            8 => 5,   // GOLD (Eka)
            9 => 5,   // GOLD (Fajar)
            10 => 4,  // GOLD (Gita)
            11 => 2,  // SILVER (Hadi)
            12 => 2,  // SILVER (Indah)
            13 => 2,  // SILVER (Joko)
            14 => 1,  // BRONZE (Kartika)
            15 => 0,  // BRONZE (Lukman) - tidak upload
        ];

        $uploadId = 1;
        foreach ($uploadCount as $mhsId => $count) {
            // Ambil tugas dari kelas yang diambil mahasiswa
            $kelasIds = DB::table('mahasiswa_kelas')
                ->where('id_mahasiswa', $mhsId)
                ->pluck('id_kelas')
                ->toArray();

            if (empty($kelasIds)) continue;

            $tugasIds = DB::table('tugas')
                ->whereIn('id_kelas', $kelasIds)
                ->pluck('id_tugas')
                ->toArray();

            // Ambil sejumlah tugas sesuai count
            $tugasDiupload = array_slice($tugasIds, 0, min($count, count($tugasIds)));

            foreach ($tugasDiupload as $tugasId) {
                DB::table('upload_tugas')->insert([
                    'id_tugas' => $tugasId,
                    'id_mahasiswa' => $mhsId,
                    'nama_file' => 'https://drive.google.com/file/d/' . uniqid() . '/view',
                    'tanggal_upload' => Carbon::now()->subDays(rand(1, 30)),
                    'status' => 'terkumpul',
                ]);
                $uploadId++;
            }
        }
    }

    /**
     * Penilaian untuk upload (bonus poin)
     */
    private function seedPenilaian()
    {
        $this->command->info('⭐ Membuat penilaian...');
        
        // Nilai rata-rata per mahasiswa (untuk bonus poin)
        $nilaiRataRata = [
            1 => 85,  // SAGE - bonus: 50 × 8 = 400 poin
            2 => 75,  // GREAT - bonus: 30 × 7 = 210 poin
            3 => 70,  // MASTER - bonus: 18 × 7 = 126 poin
            4 => 70,  // MASTER - bonus: 17 × 7 = 119 poin
            5 => 65,  // PLATINUM - bonus: 10 × 6 = 60 poin
            6 => 65,  // PLATINUM
            7 => 65,  // PLATINUM
            8 => 60,  // GOLD - bonus: 5 × 6 = 30 poin
            9 => 60,  // GOLD
            10 => 60, // GOLD
            11 => 50, // SILVER - bonus: 2 × 5 = 10 poin
            12 => 50, // SILVER
            13 => 50, // SILVER
            14 => 40, // BRONZE - bonus: 1 × 4 = 4 poin
        ];

        $uploads = DB::table('upload_tugas')->get();
        
        foreach ($uploads as $upload) {
            $nilaiDasar = $nilaiRataRata[$upload->id_mahasiswa] ?? 60;
            // Variasi nilai ±5
            $nilai = $nilaiDasar + rand(-5, 5);
            $nilai = max(0, min(100, $nilai));

            DB::table('penilaian')->insert([
                'id_upload' => $upload->id_upload,
                'nilai' => $nilai,
                'feedback' => 'Feedback untuk tugas ini. Pertahankan semangat belajar!',
                'tanggal_nilai' => Carbon::now()->subDays(rand(1, 20)),
            ]);
        }
    }

    /**
     * Absensi (Hadir) per mahasiswa
     */
    private function seedAbsensi()
    {
        $this->command->info('✅ Membuat data absensi...');
        
        // Jumlah hadir per mahasiswa (untuk poin absensi)
        $hadirCount = [
            1 => 80,  // SAGE - 80 × 5 = 400 poin
            2 => 50,  // GREAT - 50 × 5 = 250 poin
            3 => 25,  // MASTER - 25 × 5 = 125 poin
            4 => 22,  // MASTER - 22 × 5 = 110 poin
            5 => 15,  // PLATINUM - 15 × 5 = 75 poin
            6 => 14,  // PLATINUM
            7 => 12,  // PLATINUM
            8 => 8,   // GOLD - 8 × 5 = 40 poin
            9 => 7,   // GOLD
            10 => 6,  // GOLD
            11 => 3,  // SILVER - 3 × 5 = 15 poin
            12 => 3,  // SILVER
            13 => 3,  // SILVER
            14 => 1,  // BRONZE - 1 × 5 = 5 poin
            15 => 0,  // BRONZE - 0 poin
        ];

        foreach ($hadirCount as $mhsId => $count) {
            // Ambil sesi aktif dari kelas yang diambil mahasiswa
            $kelasIds = DB::table('mahasiswa_kelas')
                ->where('id_mahasiswa', $mhsId)
                ->pluck('id_kelas')
                ->toArray();

            if (empty($kelasIds)) continue;

            $sesiAktif = DB::table('sesi_absen')
                ->whereIn('id_kelas', $kelasIds)
                ->where('aktif', 1)
                ->get();

            // Ambil sejumlah sesi sesuai count
            $sesiDipilih = $sesiAktif->take(min($count, $sesiAktif->count()));

            foreach ($sesiDipilih as $sesi) {
                DB::table('absensi')->insert([
                    'id_mahasiswa' => $mhsId,
                    'id_kelas' => $sesi->id_kelas,
                    'tanggal' => $sesi->tanggal,
                    'status' => 'Hadir',
                ]);
            }
        }
    }

    /**
     * Tampilkan ringkasan hasil seeder
     */
    private function showSummary()
    {
        $this->command->info('');
        $this->command->info('📊 RINGKASAN DATA:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('Dosen: ' . DB::table('dosen')->count());
        $this->command->info('Mata Kuliah: ' . DB::table('mata_kuliah')->count());
        $this->command->info('Kelas: ' . DB::table('kelas')->count());
        $this->command->info('Mahasiswa: ' . DB::table('mahasiswa')->count());
        $this->command->info('Tugas: ' . DB::table('tugas')->count());
        $this->command->info('Upload Tugas: ' . DB::table('upload_tugas')->count());
        $this->command->info('Penilaian: ' . DB::table('penilaian')->count());
        $this->command->info('Sesi Absen: ' . DB::table('sesi_absen')->count());
        $this->command->info('Absensi: ' . DB::table('absensi')->count());
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('');
        $this->command->info('🔐 AKUN LOGIN:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('Dosen (password: password):');
        $this->command->info('  - ahmad, siti, budidosen, rina, doni, maya');
        $this->command->info('');
        $this->command->info('Mahasiswa (password: password):');
        $this->command->info('  - raka (SAGE 🧙)');
        $this->command->info('  - dewi (GREAT 🏆)');
        $this->command->info('  - andi, sari (MASTER)');
        $this->command->info('  - bambang, citra, dimas (PLATINUM)');
        $this->command->info('  - eka, fajar, gita (GOLD)');
        $this->command->info('  - hadi, indah, joko (SILVER)');
        $this->command->info('  - kartika, lukman (BRONZE)');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}