@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="user"></i></span>
        Profil Saya
    </h1>
    <p>Informasi akun dan data diri Anda</p>
</div>

<div class="profile-header">
    <img src="{{ $mahasiswa->foto_url }}" alt="Foto Profil" class="profile-avatar">
    <div class="profile-info">
        <h2>{{ $mahasiswa->nama_mahasiswa }}</h2>
        <p>
            <i data-lucide="hash" style="width:14px;height:14px;display:inline;vertical-align:-2px;"></i>
            {{ $mahasiswa->nim }} • 
            <i data-lucide="mail" style="width:14px;height:14px;display:inline;vertical-align:-2px;"></i>
            {{ $mahasiswa->email }}
        </p>
        <span class="badge badge-info" style="margin-top:8px;">
            <i data-lucide="check-circle"></i>
            {{ $mahasiswa->status_aktif }}
        </span>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i data-lucide="info"></i>
        <span>Informasi Detail</span>
    </div>
    <div class="card-body">
        <div class="grid grid-2" style="gap:24px;">
            <div>
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">NIM</div>
                <div style="font-size:15px;font-weight:500;">{{ $mahasiswa->nim }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Nama Lengkap</div>
                <div style="font-size:15px;font-weight:500;">{{ $mahasiswa->nama_mahasiswa }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Email</div>
                <div style="font-size:15px;font-weight:500;">{{ $mahasiswa->email }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Username</div>
                <div style="font-size:15px;font-weight:500;">{{ $mahasiswa->username }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Status</div>
                <div style="font-size:15px;font-weight:500;">
                    <span class="badge badge-success">
                        <i data-lucide="check-circle"></i>
                        {{ $mahasiswa->status_aktif }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-3">
    <a href="{{ route('mahasiswa.profil.edit') }}" class="btn btn-primary">
        <i data-lucide="pencil"></i> Edit Profil
    </a>
    <a href="{{ route('mahasiswa.profil.change-password') }}" class="btn btn-warning">
        <i data-lucide="key"></i> Ubah Password
    </a>
</div>
@endsection