@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="clipboard-list"></i></span>
        Tugas
    </h1>
    <p>Daftar tugas dari semua mata kuliah</p>
</div>

<div class="grid grid-3">
    @forelse($kelas as $k)
    <div class="class-card" style="--card-accent: var(--gradient-info);">
        <div class="class-card-header">
            <div class="class-card-icon" style="background: var(--gradient-info);">
                <i data-lucide="book"></i>
            </div>
            <div>
                <div class="class-card-title">{{ $k->mataKuliah->nama_matkul }}</div>
                <div class="class-card-subtitle">{{ $k->mataKuliah->kode_matkul }} • {{ $k->mataKuliah->sks }} SKS</div>
            </div>
        </div>
        <div class="class-card-body">
            <div style="margin-bottom:12px;">
                {{-- <div class="d-flex align-items-center gap-2" style="margin-bottom:8px;">
                    <i data-lucide="users" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                    <span style="font-size:13px;color:var(--foreground-secondary);">{{ $k->nama_kelas }}</span>
                </div> --}}
                {{-- <div class="d-flex align-items-center gap-2">
                    <i data-lucide="calendar" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                    <span style="font-size:13px;color:var(--foreground-secondary);">Semester {{ $k->semester }}</span>
                </div> --}}
                <div class="d-flex align-items-center gap-2" style="margin-top:8px;">
                    <i data-lucide="clipboard-list" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                    <span style="font-size:13px;color:var(--foreground-secondary);">{{ $k->tugas_count }} Tugas</span>
                </div>
            </div>
            <a href="{{ route('mahasiswa.tugas.bykelas', $k->id_kelas) }}" class="btn btn-primary" style="width:100%;">
                <i data-lucide="arrow-right"></i> Detail
            </a>
        </div>
    </div>
    @empty
    <div class="empty-state" style="grid-column:1/-1;">
        <div class="empty-state-icon">
            <i data-lucide="inbox"></i>
        </div>
        <h3>Belum ada mata kuliah</h3>
        <p>Anda belum mengambil mata kuliah semester ini</p>
    </div>
    @endforelse
</div>
@endsection