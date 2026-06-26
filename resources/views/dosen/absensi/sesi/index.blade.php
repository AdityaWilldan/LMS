@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1><span class="icon-wrapper"><i data-lucide="calendar-check"></i></span> Sesi Absen</h1>
    <p>Kelola sesi absen untuk mahasiswa</p>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <a href="{{ route('dosen.absensi.sesi.create') }}" class="btn btn-primary">
            <i data-lucide="plus"></i> Buat Sesi Baru
        </a>
    </div>
    <div>
        <span class="badge {{ session('absensi_mode', 'hari_ini') == 'hari_ini' ? 'badge-info' : 'badge-warning' }}">
            Mode: {{ ucfirst(session('absensi_mode', 'hari_ini')) }}
        </span>
        <a href="{{ route('dosen.absensi.mode.toggle') }}" class="btn btn-sm {{ session('absensi_mode', 'hari_ini') == 'hari_ini' ? 'btn-secondary' : 'btn-primary' }}">
            <i data-lucide="refresh-cw"></i> Ganti ke {{ session('absensi_mode', 'hari_ini') == 'hari_ini' ? 'Bebas' : 'Hari Ini' }}
        </a>
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sesi as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $s->tanggal->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $s->aktif ? 'badge-success' : 'badge-secondary' }}">
                            {{ $s->aktif ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('dosen.absensi.rekap', ['id_kelas' => $s->id_kelas, 'tanggal' => $s->tanggal->format('Y-m-d')]) }}" 
                           class="btn btn-sm btn-info">
                            <i data-lucide="eye"></i> Lihat
                        </a>
                        <form action="{{ route('dosen.absensi.sesi.toggle', $s->id_sesi) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $s->aktif ? 'btn-warning' : 'btn-success' }}">
                                {{ $s->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <h3>Belum ada sesi</h3>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection