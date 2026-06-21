@extends('layouts.mahasiswa')

@section('content')
<div class="card">
    <div class="card-header">
        Edit Profil
    </div>
    <div class="card-body">
        <form action="{{ route('mahasiswa.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="mb-3 text-center">
                @if($mahasiswa->foto)
                    <img src="{{ $mahasiswa->foto_url }}" alt="Foto Profil" class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 2px solid #ddd;">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 2px solid #ddd;">
                @endif
            </div>
            
            <div class="mb-3">
                <label for="foto" class="form-label">Foto Profil (Opsional)</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                <small class="text-muted">Format: JPG, PNG, JPEG. Maks 2MB.</small>
            </div>
            
            <div class="mb-3">
                <label for="nama_mahasiswa" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ $mahasiswa->nama_mahasiswa }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $mahasiswa->email }}" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $mahasiswa->username }}" required>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            <a href="{{ route('mahasiswa.profil') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection