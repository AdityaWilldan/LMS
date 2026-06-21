@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="calendar"></i></span>
        Jadwal Kuliah
    </h1>
    <p>Jadwal kuliah Anda minggu ini</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Mata Kuliah</th>
                    <th>Ruangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $j)
                <tr>
                    <td>
                        <span class="badge badge-info">
                            <i data-lucide="calendar-days"></i>
                            {{ $j->hari }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="clock" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                            {{ $j->jam_mulai }}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="clock" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                            {{ $j->jam_selesai }}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="book" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                            <span class="font-medium">{{ $j->kelas->mataKuliah->nama_matkul ?? '-' }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="map-pin" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                            Ruang {{ $j->ruangan }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i data-lucide="calendar-x"></i>
                            </div>
                            <h3>Tidak ada jadwal</h3>
                            <p>Jadwal kuliah belum tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection