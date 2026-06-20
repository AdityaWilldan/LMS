@extends('layouts.mahasiswa')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-user"></i> Profil Saya
    </div>
    <div class="card-body">
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
        <a href="{{ route('mahasiswa.profil.edit') }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Profil</a>
        <a href="{{ route('mahasiswa.profil.change-password') }}" class="btn btn-warning"><i class="fas fa-key"></i> Ubah Password</a>
    </div>
</div>
@endsection