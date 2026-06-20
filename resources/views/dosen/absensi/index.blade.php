@extends('layouts.dosen')

@section('content')
<h2>Absensi</h2>
<div class="row">
    @foreach($kelas as $k)
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $k->nama_kelas }}</h5>
                <p class="card-text">{{ $k->mataKuliah->nama_matkul ?? '' }}</p>
                <a href="{{ route('dosen.absensi.create', $k->id_kelas) }}" class="btn btn-primary">Isi Absensi</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection