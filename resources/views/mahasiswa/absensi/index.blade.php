@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1><span class="icon-wrapper"><i data-lucide="calendar-check"></i></span> Absensi</h1>
    <p>Riwayat kehadiran dan absen hari ini</p>
</div>

<!-- Toast Notification -->
<div id="toast" class="toast-notification" style="display:none;">
    <div class="toast-icon"></div>
    <div class="toast-content">
        <div class="toast-title" id="toastTitle">Notifikasi</div>
        <div class="toast-message" id="toastMessage"></div>
    </div>
    <button class="toast-close" onclick="hideToast()">
        <i data-lucide="x"></i>
    </button>
</div>

{{-- ABSEN HARI INI --}}
<h3 class="mb-3">Absen Hari Ini</h3>
<div class="grid grid-3" id="kelas-container">
    <div class="empty-state" style="grid-column:1/-1;">
        <i data-lucide="loader-2" style="width:24px;height:24px;animation:spin 1s linear infinite;"></i>
        <p style="margin-top:8px;">Memuat data...</p>
    </div>
</div>

<hr style="margin:40px 0;">

{{-- RIWAYAT ABSENSI --}}
<h3 class="mb-3">Riwayat izin</h3>
<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Mata Kuliah</th>
                    <th style="width:150px;">Status</th>
                </tr>
            </thead>
            <tbody id="riwayat-tbody">
                <tr>
                    <td colspan="3" class="text-center" style="padding:40px;">
                        <i data-lucide="loader-2" style="width:24px;height:24px;animation:spin 1s linear infinite;"></i>
                        <p style="margin-top:8px;">Memuat data...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 14px 16px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    min-width: 320px;
    max-width: 420px;
    box-shadow: var(--shadow-lg);
    z-index: 2000;
    animation: slideInRight 0.3s ease-out;
}

.toast-notification.success { border-left: 3px solid var(--success); }
.toast-notification.error { border-left: 3px solid var(--error); }

.toast-icon {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
    margin-top: 2px;
}

.toast-notification.success .toast-icon::before {
    content: '✓';
    color: var(--success);
    font-weight: bold;
    font-size: 16px;
}

.toast-notification.error .toast-icon::before {
    content: '✕';
    color: var(--error);
    font-weight: bold;
    font-size: 16px;
}

.toast-content { flex: 1; }

.toast-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--foreground);
    margin-bottom: 2px;
}

.toast-message {
    font-size: 13px;
    color: var(--foreground-secondary);
}

.toast-close {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    border: none;
    background: transparent;
    color: var(--foreground-tertiary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.toast-close:hover {
    background: var(--bg-hover);
    color: var(--foreground);
}

.toast-close svg { width: 14px; height: 14px; }

.btn-absen:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

<script>
let absensiData = null;

document.addEventListener('DOMContentLoaded', function() {
    loadData();
});

async function loadData() {
    try {
        const response = await fetch('/api/mahasiswa/absensi', {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (response.status === 401) {
            window.location.href = '/login';
            return;
        }

        if (!response.ok) throw new Error('Gagal memuat data');

        const result = await response.json();
        absensiData = result.data;
        
        renderKelas(absensiData.kelas, absensiData.mode);
        renderRiwayat(absensiData.absensi);
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('kelas-container').innerHTML = `
            <div class="empty-state" style="grid-column:1/-1;">
                <div class="empty-state-icon">
                    <i data-lucide="alert-circle"></i>
                </div>
                <h3>Gagal memuat data</h3>
                <p>Terjadi kesalahan saat memuat data absensi</p>
            </div>
        `;
        document.getElementById('riwayat-tbody').innerHTML = `
            <tr>
                <td colspan="3" class="text-center" style="padding:40px;">
                    <i data-lucide="alert-circle" style="width:24px;height:24px;color:var(--error);"></i>
                    <p style="margin-top:8px;">Gagal memuat data</p>
                </td>
            </tr>
        `;
        lucide.createIcons();
    }
}

function renderKelas(data, mode) {
    const container = document.getElementById('kelas-container');
    
    if (!data || data.length === 0) {
        container.innerHTML = `
            <div class="empty-state" style="grid-column:1/-1;">
                <div class="empty-state-icon">
                    <i data-lucide="book-x"></i>
                </div>
                <h3>Belum ada kelas</h3>
                <p>Anda belum terdaftar di kelas manapun</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }

    const today = new Date().toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });

    container.innerHTML = data.map(k => {
        let bodyContent = '';
        
        // Header tanggal/sesi
        if (mode === 'hari_ini') {
            bodyContent += `
                <div style="margin-bottom:12px;">
                    <div class="d-flex align-items-center gap-2">
                        <i data-lucide="calendar" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                        <span style="font-size:13px;color:var(--foreground-secondary);">${today}</span>
                    </div>
                </div>
            `;
            
            // Mode hari_ini
            if (k.sesi_aktif) {
                // Cek apakah sudah absen (ambil dari sesi pertama)
                const sudahAbsen = k.sesi_list && k.sesi_list.length > 0 && k.sesi_list[0].sudah_absen;
                
                if (sudahAbsen) {
                    bodyContent += `
                        <span class="badge badge-success" style="width:100%;display:flex;align-items:center;justify-content:center;padding:10px;">
                            <i data-lucide="check-circle"></i> Sudah Absen
                        </span>
                    `;
                } else {
                    bodyContent += `
                        <button class="btn btn-primary btn-absen" onclick="absen(${k.id_kelas})" style="width:100%;">
                            <i data-lucide="check"></i> Absen Sekarang
                        </button>
                    `;
                }
            } else {
                bodyContent += `
                    <span class="badge badge-secondary" style="width:100%;display:flex;align-items:center;justify-content:center;padding:10px;">
                        <i data-lucide="clock"></i> Tidak Ada Sesi
                    </span>
                `;
            }
        } else {
            // Mode bebas
            bodyContent += `
                <div style="margin-bottom:12px;">
                    <div class="d-flex align-items-center gap-2">
                        <i data-lucide="calendar" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                        <span style="font-size:13px;color:var(--foreground-secondary);">Pilih Sesi:</span>
                    </div>
                </div>
            `;
            
            if (k.sesi_list && k.sesi_list.length > 0) {
                k.sesi_list.forEach(sesi => {
                    const tanggal = new Date(sesi.tanggal).toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                    
                    if (sesi.sudah_absen) {
                        bodyContent += `
                            <div class="d-flex align-items-center justify-content-between" style="margin-bottom:8px; padding:4px 0; border-bottom:1px solid var(--border);">
                                <span style="font-size:14px;">${tanggal}</span>
                                <span class="badge badge-success"><i data-lucide="check-circle"></i> Sudah</span>
                            </div>
                        `;
                    } else {
                        bodyContent += `
                            <div class="d-flex align-items-center justify-content-between" style="margin-bottom:8px; padding:4px 0; border-bottom:1px solid var(--border);">
                                <span style="font-size:14px;">${tanggal}</span>
                                <button class="btn btn-sm btn-primary btn-absen" onclick="absen(${k.id_kelas}, '${sesi.tanggal}')">
                                    <i data-lucide="check"></i> Absen
                                </button>
                            </div>
                        `;
                    }
                });
            } else {
                bodyContent += `
                    <span class="badge badge-secondary">Tidak Ada Sesi Aktif</span>
                `;
            }
        }
        
        return `
            <div class="class-card" style="--card-accent: var(--gradient-info);">
                <div class="class-card-header">
                    <div class="class-card-icon" style="background: var(--gradient-info);">
                        <i data-lucide="book"></i>
                    </div>
                    <div>
                        <div class="class-card-title">${escapeHtml(k.mata_kuliah?.nama_matkul || k.nama_kelas)}</div>
                        <div class="class-card-subtitle">${escapeHtml(k.nama_kelas)}</div>
                    </div>
                </div>
                <div class="class-card-body">
                    ${bodyContent}
                </div>
            </div>
        `;
    }).join('');
    
    lucide.createIcons();
}

function renderRiwayat(data) {
    const tbody = document.getElementById('riwayat-tbody');
    
    if (!data || data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3">
                    <div class="empty-state">
                        <h3>Belum ada absensi</h3>
                    </div>
                </td>
            </tr>
        `;
        lucide.createIcons();
        return;
    }

    tbody.innerHTML = data.map(a => {
        const tanggal = new Date(a.tanggal).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        
        const badgeClass = {
            'Hadir': 'badge-success',
            'Izin': 'badge-warning',
            'Sakit': 'badge-info',
            'Alpha': 'badge-danger'
        }[a.status] || 'badge-secondary';
        
        const icon = {
            'Hadir': 'check-circle',
            'Izin': 'file-text',
            'Sakit': 'heart',
            'Alpha': 'x-circle'
        }[a.status] || 'clock';
        
        return `
            <tr>
                <td><i data-lucide="calendar"></i> ${tanggal}</td>
                <td><i data-lucide="book"></i> ${escapeHtml(a.kelas?.mata_kuliah?.nama_matkul || '-')}</td>
                <td>
                    <span class="badge ${badgeClass}"><i data-lucide="${icon}"></i> ${a.status}</span>
                </td>
            </tr>
        `;
    }).join('');
    
    lucide.createIcons();
}

async function absen(idKelas, tanggal = null) {
    if (!confirm('Apakah Anda yakin ingin absen?')) return;
    
    // Disable semua tombol absen
    document.querySelectorAll('.btn-absen').forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i data-lucide="loader-2" style="animation:spin 1s linear infinite;"></i> Memproses...';
    });
    lucide.createIcons();
    
    const body = tanggal ? { tanggal: tanggal } : {};
    
    try {
        const response = await fetch(`/api/mahasiswa/absensi/absen/${idKelas}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(body),
            credentials: 'same-origin'
        });
        
        const result = await response.json();
        
        if (response.ok) {
            showToast('Sukses', result.message || 'Absen berhasil!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast('Error', result.message || 'Gagal absen', 'error');
            // Re-enable tombol
            loadData();
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Terjadi kesalahan pada server', 'error');
        // Re-enable tombol
        loadData();
    }
}

// Toast functions
let toastTimeout;
function showToast(title, message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastTitle = document.getElementById('toastTitle');
    const toastMessage = document.getElementById('toastMessage');

    toastTitle.textContent = title;
    toastMessage.textContent = message;
    
    toast.className = 'toast-notification ' + type;
    toast.style.display = 'flex';

    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(hideToast, 4000);
}

function hideToast() {
    document.getElementById('toast').style.display = 'none';
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
@endsection