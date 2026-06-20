@extends('layouts.dosen')

@section('content')
<h2>Mahasiswa di Kelas {{ $kelas->nama_kelas }}</h2>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas->mahasiswa as $m)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $m->nim }}</td>
                    <td>{{ $m->nama_mahasiswa }}</td>
                    <td>{{ $m->email }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Tidak ada mahasiswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection