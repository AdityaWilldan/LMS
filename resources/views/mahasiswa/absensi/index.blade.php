@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="calendar-check"></i></span>
        Absensi
    </h1>
    <p>Riwayat kehadiran Anda</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Mata Kuliah</th>
                    <th style="width:150px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $a)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="calendar" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                            {{ $a->tanggal->format('d/m/Y') }}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="book" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                            <span class="font-medium">{{ $a->kelas->mataKuliah->nama_matkul ?? '-' }}</span>
                        </div>
                    </td>
                    <td>
                        @php
                            $statusClass = match($a->status) {
                                'Hadir' => 'badge-success',
                                'Izin' => 'badge-warning',
                                'Sakit' => 'badge-info',
                                default => 'badge-danger'
                            };
                            $statusIcon = match($a->status) {
                                'Hadir' => 'check-circle',
                                'Izin' => 'file-text',
                                'Sakit' => 'heart',
                                default => 'x-circle'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">
                            <i data-lucide="{{ $statusIcon }}"></i>
                            {{ $a->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i data-lucide="calendar-x"></i>
                            </div>
                            <h3>Belum ada absensi</h3>
                            <p>Riwayat absensi belum tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection