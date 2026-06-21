@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="clipboard-list"></i></span>
        Tugas
    </h1>
    <p>Daftar tugas dari semua mata kuliah</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Judul Tugas</th>
                    <th>Deadline</th>
                    <th>Kelas</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tugas as $t)
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
                        <span style="display:inline-flex;align-items:center;gap:4px;">
                            <i data-lucide="book-open" style="width:12px;height:12px;color:var(--foreground-tertiary);"></i>
                            {{ $t->kelas->nama_kelas ?? '—' }}
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
                            <p>Tidak ada tugas yang tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection