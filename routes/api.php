<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Dosen\AbsensiController as DosenAbsensi;
use App\Http\Controllers\Api\Dosen\MahasiswaController as DosenMahasiswa;
use App\Http\Controllers\Api\Dosen\NilaiController as DosenNilai;
use App\Http\Controllers\Api\Dosen\TugasController as DosenTugas;
use App\Http\Controllers\Api\Mahasiswa\AbsensiController as MhsAbsensi;
use App\Http\Controllers\Api\Mahasiswa\JadwalController as MhsJadwal;
use App\Http\Controllers\Api\Mahasiswa\MataKuliahController as MhsMatkul;
use App\Http\Controllers\Api\Mahasiswa\NilaiController as MhsNilai;
use App\Http\Controllers\Api\Mahasiswa\NotifikasiController as MhsNotif;
use App\Http\Controllers\Api\Mahasiswa\ProfilController as MhsProfil;
use App\Http\Controllers\Api\Mahasiswa\TugasController as MhsTugas;
use App\Http\Controllers\Api\Mahasiswa\GamifikasiController as MhsGamifikasi; // ✅ BARU

// ===== LOGIN API (TANPA CSRF PROTECTION) =====
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Coba login sebagai dosen
    if (Auth::guard('dosen')->attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json([
            'message' => 'Login berhasil sebagai Dosen',
            'user' => Auth::guard('dosen')->user(),
            'guard' => 'dosen',
            'redirect' => '/dosen/dashboard'
        ]);
    }

    // Coba login sebagai mahasiswa
    if (Auth::guard('mahasiswa')->attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json([
            'message' => 'Login berhasil sebagai Mahasiswa',
            'user' => Auth::guard('mahasiswa')->user(),
            'guard' => 'mahasiswa',
            'redirect' => '/mahasiswa/dashboard'
        ]);
    }

    return response()->json([
        'message' => 'Username atau password salah',
    ], 401);
});

// ===== LOGOUT API =====
Route::post('/logout', function (Request $request) {
    Auth::guard('dosen')->logout();
    Auth::guard('mahasiswa')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return response()->json(['message' => 'Logout berhasil']);
});

// ===== ROUTE DOSEN =====
Route::middleware('auth:dosen')->prefix('dosen')->group(function () {
    // ===== TUGAS =====
    Route::apiResource('tugas', DosenTugas::class);
    
    // ===== ABSENSI =====
    // Route statis (tanpa parameter) harus didaftarkan SEBELUM route dengan parameter
    Route::get('absensi', [DosenAbsensi::class, 'index']);
    Route::post('absensi/toggle-mode', [DosenAbsensi::class, 'toggleMode']);
    
    // Route sesi
    Route::get('absensi/sesi', [DosenAbsensi::class, 'sesiIndex']);
    Route::get('absensi/sesi/create', [DosenAbsensi::class, 'sesiCreate']);
    Route::post('absensi/sesi', [DosenAbsensi::class, 'sesiStore']);
    Route::post('absensi/sesi/toggle/{id_sesi}', [DosenAbsensi::class, 'sesiToggle']);
    
    // Route rekap (dengan parameter opsional)
    Route::get('absensi/rekap/{id_kelas}/{tanggal?}', [DosenAbsensi::class, 'rekap']);
    
    // Route create & store absensi (dengan parameter)
    Route::get('absensi/create/{id_kelas}', [DosenAbsensi::class, 'create']);
    Route::post('absensi/store/{id_kelas}', [DosenAbsensi::class, 'store']);
    
    // ===== MAHASISWA =====
    Route::get('mahasiswa', [DosenMahasiswa::class, 'index']);
    Route::get('mahasiswa/{id_kelas}', [DosenMahasiswa::class, 'show']);
    
    // ===== NILAI =====
    Route::get('nilai', [DosenNilai::class, 'index']);
    Route::get('nilai/create/{id_upload}', [DosenNilai::class, 'create']);
    Route::post('nilai/store/{id_upload}', [DosenNilai::class, 'store']);
});

// ===== ROUTE MAHASISWA =====
Route::middleware('auth:mahasiswa')->prefix('mahasiswa')->group(function () {
    // ===== ABSENSI =====
    Route::get('absensi', [MhsAbsensi::class, 'index']);
    Route::post('absensi/absen/{id_kelas}', [MhsAbsensi::class, 'absen']);
    
    // ===== JADWAL =====
    Route::get('jadwal', [MhsJadwal::class, 'index']);
    
    // ===== MATA KULIAH =====
    Route::get('matakuliah', [MhsMatkul::class, 'index']);
    Route::get('matakuliah/{id_kelas}', [MhsMatkul::class, 'show']);
    
    // ===== NILAI =====
    Route::get('nilai', [MhsNilai::class, 'index']);
    Route::get('nilai/akhir', [MhsNilai::class, 'nilaiAkhir']);
    
    // ===== NOTIFIKASI =====
    Route::get('notifikasi', [MhsNotif::class, 'index']);
    
    // ===== PROFIL =====
    Route::get('profil', [MhsProfil::class, 'show']);
    Route::put('profil', [MhsProfil::class, 'update']);
    Route::post('profil/change-password', [MhsProfil::class, 'changePassword']);
    
    // ===== GAMIFIKASI (BARU) =====
    Route::get('gamifikasi/profil', [MhsGamifikasi::class, 'profil']);
    Route::get('gamifikasi/leaderboard', [MhsGamifikasi::class, 'leaderboard']);
    
    // ===== TUGAS =====
    // Route statis harus didaftarkan SEBELUM route dengan parameter
    Route::get('tugas', [MhsTugas::class, 'index']);
    Route::get('tugas/belum-dikerjakan', [MhsTugas::class, 'tugasBelumDikerjakan']);
    Route::get('tugas/kelas/{id_kelas}', [MhsTugas::class, 'tugasByKelas']);
    Route::get('tugas/{id_tugas}', [MhsTugas::class, 'show']);
    Route::post('tugas/upload/{id_tugas}', [MhsTugas::class, 'upload']);
    Route::delete('tugas/upload/{id_tugas}', [MhsTugas::class, 'deleteUpload']);
});