@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="clipboard-list"></i></span>
        <span id="page-title">Tugas</span>
    </h1>
    <p id="page-subtitle">Memuat data...</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Judul Tugas</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tugas-tbody">
                <tr>
                    <td colspan="5" class="text-center" style="padding:40px;">
                        <i data-lucide="loader-2" style="width:24px;height:24px;animation:spin 1s linear infinite;"></i>
                        <p style="margin-top:8px;">Memuat data...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="padding:16px; border-top:1px solid var(--border); text-align:center;">
        <a href="/mahasiswa/tugas" class="btn">
            <i data-lucide="arrow-left"></i> Kembali
        </a>
    </div>
</div>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

<script>
const idKelas = {{ $id_kelas }};

document.addEventListener('DOMContentLoaded', function() {
    loadData();
});

async function loadData() {
    try {
        const response = await fetch(`/api/mahasiswa/tugas/kelas/${idKelas}`, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (response.status === 401) {
            window.location.href = '/login';
            return;
        }

        if (!response.ok) throw new Error('Gagal memuat data');

        const result = await response.json();
        const { kelas, tugas } = result.data;

        // Update header
        document.getElementById('page-title').textContent = `Tugas - ${kelas.mata_kuliah?.nama_matkul || ''}`;
        document.getElementById('page-subtitle').textContent = 
            `${kelas.mata_kuliah?.kode_matkul || ''} • ${kelas.nama_kelas} • Semester ${kelas.semester}`;

        renderTugas(tugas);
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('tugas-tbody').innerHTML = `
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

function renderTugas(data) {
    const tbody = document.getElementById('tugas-tbody');
    
    if (!data || data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i data-lucide="inbox"></i>
                        </div>
                        <h3>Belum ada tugas</h3>
                        <p>Tidak ada tugas untuk mata kuliah ini</p>
                    </div>
                </td>
            </tr>
        `;
        lucide.createIcons();
        return;
    }

    const now = new Date();

    tbody.innerHTML = data.map((t, index) => {
        const deadline = new Date(t.deadline);
        const formattedDeadline = deadline.toLocaleString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        // Tentukan status
        let status, statusClass, statusIcon;
        if (t.upload) {
            status = 'Selesai';
            statusClass = 'badge-success';
            statusIcon = 'check-circle';
        } else if (deadline < now) {
            status = 'Telat';
            statusClass = 'badge-danger';
            statusIcon = 'alert-circle';
        } else {
            status = 'Belum';
            statusClass = 'badge-warning';
            statusIcon = 'clock';
        }

        return `
            <tr>
                <td><span class="badge">${index + 1}</span></td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <i data-lucide="file-text" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                        <span class="font-medium">${escapeHtml(t.judul_tugas)}</span>
                    </div>
                </td>
                <td>
                    <span class="badge">
                        <i data-lucide="clock"></i>
                        ${formattedDeadline}
                    </span>
                </td>
                <td>
                    <span class="badge ${statusClass}">
                        <i data-lucide="${statusIcon}"></i> ${status}
                    </span>
                </td>
                <td>
                    <a href="/mahasiswa/tugas/${t.id_tugas}" class="btn btn-sm btn-primary">
                        <i data-lucide="eye"></i> Detail
                    </a>
                </td>
            </tr>
        `;
    }).join('');
    
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