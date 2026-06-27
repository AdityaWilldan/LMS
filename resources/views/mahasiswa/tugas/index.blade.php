@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="clipboard-list"></i></span>
        Tugas
    </h1>
    <p>Daftar tugas dari semua mata kuliah</p>
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
        const response = await fetch('/api/mahasiswa/tugas', {
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
                <p>Terjadi kesalahan saat memuat data mata kuliah</p>
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
                    <i data-lucide="inbox"></i>
                </div>
                <h3>Belum ada mata kuliah</h3>
                <p>Anda belum mengambil mata kuliah semester ini</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }

    container.innerHTML = data.map(k => `
        <div class="class-card" style="--card-accent: var(--gradient-info);">
            <div class="class-card-header">
                <div class="class-card-icon" style="background: var(--gradient-info);">
                    <i data-lucide="book"></i>
                </div>
                <div>
                    <div class="class-card-title">${escapeHtml(k.mata_kuliah?.nama_matkul || '—')}</div>
                    <div class="class-card-subtitle">${escapeHtml(k.mata_kuliah?.kode_matkul || '')} • ${k.mata_kuliah?.sks || 0} SKS</div>
                </div>
            </div>
            <div class="class-card-body">
                <div style="margin-bottom:12px;">
                    <div class="d-flex align-items-center gap-2" style="margin-top:8px;">
                        <i data-lucide="clipboard-list" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                        <span style="font-size:13px;color:var(--foreground-secondary);">${k.tugas_count || 0} Tugas</span>
                    </div>
                </div>
                <a href="/mahasiswa/tugas/kelas/${k.id_kelas}" class="btn btn-primary" style="width:100%;">
                    <i data-lucide="arrow-right"></i> Detail
                </a>
            </div>
        </div>
    `).join('');
    
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