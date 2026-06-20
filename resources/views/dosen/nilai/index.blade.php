@extends('layouts.dosen')

@section('content')
<h2>Penilaian Tugas</h2>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mahasiswa</th>
                    <th>Tugas</th>
                    <th>Link</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($uploadTugas as $u)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $u->mahasiswa->nama_mahasiswa }}</td>
                    <td>{{ $u->tugas->judul_tugas }}</td>
                    <td><a href="{{ $u->nama_file }}" target="_blank">Lihat</a></td>
                    <td>{{ $u->penilaian ? $u->penilaian->nilai : '-' }}</td>
                    <td>
                        <a href="{{ route('dosen.nilai.create', $u->id_upload) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Beri Nilai</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Belum ada unggahan tugas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection