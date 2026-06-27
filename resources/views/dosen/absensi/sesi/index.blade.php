@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1><span class="icon-wrapper"><i data-lucide="calendar-check"></i></span> Sesi Absen</h1>
    <p>Kelola sesi absen untuk mahasiswa</p>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <a href="/dosen/absensi/sesi/create" class="btn btn-primary">
            <i data-lucide="plus"></i> Buat Sesi Baru
        </a>
    </div>
    <div>
        <span class="badge" id="mode-badge">
            Mode: <span id="mode-text">Memuat...</span>
        </span>
        <button class="btn btn-sm" id="btn-toggle-mode" onclick="toggleMode()">
            <i data-lucide="refresh-cw"></i> <span id="toggle-text">Ganti Mode</span>
        </button>
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="sesi-tbody">
                <tr>
                    <td colspan="5" class="text-center" style="padding:40px;">
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadData();
});

async function loadData() {
    try {
        const response = await fetch('/api/dosen/absensi/sesi', {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (response.status === 401) {
            window.location.href = '/login';
            return;
        }

        if (!response.ok) throw new Error('Gagal memuat data');

        const result = await response.json();
        renderTable(result.data);
        updateMode(result.mode);
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('sesi-tbody').innerHTML = `
            <tr>
                <td colspan="5" class="text-center" style="padding:40px;">
                    <i data-lucide="alert-circle" style="width:24px;height:24px;color:var(--error);"></i>
                    <p style="margin-top:8px;">Gagal memuat data</p>
                </td>
            </tr>
        `;
        lucide.createIcons();
    }
}

function renderTable(data) {
    const tbody = document.getElementById('sesi-tbody');
    
    if (!data || data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i data-lucide="calendar-x"></i>
                        </div>
                        <h3>Belum ada sesi</h3>
                        <p>Klik "Buat Sesi Baru" untuk membuat sesi absen</p>
                    </div>
                </td>
            </tr>
        `;
        lucide.createIcons();
        return;
    }

    tbody.innerHTML = data.map((s, index) => {
        // Parse tanggal - handle berbagai format
        let tanggal;
        if (typeof s.tanggal === 'string') {
            // Format dari API: "2026-07-30T00:00:00.000000Z" atau "2026-07-30"
            tanggal = new Date(s.tanggal);
        } else {
            tanggal = new Date(s.tanggal);
        }
        
        // Format tanggal untuk tampilan (dd/mm/yyyy)
        const tanggalFormatted = tanggal.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        
        // Format tanggal untuk URL: YYYY-MM-DD (PENTING: tanpa T dan waktu!)
        const tahun = tanggal.getFullYear();
        const bulan = String(tanggal.getMonth() + 1).padStart(2, '0');
        const hari = String(tanggal.getDate()).padStart(2, '0');
        const tanggalUrl = `${tahun}-${bulan}-${hari}`;
        
        const statusBadge = s.aktif 
            ? '<span class="badge badge-success">Aktif</span>'
            : '<span class="badge badge-secondary">Tidak Aktif</span>';
        
        const toggleBtn = s.aktif
            ? `<button class="btn btn-sm btn-warning" onclick="toggleSesi(${s.id_sesi})">
                   <i data-lucide="pause"></i> Nonaktifkan
               </button>`
            : `<button class="btn btn-sm btn-success" onclick="toggleSesi(${s.id_sesi})">
                   <i data-lucide="play"></i> Aktifkan
               </button>`;

        return `
            <tr>
                <td>${index + 1}</td>
                <td>${escapeHtml(s.kelas?.nama_kelas || '-')}</td>
                <td>${tanggalFormatted}</td>
                <td>${statusBadge}</td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="/dosen/absensi/rekap/${s.id_kelas}/${tanggalUrl}" class="btn btn-sm btn-info">
                            <i data-lucide="eye"></i> Lihat
                        </a>
                        ${toggleBtn}
                    </div>
                </td>
            </tr>
        `;
    }).join('');
    
    lucide.createIcons();
}

function updateMode(mode) {
    const modeBadge = document.getElementById('mode-badge');
    const modeText = document.getElementById('mode-text');
    const toggleBtn = document.getElementById('btn-toggle-mode');
    const toggleText = document.getElementById('toggle-text');
    
    modeText.textContent = mode === 'hari_ini' ? 'Hari Ini' : 'Bebas';
    
    if (mode === 'hari_ini') {
        modeBadge.className = 'badge badge-info';
        toggleBtn.className = 'btn btn-sm btn-secondary';
        toggleText.textContent = 'Ganti ke Bebas';
    } else {
        modeBadge.className = 'badge badge-warning';
        toggleBtn.className = 'btn btn-sm btn-primary';
        toggleText.textContent = 'Ganti ke Hari Ini';
    }
}

async function toggleSesi(idSesi) {
    if (!confirm('Toggle status sesi ini?')) return;
    
    try {
        const response = await fetch(`/api/dosen/absensi/sesi/toggle/${idSesi}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        });

        if (response.ok) {
            loadData();
        } else {
            alert('Gagal mengubah status sesi');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    }
}

async function toggleMode() {
    try {
        const response = await fetch('/api/dosen/absensi/toggle-mode', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        });

        if (response.ok) {
            const result = await response.json();
            updateMode(result.mode);
        } else {
            alert('Gagal mengubah mode');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    }
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
@endsection