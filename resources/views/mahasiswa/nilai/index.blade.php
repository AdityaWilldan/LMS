@extends('layouts.mahasiswa')

@section('content')
<h2>Nilai Tugas</h2>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tugas</th>
                    <th>Nilai</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                @forelse($uploads as $u)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $u->tugas->judul_tugas }}</td>
                    <td>{{ $u->penilaian ? $u->penilaian->nilai : '-' }}</td>
                    <td>{{ $u->penilaian ? $u->penilaian->feedback : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Belum ada nilai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection