@extends('layouts.mahasiswa')

@section('content')
<h2>Daftar Tugas</h2>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Deadline</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tugas as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->judul_tugas }}</td>
                    <td>{{ $t->deadline->format('d/m/Y H:i') }}</td>
                    <td>{{ $t->kelas->nama_kelas ?? '-' }}</td>
                    <td><a href="{{ route('mahasiswa.tugas.show', $t->id_tugas) }}" class="btn btn-sm btn-primary">Detail</a></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Tidak ada tugas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection