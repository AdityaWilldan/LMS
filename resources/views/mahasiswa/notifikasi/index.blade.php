@extends('layouts.mahasiswa')

@section('content')
<h2>Notifikasi</h2>
<div class="card">
    <div class="card-body">
        @forelse($notifikasi as $n)
        <div class="alert alert-{{ $n->status_baca == 'belum' ? 'info' : 'secondary' }} d-flex justify-content-between">
            <div>
                <p>{{ $n->pesan }}</p>
                <small class="text-muted">{{ $n->tanggal_kirim->diffForHumans() }}</small>
            </div>
            @if($n->status_baca == 'belum')
            <span class="badge bg-primary">Baru</span>
            @endif
        </div>
        @empty
        <p>Tidak ada notifikasi.</p>
        @endforelse
    </div>
</div>
@endsection