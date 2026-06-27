<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// ===== API untuk Mahasiswa (Notifikasi Tugas) =====
Route::prefix('api')->middleware('auth:mahasiswa')->group(function () {
    Route::get('/tugas-belum-dikerjakan', [App\Http\Controllers\Mahasiswa\ApiMahasiswaController::class, 'tugasBelumDikerjakan']);
});

// ===== Download file materi =====
Route::get('/download/tugas/{id}', [App\Http\Controllers\DownloadController::class, 'tugas'])
    ->name('download.tugas')
    ->middleware('auth:dosen,mahasiswa');

// ===== Group Dosen =====
Route::prefix('dosen')->name('dosen.')->middleware('auth:dosen')->group(function () {
    Route::get('/dashboard', function () {
        return view('dosen.dashboard');
    })->name('dashboard');

    Route::resource('tugas', App\Http\Controllers\Dosen\TugasDosenController::class)->except(['show']);

    Route::get('nilai', [App\Http\Controllers\Dosen\NilaiDosenController::class, 'index'])->name('nilai.index');

    Route::get('mahasiswa', [App\Http\Controllers\Dosen\MahasiswaDosenController::class, 'index'])->name('mahasiswa.index');
    Route::get('mahasiswa/{id_kelas}', [App\Http\Controllers\Dosen\MahasiswaDosenController::class, 'show'])->name('mahasiswa.show');

    Route::prefix('absensi')->name('absensi.')->group(function () {
        // Indeks absensi
        Route::get('/', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'index'])->name('index');

        Route::get('sesi', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'sesiIndex'])->name('sesi.index');
        Route::get('sesi/create', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'sesiCreate'])->name('sesi.create');
        Route::post('sesi', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'sesiStore'])->name('sesi.store');
        
        Route::post('mode/toggle', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'toggleMode'])->name('mode.toggle');

        Route::get('rekap/{id_kelas}/{tanggal?}', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'rekap'])->name('rekap');
        Route::get('create/{id_kelas}', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'create'])->name('create');
        Route::post('store/{id_kelas}', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'store'])->name('store');
        
        // Toggle sesi - dengan parameter
        Route::post('sesi/{id_sesi}/toggle', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'sesiToggle'])->name('sesi.toggle');
    });
});

// ===== Group Mahasiswa =====
Route::prefix('mahasiswa')->name('mahasiswa.')->middleware('auth:mahasiswa')->group(function () {
    Route::get('/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('dashboard');

    Route::get('profil', [App\Http\Controllers\Mahasiswa\ProfilMahasiswaController::class, 'show'])->name('profil');
    Route::get('profil/edit', [App\Http\Controllers\Mahasiswa\ProfilMahasiswaController::class, 'edit'])->name('profil.edit');
    Route::put('profil/update', [App\Http\Controllers\Mahasiswa\ProfilMahasiswaController::class, 'update'])->name('profil.update');
    Route::get('profil/change-password', [App\Http\Controllers\Mahasiswa\ProfilMahasiswaController::class, 'changePasswordForm'])->name('profil.change-password');
    Route::post('profil/change-password', [App\Http\Controllers\Mahasiswa\ProfilMahasiswaController::class, 'changePassword'])->name('profil.change-password.post');

    Route::get('matakuliah', [App\Http\Controllers\Mahasiswa\MataKuliahMahasiswaController::class, 'index'])->name('matakuliah.index');
    Route::get('matakuliah/{id_kelas}', [App\Http\Controllers\Mahasiswa\MataKuliahMahasiswaController::class, 'show'])->name('matakuliah.show');

    // ===== ROUTE TUGAS =====
    Route::get('tugas', [App\Http\Controllers\Mahasiswa\TugasMahasiswaController::class, 'index'])->name('tugas.index');
    Route::get('tugas/kelas/{id_kelas}', [App\Http\Controllers\Mahasiswa\TugasMahasiswaController::class, 'tugasByKelas'])->name('tugas.bykelas');
    Route::get('tugas/{id_tugas}', [App\Http\Controllers\Mahasiswa\TugasMahasiswaController::class, 'show'])->name('tugas.show');
    Route::post('tugas/{id_tugas}/upload', [App\Http\Controllers\Mahasiswa\TugasMahasiswaController::class, 'upload'])->name('tugas.upload');
    Route::delete('tugas/{id_tugas}/delete-upload', [App\Http\Controllers\Mahasiswa\TugasMahasiswaController::class, 'deleteUpload'])->name('tugas.delete-upload');

    Route::get('nilai', [App\Http\Controllers\Mahasiswa\NilaiMahasiswaController::class, 'index'])->name('nilai.index');
    Route::get('nilai-akhir', [App\Http\Controllers\Mahasiswa\NilaiMahasiswaController::class, 'nilaiAkhir'])->name('nilai.akhir');

    Route::get('jadwal', [App\Http\Controllers\Mahasiswa\JadwalMahasiswaController::class, 'index'])->name('jadwal.index');

    // ===== ROUTE ABSENSI MAHASISWA =====
    Route::get('absensi', [App\Http\Controllers\Mahasiswa\AbsensiMahasiswaController::class, 'index'])->name('absensi.index');
    Route::post('absensi/absen/{id_kelas}', [App\Http\Controllers\Mahasiswa\AbsensiMahasiswaController::class, 'absen'])->name('absensi.absen');

    // ===== ROUTE GAMIFIKASI (BARU) =====
    Route::get('gamifikasi', function () {
        return view('mahasiswa.gamifikasi.index');
    })->name('gamifikasi.index');
});