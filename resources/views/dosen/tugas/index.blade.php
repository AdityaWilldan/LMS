@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>
                <span class="icon-wrapper"><i data-lucide="clipboard-list"></i></span>
                Tugas
            </h1>
            <p>Kelola tugas untuk setiap kelas</p>
        </div>
        <a href="{{ route('dosen.tugas.create') }}" class="btn btn-primary">
            <i data-lucide="plus"></i> Tambah Tugas
        </a>
    </div>
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
                    <th>Materi</th>
                    <th style="width:150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tugas as $t)
                <tr>
                    <td><span class="badge">{{ $loop->iteration }}</span></td>
                    <td>
                        <div class="font-semibold" style="display:flex;align-items:center;gap:8px;">
                            <i data-lucide="file-text" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                            {{ $t->judul_tugas }}
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
                        @if($t->file_materi)
                            <a href="{{ route('download.tugas', $t->id_tugas) }}" target="_blank" class="btn btn-sm">
                                <i data-lucide="download"></i> File
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('dosen.tugas.edit', $t->id_tugas) }}" class="btn btn-sm btn-warning" data-tooltip="Edit">
                                <i data-lucide="pencil"></i>
                            </a>
                            <form action="{{ route('dosen.tugas.destroy', $t->id_tugas) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" data-tooltip="Hapus" onclick="return confirm('Hapus tugas ini?')">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i data-lucide="inbox"></i>
                            </div>
                            <h3>Belum ada tugas</h3>
                            <p>Mulai buat tugas pertama Anda untuk kelas</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection