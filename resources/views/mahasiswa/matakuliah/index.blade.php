@extends('layouts.mahasiswa')

@section('content')
<h2>Mata Kuliah yang Diambil</h2>
<div class="row">
    @foreach($kelas as $k)
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $k->mataKuliah->nama_matkul }}</h5>
                <p class="card-text">Kode: {{ $k->mataKuliah->kode_matkul }} | SKS: {{ $k->mataKuliah->sks }}</p>
                <p class="card-text">Kelas: {{ $k->nama_kelas }} | Semester: {{ $k->semester }}</p>
                <a href="{{ route('mahasiswa.matakuliah.show', $k->id_kelas) }}" class="btn btn-primary">Detail</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection