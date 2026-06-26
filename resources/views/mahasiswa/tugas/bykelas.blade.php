@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="clipboard-list"></i></span>
        Tugas - {{ $kelas->mataKuliah->nama_matkul }}
    </h1>
    <p>{{ $kelas->mataKuliah->kode_matkul }} • {{ $kelas->nama_kelas }} • Semester {{ $kelas->semester }}</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Judul Tugas</th>
                    <th>Deadline</th>
                    <th>Status</th>  <!-- tambahan -->
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tugas as $t)
                @php
                    // Cek apakah ada upload untuk tugas ini
                    $upload = $t->uploadTugas->first(); // ambil upload pertama (seharusnya hanya satu per mahasiswa)
                    $deadline = \Carbon\Carbon::parse($t->deadline);
                    $now = \Carbon\Carbon::now();
                    $status = 'belum';
                    $statusClass = 'badge-warning';
                    if ($upload) {
                        $status = 'selesai';
                        $statusClass = 'badge-success';
                    } elseif ($deadline->isPast()) {
                        $status = 'telat';
                        $statusClass = 'badge-danger';
                    }
                @endphp
                <tr>
                    <td><span class="badge">{{ $loop->iteration }}</span></td>
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
                        <span class="badge {{ $statusClass }}">
                            @if($status == 'selesai')
                                <i data-lucide="check-circle"></i> Selesai
                            @elseif($status == 'telat')
                                <i data-lucide="alert-circle"></i> Telat
                            @else
                                <i data-lucide="clock"></i> Belum
                            @endif
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('mahasiswa.tugas.show', $t->id_tugas) }}" class="btn btn-sm btn-primary">
                            <i data-lucide="eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
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
    <div style="padding:16px; border-top:1px solid var(--border-color); text-align:center;">
        <a href="{{ route('mahasiswa.tugas.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection