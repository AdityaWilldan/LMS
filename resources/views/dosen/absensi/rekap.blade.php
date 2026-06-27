@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1><span class="icon-wrapper"><i data-lucide="clipboard-check"></i></span> Rekap Absensi</h1>
    <p id="page-subtitle">Memuat data...</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="rekap-tbody">
                <tr>
                    <td colspan="4" class="text-center" style="padding:40px;">
                        <i data-lucide="loader-2" style="width:24px;height:24px;animation:spin 1s linear infinite;"></i>
                        <p style="margin-top:8px;">Memuat data...</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="padding:16px; text-align:center;">
        <a href="/dosen/absensi/sesi" class="btn">
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
const tanggal = '{{ $tanggal }}';

document.addEventListener('DOMContentLoaded', function() {
    loadData();
});

async function loadData() {
    try {
        const response = await fetch(`/api/dosen/absensi/rekap/${idKelas}/${tanggal}`, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (!response.ok) throw new Error('Gagal memuat data');

        const result = await response.json();
        const data = result.data;

        const tanggalFormatted = new Date(data.tanggal).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });

        document.getElementById('page-subtitle').textContent = `${data.kelas.nama_kelas} – ${tanggalFormatted}`;
        renderRekap(data.mahasiswa, data.absensi);
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('rekap-tbody').innerHTML = `
            <tr>
                <td colspan="4" class="text-center" style="padding:40px;">
                    <i data-lucide="alert-circle" style="width:24px;height:24px;color:var(--error);"></i>
                    <p style="margin-top:8px;">Gagal memuat data</p>
                </td>
            </tr>
        `;
        lucide.createIcons();
    }
}

function renderRekap(mahasiswa, absensi) {
    const tbody = document.getElementById('rekap-tbody');
    
    if (!mahasiswa || mahasiswa.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i data-lucide="users"></i>
                        </div>
                        <h3>Belum ada mahasiswa</h3>
                    </div>
                </td>
            </tr>
        `;
        lucide.createIcons();
        return;
    }

    tbody.innerHTML = mahasiswa.map((m, index) => {
        const absen = absensi[m.id_mahasiswa];
        const status = absen ? absen.status : 'Belum Absen';
        
        const badgeClass = {
            'Hadir': 'badge-success',
            'Izin': 'badge-warning',
            'Sakit': 'badge-info',
            'Alpha': 'badge-danger',
            'Belum Absen': 'badge-secondary'
        }[status] || 'badge-secondary';

        const icon = {
            'Hadir': 'check-circle',
            'Izin': 'file-text',
            'Sakit': 'heart',
            'Alpha': 'x-circle',
            'Belum Absen': 'clock'
        }[status] || 'clock';

        return `
            <tr>
                <td>${index + 1}</td>
                <td>${escapeHtml(m.nim)}</td>
                <td>${escapeHtml(m.nama_mahasiswa)}</td>
                <td>
                    <span class="badge ${badgeClass}">
                        <i data-lucide="${icon}"></i> ${status}
                    </span>
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