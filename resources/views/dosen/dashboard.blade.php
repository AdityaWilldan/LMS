@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="layout-dashboard"></i></span>
        Dashboard
    </h1>
    <p>Ringkasan aktivitas pembelajaran Anda</p>
</div>

<div class="grid grid-3 mb-6">
    <div class="stat-card accent-blue">
        <div class="stat-card-header">
            <div class="stat-card-icon blue">
                <i data-lucide="clipboard-list"></i>
            </div>
            <div class="stat-card-trend up">
                <i data-lucide="trending-up"></i>
                Active
            </div>
        </div>
        <div class="stat-card-label">Total Tugas</div>
        <div class="stat-card-value">{{ \App\Models\Tugas::whereIn('id_kelas', Auth::guard('dosen')->user()->mataKuliah->flatMap->kelas->pluck('id_kelas'))->count() }}</div>
    </div>

    <div class="stat-card accent-green">
        <div class="stat-card-header">
            <div class="stat-card-icon green">
                <i data-lucide="users"></i>
            </div>
            <div class="stat-card-trend up">
                <i data-lucide="user-plus"></i>
                Growing
            </div>
        </div>
        <div class="stat-card-label">Total Mahasiswa</div>
        <div class="stat-card-value">{{ \App\Models\Mahasiswa::count() }}</div>
    </div>

    <div class="stat-card accent-orange">
        <div class="stat-card-header">
            <div class="stat-card-icon orange">
                <i data-lucide="book-open"></i>
            </div>
            <div class="stat-card-trend up">
                <i data-lucide="activity"></i>
                Stable
            </div>
        </div>
        <div class="stat-card-label">Total Kelas</div>
        <div class="stat-card-value">{{ Auth::guard('dosen')->user()->mataKuliah->flatMap->kelas->count() }}</div>
    </div>
</div>

<div class="grid grid-2 mb-4">
    <div class="card">
        <div class="card-header">
            <i data-lucide="info"></i>
            <span>Selamat Datang</span>
        </div>
        <div class="card-body">
            <p style="color: var(--foreground-secondary); line-height:1.7;">
                <i data-lucide="sparkles" style="width:14px;height:14px;vertical-align:-2px;color:var(--warning);"></i>
                Selamat datang di <strong>LMS Dosen</strong>. Anda dapat mengelola tugas, nilai, dan absensi mahasiswa melalui menu navigasi di sebelah kiri.
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
                <a href="{{ route('dosen.tugas.create') }}" class="btn btn-success">
                    <i data-lucide="plus"></i> Tugas Baru
                </a>
                <a href="{{ route('dosen.absensi.index') }}" class="btn">
                    <i data-lucide="calendar-check"></i> Absensi
                </a>
                <a href="{{ route('dosen.nilai.index') }}" class="btn">
                    <i data-lucide="star"></i> Nilai
                </a>
            </div>
        </div>
    </div>
</div>
@endsection