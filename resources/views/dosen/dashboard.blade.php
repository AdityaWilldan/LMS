@extends('layouts.dosen')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-tasks"></i> Tugas</h5>
                <p class="card-text display-6">{{ \App\Models\Tugas::whereIn('id_kelas', Auth::guard('dosen')->user()->mataKuliah->flatMap->kelas->pluck('id_kelas'))->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-users"></i> Mahasiswa</h5>
                <p class="card-text display-6">{{ \App\Models\Mahasiswa::count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-calendar-check"></i> Kelas</h5>
                <p class="card-text display-6">{{ Auth::guard('dosen')->user()->mataKuliah->flatMap->kelas->count() }}</p>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <i class="fas fa-info-circle"></i> Informasi
    </div>
    <div class="card-body">
        <p>Selamat datang di LMS. Anda dapat mengelola tugas, nilai, dan absensi mahasiswa.</p>
    </div>
</div>
@endsection