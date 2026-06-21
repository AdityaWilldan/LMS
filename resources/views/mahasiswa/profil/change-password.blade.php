@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="key"></i></span>
        Ubah Password
    </h1>
    <p>Perbarui password akun Anda</p>
</div>

<div class="card" style="max-width:640px;">
    <div class="card-body">
        <form action="{{ route('mahasiswa.profil.change-password.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="current_password" class="form-label">
                    <i data-lucide="lock"></i> Password Lama
                </label>
                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Masukkan password lama" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">
                    <i data-lucide="key"></i> Password Baru
                </label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan password baru" required>
            </div>
            <div class="mb-4">
                <label for="new_password_confirmation" class="form-label">
                    <i data-lucide="key-round"></i> Konfirmasi Password Baru
                </label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Konfirmasi password baru" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i data-lucide="shield-check"></i> Ganti Password
                </button>
                <a href="{{ route('mahasiswa.profil') }}" class="btn">
                    <i data-lucide="x"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection