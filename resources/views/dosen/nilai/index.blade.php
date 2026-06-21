@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="star"></i></span>
        Penilaian Tugas
    </h1>
    <p>Beri nilai dan feedback untuk tugas mahasiswa</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Mahasiswa</th>
                    <th>Tugas</th>
                    <th style="width:100px;">File</th>
                    <th style="width:100px;">Nilai</th>
                    <th style="width:130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($uploadTugas as $u)
                <tr>
                    <td><span class="badge">{{ $loop->iteration }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:28px;height:28px;border-radius:50%;background:var(--gradient-brand);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:600;">
                                {{ strtoupper(substr($u->mahasiswa->nama_mahasiswa, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ $u->mahasiswa->nama_mahasiswa }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="font-medium">{{ $u->tugas->judul_tugas }}</div>
                    </td>
                    <td>
                        <a href="{{ $u->nama_file }}" target="_blank" class="link">
                            <i data-lucide="external-link"></i> Lihat
                        </a>
                    </td>
                    <td>
                        @if($u->penilaian)
                            <span class="badge badge-success">
                                <i data-lucide="check-circle"></i>
                                {{ $u->penilaian->nilai }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('dosen.nilai.create', $u->id_upload) }}" class="btn btn-sm btn-accent">
                            <i data-lucide="star"></i> Beri Nilai
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i data-lucide="inbox"></i>
                            </div>
                            <h3>Belum ada unggahan</h3>
                            <p>Belum ada tugas yang diunggah mahasiswa</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection