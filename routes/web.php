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

// Group Dosen
Route::prefix('dosen')->name('dosen.')->middleware('auth:dosen')->group(function () {
    Route::get('/dashboard', function () {
        return view('dosen.dashboard');
    })->name('dashboard');

    Route::resource('tugas', App\Http\Controllers\Dosen\TugasDosenController::class)->except(['show']);

    Route::get('nilai', [App\Http\Controllers\Dosen\NilaiDosenController::class, 'index'])->name('nilai.index');
    Route::get('nilai/{id_upload}/create', [App\Http\Controllers\Dosen\NilaiDosenController::class, 'create'])->name('nilai.create');
    Route::post('nilai/{id_upload}/store', [App\Http\Controllers\Dosen\NilaiDosenController::class, 'store'])->name('nilai.store');

    Route::get('mahasiswa', [App\Http\Controllers\Dosen\MahasiswaDosenController::class, 'index'])->name('mahasiswa.index');
    Route::get('mahasiswa/{id_kelas}', [App\Http\Controllers\Dosen\MahasiswaDosenController::class, 'show'])->name('mahasiswa.show');

    Route::get('absensi', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'index'])->name('absensi.index');
    Route::get('absensi/{id_kelas}/create', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'create'])->name('absensi.create');
    Route::post('absensi/{id_kelas}/store', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'store'])->name('absensi.store');
});

// Group Mahasiswa
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

    Route::get('tugas', [App\Http\Controllers\Mahasiswa\TugasMahasiswaController::class, 'index'])->name('tugas.index');
    Route::get('tugas/{id_tugas}', [App\Http\Controllers\Mahasiswa\TugasMahasiswaController::class, 'show'])->name('tugas.show');
    Route::post('tugas/{id_tugas}/upload', [App\Http\Controllers\Mahasiswa\TugasMahasiswaController::class, 'upload'])->name('tugas.upload');
    Route::delete('tugas/{id_tugas}/delete-upload', [App\Http\Controllers\Mahasiswa\TugasMahasiswaController::class, 'deleteUpload'])->name('tugas.delete-upload');

    Route::get('nilai', [App\Http\Controllers\Mahasiswa\NilaiMahasiswaController::class, 'index'])->name('nilai.index');
    Route::get('nilai-akhir', [App\Http\Controllers\Mahasiswa\NilaiMahasiswaController::class, 'nilaiAkhir'])->name('nilai.akhir');

    Route::get('jadwal', [App\Http\Controllers\Mahasiswa\JadwalMahasiswaController::class, 'index'])->name('jadwal.index');

    Route::get('absensi', [App\Http\Controllers\Mahasiswa\AbsensiMahasiswaController::class, 'index'])->name('absensi.index');

    Route::get('notifikasi', [App\Http\Controllers\Mahasiswa\NotifikasiMahasiswaController::class, 'index'])->name('notifikasi.index');
});

// ===== PERBAIKAN DI SINI =====
// Tambahkan guard yang diizinkan agar user dosen atau mahasiswa bisa akses
Route::get('/download/tugas/{id}', [App\Http\Controllers\DownloadController::class, 'tugas'])
    ->name('download.tugas')
    ->middleware('auth:dosen,mahasiswa'); // <-- Perbaikan