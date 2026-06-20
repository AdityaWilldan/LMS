@extends('layouts.mahasiswa')

@section('content')
<h2>Jadwal Kuliah</h2>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
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
                    <td>{{ $j->hari }}</td>
                    <td>{{ $j->jam_mulai }}</td>
                    <td>{{ $j->jam_selesai }}</td>
                    <td>{{ $j->kelas->mataKuliah->nama_matkul ?? '-' }}</td>
                    <td>{{ $j->ruangan }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Tidak ada jadwal.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection