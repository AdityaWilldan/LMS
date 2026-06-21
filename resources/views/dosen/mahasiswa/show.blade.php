@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="users"></i></span>
        Mahasiswa — {{ $kelas->nama_kelas }}
    </h1>
    <p>{{ $kelas->mataKuliah->nama_matkul ?? '' }} • {{ $kelas->mahasiswa->count() }} mahasiswa</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th style="width:140px;">NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas->mahasiswa as $m)
                <tr>
                    <td><span class="badge">{{ $loop->iteration }}</span></td>
                    <td><span class="badge">{{ $m->nim }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:28px;height:28px;border-radius:50%;background:var(--gradient-purple);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:600;">
                                {{ strtoupper(substr($m->nama_mahasiswa, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ $m->nama_mahasiswa }}</span>
                        </div>
                    </td>
                    <td>
                        <a href="mailto:{{ $m->email }}" class="link">
                            <i data-lucide="mail"></i>
                            {{ $m->email }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i data-lucide="users"></i>
                            </div>
                            <h3>Belum ada mahasiswa</h3>
                            <p>Tidak ada mahasiswa di kelas ini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection