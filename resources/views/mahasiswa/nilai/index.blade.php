@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="star"></i></span>
        Nilai Tugas
    </h1>
    <p>Nilai dan feedback dari dosen untuk tugas Anda</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Tugas</th>
                    <th style="width:120px;">Nilai</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                @forelse($uploads as $u)
                <tr>
                    <td><span class="badge">{{ $loop->iteration }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="file-text" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                            <span class="font-medium">{{ $u->tugas->judul_tugas }}</span>
                        </div>
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
                        @if($u->penilaian && $u->penilaian->feedback)
                            <div style="color:var(--foreground-secondary);font-size:13px;line-height:1.5;">
                                {{ Str::limit($u->penilaian->feedback, 100) }}
                            </div>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i data-lucide="inbox"></i>
                            </div>
                            <h3>Belum ada nilai</h3>
                            <p>Tugas Anda belum dinilai oleh dosen</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection