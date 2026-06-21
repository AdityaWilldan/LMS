@extends('layouts.mahasiswa')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-user"></i> Profil Saya
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="{{ $mahasiswa->foto_url }}" alt="Foto Profil" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #ddd;">
                <br>
                <span class="badge bg-info mt-2">Foto Profil</span>
            </div>
            <div class="col-md-9">
                <table class="table table-bordered">
                    <tr>
                        <th>NIM</th>
                        <td>{{ $mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $mahasiswa->nama_mahasiswa }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $mahasiswa->email }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $mahasiswa->username }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $mahasiswa->status_aktif }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('mahasiswa.profil.edit') }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Profil</a>
            <a href="{{ route('mahasiswa.profil.change-password') }}" class="btn btn-warning"><i class="fas fa-key"></i> Ubah Password</a>
        </div>
    </div>
</div>
@endsection