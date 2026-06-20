@extends('layouts.dosen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Tugas</h2>
    <a href="{{ route('dosen.tugas.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Tugas</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Deadline</th>
                    <th>Kelas</th>
                    <th>Materi</th>
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
                    <td>
                        @if($t->file_materi)
                            <a href="{{ route('download.tugas', $t->id_tugas) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-file"></i>
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('dosen.tugas.edit', $t->id_tugas) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('dosen.tugas.destroy', $t->id_tugas) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus tugas ini?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Belum ada tugas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection