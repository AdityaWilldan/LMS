@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1><span class="icon-wrapper"><i data-lucide="clipboard-check"></i></span> Rekap Absensi</h1>
    <p>{{ $kelas->nama_kelas }} – {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswa as $m)
                @php
                    $absen = $absensi->get($m->id_mahasiswa);
                    $status = $absen ? $absen->status : 'Belum Absen';
                    $class = match($status) {
                        'Hadir' => 'badge-success',
                        'Izin' => 'badge-warning',
                        'Sakit' => 'badge-info',
                        'Alpha' => 'badge-danger',
                        default => 'badge-secondary'
                    };
                    $icon = match($status) {
                        'Hadir' => 'check-circle',
                        'Izin' => 'file-text',
                        'Sakit' => 'heart',
                        'Alpha' => 'x-circle',
                        default => 'clock'
                    };
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $m->nim }}</td>
                    <td>{{ $m->nama_mahasiswa }}</td>
                    <td>
                        <span class="badge {{ $class }}">
                            <i data-lucide="{{ $icon }}"></i> {{ $status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <h3>Belum ada mahasiswa</h3>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px; text-align:center;">
        <a href="{{ route('dosen.absensi.sesi.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection