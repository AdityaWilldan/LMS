@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="calendar-check"></i></span>
        Absensi
    </h1>
    <p>Pilih kelas untuk mengisi absensi</p>
</div>

<div class="grid grid-3">
    @forelse($kelas as $k)
    <div class="class-card" style="--card-accent: var(--gradient-info);">
        <div class="class-card-header">
            <div class="class-card-icon" style="background: var(--gradient-info);">
                <i data-lucide="book-open"></i>
            </div>
            <div>
                <div class="class-card-title">KELAS: {{ $k->nama_kelas }}</div>
                <div class="class-card-subtitle">{{ $k->mataKuliah->nama_matkul ?? '—' }}</div>
            </div>
        </div>
        <div class="class-card-body">
            <a href="{{ route('dosen.absensi.sesi.index', $k->id_kelas) }}" class="btn btn-primary" style="width:100%;">
                <i data-lucide="calendar-check"></i> Isi Absensi
            </a>
        </div>
    </div>
        <div class="class-card" style="--card-accent: var(--gradient-info);">
        <div class="class-card-header">
            <div class="class-card-icon" style="background: var(--gradient-info);">
                <i data-lucide="book-open"></i>
            </div>
            <div>
                <div class="class-card-title">KELAS: {{ $k->nama_kelas }}</div>
                <div class="class-card-subtitle">Riwayat izin mahasiswa</div>
            </div>
        </div>
        <div class="class-card-body">
            <a href="{{ route('dosen.absensi.create', $k->id_kelas) }}" class="btn btn-primary" style="width:100%;">
                <i data-lucide="calendar-check"></i> Riwayat Izin
            </a>
        </div>
    </div>
    @empty
    <div class="empty-state" style="grid-column:1/-1;">
        <div class="empty-state-icon">
            <i data-lucide="calendar-x"></i>
        </div>
        <h3>Belum ada kelas</h3>
        <p>Tidak ada kelas yang tersedia untuk absensi</p>
    </div>
    @endforelse
</div>
@endsection