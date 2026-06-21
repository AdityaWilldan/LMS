@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="users"></i></span>
        Mahasiswa
    </h1>
    <p>Pilih kelas untuk melihat daftar mahasiswa</p>
</div>

<div class="grid grid-3">
    @forelse($kelas as $k)
    <div class="class-card" style="--card-accent: var(--gradient-success);">
        <div class="class-card-header">
            <div class="class-card-icon" style="background: var(--gradient-success);">
                <i data-lucide="graduation-cap"></i>
            </div>
            <div>
                <div class="class-card-title">{{ $k->nama_kelas }}</div>
                <div class="class-card-subtitle">{{ $k->mataKuliah->nama_matkul ?? '—' }}</div>
            </div>
        </div>
        <div class="class-card-body">
            <a href="{{ route('dosen.mahasiswa.show', $k->id_kelas) }}" class="btn btn-primary" style="width:100%;">
                <i data-lucide="arrow-right"></i> Lihat Mahasiswa
            </a>
        </div>
    </div>
    @empty
    <div class="empty-state" style="grid-column:1/-1;">
        <div class="empty-state-icon">
            <i data-lucide="users"></i>
        </div>
        <h3>Belum ada kelas</h3>
        <p>Tidak ada kelas yang terdaftar</p>
    </div>
    @endforelse
</div>
@endsection