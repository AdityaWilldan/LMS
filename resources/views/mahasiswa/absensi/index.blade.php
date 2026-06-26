@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1><span class="icon-wrapper"><i data-lucide="calendar-check"></i></span> Absensi</h1>
    <p>Riwayat kehadiran dan absen hari ini</p>
</div>

{{-- ABSEN HARI INI --}}
<h3 class="mb-3">Absen Hari Ini</h3>
<div class="grid grid-3">
    @forelse($kelas as $k)
    <div class="class-card" style="--card-accent: var(--gradient-info);">
        <div class="class-card-header">
            <div class="class-card-icon" style="background: var(--gradient-info);">
                <i data-lucide="book"></i>
            </div>
            <div>
                <div class="class-card-title">{{ $k->mataKuliah->nama_matkul ?? $k->nama_kelas }}</div>
                <div class="class-card-subtitle">{{ $k->nama_kelas }}</div>
            </div>
        </div>
        <div class="class-card-body">
            <div style="margin-bottom:12px;">
                <div class="d-flex align-items-center gap-2">
                    <i data-lucide="calendar" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                    @if($mode == 'hari_ini')
                        <span style="font-size:13px;color:var(--foreground-secondary);">{{ \Carbon\Carbon::today()->format('d/m/Y') }}</span>
                    @else
                        <span style="font-size:13px;color:var(--foreground-secondary);">Pilih Sesi:</span>
                    @endif
                </div>
            </div>

            @if($mode == 'hari_ini')
                @if($k->sesi_aktif)
                    @if($k->sudah_absen)
                        <span class="badge badge-success" style="width:100%;display:flex;align-items:center;justify-content:center;padding:10px;">
                            <i data-lucide="check-circle"></i> Sudah Absen
                        </span>
                    @else
                        <form action="{{ route('mahasiswa.absensi.absen', $k->id_kelas) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="width:100%;">
                                <i data-lucide="check"></i> Absen Sekarang
                            </button>
                        </form>
                    @endif
                @else
                    <span class="badge badge-secondary" style="width:100%;display:flex;align-items:center;justify-content:center;padding:10px;">
                        <i data-lucide="clock"></i> Tidak Ada Sesi
                    </span>
                @endif
            @else
                {{-- Mode Bebas --}}
                @forelse($k->sesi_list as $sesi)
                    <div class="d-flex align-items-center justify-content-between" style="margin-bottom:8px; padding:4px 0; border-bottom:1px solid #f0f0f0;">
                        <span style="font-size:14px;">{{ $sesi->tanggal->format('d/m/Y') }}</span>
                        @if($sesi->sudah_absen)
                            <span class="badge badge-success"><i data-lucide="check-circle"></i> Sudah</span>
                        @else
                            <form action="{{ route('mahasiswa.absensi.absen', $k->id_kelas) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="tanggal" value="{{ $sesi->tanggal->format('Y-m-d') }}">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i data-lucide="check"></i> Absen
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <span class="badge badge-secondary">Tidak Ada Sesi Aktif</span>
                @endforelse
            @endif
        </div>
    </div>
    @empty
    <div class="empty-state" style="grid-column:1/-1;">
        <div class="empty-state-icon"><i data-lucide="book-x"></i></div>
        <h3>Belum ada kelas</h3>
        <p>Anda belum terdaftar di kelas manapun</p>
    </div>
    @endforelse
</div>

<hr style="margin:40px 0;">

{{-- RIWAYAT ABSENSI --}}
<h3 class="mb-3">Riwayat izin</h3>
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
                    <td><i data-lucide="calendar"></i> {{ $a->tanggal->format('d/m/Y') }}</td>
                    <td><i data-lucide="book"></i> {{ $a->kelas->mataKuliah->nama_matkul ?? '-' }}</td>
                    <td>
                        @php
                            $class = match($a->status) {
                                'Hadir' => 'badge-success',
                                'Izin' => 'badge-warning',
                                'Sakit' => 'badge-info',
                                default => 'badge-danger'
                            };
                            $icon = match($a->status) {
                                'Hadir' => 'check-circle',
                                'Izin' => 'file-text',
                                'Sakit' => 'heart',
                                default => 'x-circle'
                            };
                        @endphp
                        <span class="badge {{ $class }}"><i data-lucide="{{ $icon }}"></i> {{ $a->status }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <h3>Belum ada absensi</h3>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection