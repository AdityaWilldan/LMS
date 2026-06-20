@extends('layouts.mahasiswa')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-book"></i> Mata Kuliah</h5>
                <p class="card-text display-6">{{ Auth::guard('mahasiswa')->user()->kelas->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-tasks"></i> Tugas</h5>
                <p class="card-text display-6">{{ \App\Models\Tugas::whereIn('id_kelas', Auth::guard('mahasiswa')->user()->kelas->pluck('id_kelas'))->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-bell"></i> Notifikasi</h5>
                <p class="card-text display-6">{{ Auth::guard('mahasiswa')->user()->notifikasi()->where('status_baca', 'belum')->count() }}</p>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <i class="fas fa-info-circle"></i> Selamat Datang
    </div>
    <div class="card-body">
        <p>Anda login sebagai mahasiswa. Gunakan menu di samping untuk mengakses berbagai fitur.</p>
    </div>
</div>
@endsection