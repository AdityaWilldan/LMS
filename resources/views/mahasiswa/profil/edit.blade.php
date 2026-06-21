@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="pencil"></i></span>
        Edit Profil
    </h1>
    <p>Perbarui informasi profil Anda</p>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form action="{{ route('mahasiswa.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="text-center mb-4">
                @if($mahasiswa->foto)
                    <img src="{{ $mahasiswa->foto_url }}" alt="Foto Profil" class="profile-avatar" style="width:120px;height:120px;margin:0 auto;">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="profile-avatar" style="width:120px;height:120px;margin:0 auto;">
                @endif
            </div>
            
            <div class="mb-3">
                <label for="foto" class="form-label">
                    <i data-lucide="camera"></i> Foto Profil <span class="text-muted">(Opsional)</span>
                </label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                <small>
                    <i data-lucide="info"></i>
                    Format: JPG, PNG, JPEG. Maks 2MB.
                </small>
            </div>
            
            <div class="mb-3">
                <label for="nama_mahasiswa" class="form-label">
                    <i data-lucide="user"></i> Nama Lengkap
                </label>
                <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ $mahasiswa->nama_mahasiswa }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i data-lucide="mail"></i> Email
                </label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $mahasiswa->email }}" required>
            </div>
            <div class="mb-4">
                <label for="username" class="form-label">
                    <i data-lucide="at-sign"></i> Username
                </label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $mahasiswa->username }}" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i data-lucide="save"></i> Update Profil
                </button>
                <a href="{{ route('mahasiswa.profil') }}" class="btn">
                    <i data-lucide="x"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection