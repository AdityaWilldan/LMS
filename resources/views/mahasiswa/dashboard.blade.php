@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="layout-dashboard"></i></span>
        Dashboard
    </h1>
    <p>Ringkasan aktivitas akademik Anda</p>
</div>

<div class="grid grid-3 mb-6">
    <div class="stat-card accent-blue">
        <div class="stat-card-header">
            <div class="stat-card-icon blue">
                <i data-lucide="book-open"></i>
            </div>
            <div class="stat-card-trend up">
                <i data-lucide="trending-up"></i>
                Active
            </div>
        </div>
        <div class="stat-card-label">Mata Kuliah</div>
        <div class="stat-card-value">{{ Auth::guard('mahasiswa')->user()->kelas->count() }}</div>
    </div>

    <div class="stat-card accent-green">
        <div class="stat-card-header">
            <div class="stat-card-icon green">
                <i data-lucide="clipboard-list"></i>
            </div>
            <div class="stat-card-trend up">
                <i data-lucide="activity"></i>
                Pending
            </div>
        </div>
        <div class="stat-card-label">Total Tugas</div>
        <div class="stat-card-value">{{ \App\Models\Tugas::whereIn('id_kelas', Auth::guard('mahasiswa')->user()->kelas->pluck('id_kelas'))->count() }}</div>
    </div>

    <div class="stat-card accent-pink">
        <div class="stat-card-header">
            <div class="stat-card-icon pink">
                <i data-lucide="bell"></i>
            </div>
            @if(Auth::guard('mahasiswa')->user()->notifikasi()->where('status_baca', 'belum')->count() > 0)
                <div class="stat-card-trend up">
                    <i data-lucide="alert-circle"></i>
                    Baru
                </div>
            @endif
        </div>
        <div class="stat-card-label">Notifikasi</div>
        <div class="stat-card-value">{{ Auth::guard('mahasiswa')->user()->notifikasi()->where('status_baca', 'belum')->count() }}</div>
    </div>
</div>

<div class="grid grid-2 mb-4">
    <div class="card">
        <div class="card-header">
            <i data-lucide="sparkles"></i>
            <span>Selamat Datang</span>
        </div>
        <div class="card-body">
            <p style="color: var(--foreground-secondary); line-height:1.7;">
                Halo, <strong>{{ Auth::guard('mahasiswa')->user()->nama_mahasiswa }}</strong>! Anda login sebagai mahasiswa. Gunakan menu di samping untuk mengakses berbagai fitur akademik.
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i data-lucide="zap"></i>
            <span>Aksi Cepat</span>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2" style="flex-wrap:wrap;">
                <a href="{{ route('mahasiswa.tugas.index') }}" class="btn btn-success">
                    <i data-lucide="clipboard-list"></i> Tugas
                </a>
                <a href="{{ route('mahasiswa.nilai.index') }}" class="btn">
                    <i data-lucide="star"></i> Nilai
                </a>
                <a href="{{ route('mahasiswa.jadwal.index') }}" class="btn">
                    <i data-lucide="calendar"></i> Jadwal
                </a>
            </div>
        </div>
    </div>
</div>
@endsection