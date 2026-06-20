@extends('layouts.mahasiswa')

@section('content')
<div class="card">
    <div class="card-header">
        Ubah Password
    </div>
    <div class="card-body">
        <form action="{{ route('mahasiswa.profil.change-password.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="current_password" class="form-label">Password Lama</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-warning"><i class="fas fa-key"></i> Ganti Password</button>
            <a href="{{ route('mahasiswa.profil') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection