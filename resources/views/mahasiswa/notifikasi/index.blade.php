@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="bell"></i></span>
        Notifikasi
    </h1>
    <p>Pemberitahuan dan pengumuman untuk Anda</p>
</div>

<div class="card">
    @forelse($notifikasi as $n)
        <div class="notification-item {{ $n->status_baca == 'belum' ? 'unread' : '' }}">
            <div class="notification-icon" style="background: {{ $n->status_baca == 'belum' ? 'var(--gradient-info)' : 'var(--gradient-brand)' }};">
                <i data-lucide="{{ $n->status_baca == 'belum' ? 'bell' : 'bell-off' }}"></i>
            </div>
            <div class="notification-content">
                <div class="notification-message">{{ $n->pesan }}</div>
                <div class="notification-time">
                    <i data-lucide="clock" style="width:12px;height:12px;display:inline;vertical-align:-1px;"></i>
                    {{ $n->tanggal_kirim->diffForHumans() }}
                </div>
            </div>
            @if($n->status_baca == 'belum')
                <span class="notification-badge">Baru</span>
            @endif
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon">
                <i data-lucide="bell-off"></i>
            </div>
            <h3>Tidak ada notifikasi</h3>
            <p>Anda belum memiliki notifikasi</p>
        </div>
    @endforelse
</div>
@endsection