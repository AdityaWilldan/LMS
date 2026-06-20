@extends('layouts.mahasiswa')

@section('content')
<h2>Detail Mata Kuliah: {{ $kelas->mataKuliah->nama_matkul }}</h2>
<div class="card mb-3">
    <div class="card-body">
        <p><strong>Kode:</strong> {{ $kelas->mataKuliah->kode_matkul }}</p>
        <p><strong>SKS:</strong> {{ $kelas->mataKuliah->sks }}</p>
        <p><strong>Dosen:</strong> {{ $kelas->mataKuliah->dosen->nama_dosen ?? '-' }}</p>
        <p><strong>Kelas:</strong> {{ $kelas->nama_kelas }}</p>
        <p><strong>Semester:</strong> {{ $kelas->semester }}</p>
        <p><strong>Tahun Ajaran:</strong> {{ $kelas->tahun_ajaran }}</p>
    </div>
</div>

<h4>Daftar Tugas</h4>
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Deadline</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas->tugas as $t)
                <tr>
                    <td>{{ $t->judul_tugas }}</td>
                    <td>{{ $t->deadline->format('d/m/Y H:i') }}</td>
                    <td><a href="{{ route('mahasiswa.tugas.show', $t->id_tugas) }}" class="btn btn-sm btn-info">Lihat</a></td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">Belum ada tugas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<h4 class="mt-3">Jadwal</h4>
<div class="card">
    <div class="card-body">
        @if($kelas->jadwal->count())
        <ul class="list-group">
            @foreach($kelas->jadwal as $j)
            <li class="list-group-item">
                {{ $j->hari }} - {{ $j->jam_mulai }} s.d. {{ $j->jam_selesai }} - Ruang {{ $j->ruangan }}
            </li>
            @endforeach
        </ul>
        @else
        <p>Tidak ada jadwal.</p>
        @endif
    </div>
</div>
@endsection