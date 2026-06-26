@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="book"></i></span>
        {{ $kelas->mataKuliah->nama_matkul }}
    </h1>
    <p>{{ $kelas->mataKuliah->kode_matkul }} • {{ $kelas->nama_kelas }} • Semester {{ $kelas->semester }}</p>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i data-lucide="info"></i>
        <span>Informasi Mata Kuliah</span>
    </div>
    <div class="card-body">
        <div class="grid grid-2" style="gap:20px;">
            <div>
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Kode</div>
                <div style="font-size:15px;font-weight:500;">{{ $kelas->mataKuliah->kode_matkul }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">SKS</div>
                <div style="font-size:15px;font-weight:500;">{{ $kelas->mataKuliah->sks }} SKS</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Dosen Pengampu</div>
                <div style="font-size:15px;font-weight:500;">
                    <div class="d-flex align-items-center gap-2">
                        <i data-lucide="user" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                        {{ $kelas->mataKuliah->dosen->nama_dosen ?? '-' }}
                    </div>
                </div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Tahun Ajaran</div>
                <div style="font-size:15px;font-weight:500;">{{ $kelas->tahun_ajaran }}</div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="card mb-4">
    <div class="card-header">
        <i data-lucide="clipboard-list"></i>
        <span>Daftar Tugas</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Judul Tugas</th>
                    <th>Deadline</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas->tugas as $t)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="file-text" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                            <span class="font-medium">{{ $t->judul_tugas }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge">
                            <i data-lucide="clock"></i>
                            {{ $t->deadline->format('d/m/Y H:i') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('mahasiswa.tugas.show', $t->id_tugas) }}" class="btn btn-sm btn-primary">
                            <i data-lucide="eye"></i> Lihat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i data-lucide="inbox"></i>
                            </div>
                            <h3>Belum ada tugas</h3>
                            <p>Tidak ada tugas untuk mata kuliah ini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div> --}}

<div class="card">
    <div class="card-header">
        <i data-lucide="calendar"></i>
        <span>Jadwal Kuliah</span>
    </div>
    <div class="card-body">
        @if($kelas->jadwal->count())
            <div class="grid grid-2" style="gap:12px;">
                @foreach($kelas->jadwal as $j)
                <div style="padding:16px;background:var(--bg-secondary);border-radius:8px;border:1px solid var(--border);">
                    <div class="d-flex align-items-center gap-2" style="margin-bottom:8px;">
                        <i data-lucide="calendar-days" style="width:16px;height:16px;color:var(--accent);"></i>
                        <span class="font-semibold">{{ $j->hari }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2" style="margin-bottom:4px;">
                        <i data-lucide="clock" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                        <span style="font-size:13px;color:var(--foreground-secondary);">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i data-lucide="map-pin" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                        <span style="font-size:13px;color:var(--foreground-secondary);">Ruang {{ $j->ruangan }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i data-lucide="calendar-x"></i>
                </div>
                <h3>Belum ada jadwal</h3>
                <p>Jadwal untuk mata kuliah ini belum tersedia</p>
            </div>
        @endif
    </div>
</div>
@endsection