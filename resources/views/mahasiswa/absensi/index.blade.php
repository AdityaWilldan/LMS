@extends('layouts.mahasiswa')

@section('content')
<h2>Data Absensi</h2>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Mata Kuliah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $a)
                <tr>
                    <td>{{ $a->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $a->kelas->mataKuliah->nama_matkul ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $a->status == 'Hadir' ? 'success' : ($a->status == 'Izin' ? 'warning' : ($a->status == 'Sakit' ? 'info' : 'danger')) }}">
                            {{ $a->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">Belum ada absensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection