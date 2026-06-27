@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="calendar-check"></i></span>
        Absensi
    </h1>
    <p>Pilih kelas untuk mengisi absensi</p>
</div>

<div class="grid grid-3" id="kelas-container">
    <div class="empty-state" style="grid-column:1/-1;">
        <i data-lucide="loader-2" style="width:24px;height:24px;animation:spin 1s linear infinite;"></i>
        <p style="margin-top:8px;">Memuat data...</p>
    </div>
</div>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadData();
});

async function loadData() {
    try {
        const response = await fetch('/api/dosen/absensi', {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (response.status === 401) {
            window.location.href = '/login';
            return;
        }

        if (!response.ok) throw new Error('Gagal memuat data');

        const result = await response.json();
        renderKelas(result.data);
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('kelas-container').innerHTML = `
            <div class="empty-state" style="grid-column:1/-1;">
                <div class="empty-state-icon">
                    <i data-lucide="alert-circle"></i>
                </div>
                <h3>Gagal memuat data</h3>
                <p>Terjadi kesalahan saat memuat data kelas</p>
            </div>
        `;
        lucide.createIcons();
    }
}

function renderKelas(data) {
    const container = document.getElementById('kelas-container');
    
    if (!data || data.length === 0) {
        container.innerHTML = `
            <div class="empty-state" style="grid-column:1/-1;">
                <div class="empty-state-icon">
                    <i data-lucide="calendar-x"></i>
                </div>
                <h3>Belum ada kelas</h3>
                <p>Tidak ada kelas yang tersedia untuk absensi</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }

    let html = '';
    data.forEach(k => {
        // Card 1: Isi Absensi (biru) - mengarah ke halaman sesi
        html += `
        <div class="class-card" style="--card-accent: var(--gradient-info);">
            <div class="class-card-header">
                <div class="class-card-icon" style="background: var(--gradient-info);">
                    <i data-lucide="book-open"></i>
                </div>
                <div>
                    <div class="class-card-title">KELAS: ${escapeHtml(k.nama_kelas)}</div>
                    <div class="class-card-subtitle">${escapeHtml(k.mata_kuliah?.nama_matkul || '—')}</div>
                </div>
            </div>
            <div class="class-card-body">
                <a href="/dosen/absensi/sesi" class="btn btn-primary" style="width:100%;margin-bottom:8px;">
                    <i data-lucide="calendar-check"></i> Isi Absensi
                </a>
            </div>
        </div>
        `;
        
        // Card 2: Riwayat Izin (kuning) - mengarah ke halaman create dengan parameter from=riwayat
        html += `
        <div class="class-card" style="--card-accent: var(--gradient-warning);">
            <div class="class-card-header">
                <div class="class-card-icon" style="background: var(--gradient-warning);">
                    <i data-lucide="file-text"></i>
                </div>
                <div>
                    <div class="class-card-title">KELAS: ${escapeHtml(k.nama_kelas)}</div>
                    <div class="class-card-subtitle">Riwayat izin mahasiswa</div>
                </div>
            </div>
            <div class="class-card-body">
                <a href="/dosen/absensi/create/${k.id_kelas}?from=riwayat" class="btn btn-warning" style="width:100%;">
                    <i data-lucide="file-text"></i> Riwayat Izin
                </a>
            </div>
        </div>
        `;
    });
    
    container.innerHTML = html;
    lucide.createIcons();
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
@endsection