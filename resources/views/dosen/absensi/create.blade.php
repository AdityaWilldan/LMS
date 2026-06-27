@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="clipboard-check"></i></span>
        <span id="page-title">Absensi</span>
    </h1>
    <p id="page-subtitle">Memuat data...</p>
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

<div class="card">
    <div class="card-body">
        <!-- Loading State -->
        <div id="loadingState" style="text-align:center;padding:40px;">
            <i data-lucide="loader-2" style="width:24px;height:24px;animation:spin 1s linear infinite;"></i>
            <p style="margin-top:8px;">Memuat data mahasiswa...</p>
        </div>

        <!-- Form -->
        <form id="absensiForm" style="display:none;">
            <input type="hidden" id="from_page" name="from_page" value="{{ request('from', 'sesi') }}">
            
            <div class="mb-4">
                <label for="tanggal" class="form-label">
                    <i data-lucide="calendar"></i> Tanggal Absensi
                </label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" style="max-width:280px;" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width:140px;">NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th style="width:200px;">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswa-tbody">
                    </tbody>
                </table>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-success" id="btnSubmit">
                    <i data-lucide="check-circle-2" class="btn-icon"></i>
                    <span class="btn-text">Simpan Absensi</span>
                    <i data-lucide="loader-2" class="spinner-icon" style="display:none;animation:spin 1s linear infinite;"></i>
                </button>
                <a href="/dosen/absensi" class="btn">
                    <i data-lucide="arrow-left"></i> Batal
                </a>
            </div>
        </form>
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
</style>

<script>
const idKelas = {{ $id_kelas }};
const fromPage = '{{ request("from", "sesi") }}';

document.addEventListener('DOMContentLoaded', async function() {
    await loadKelasData();
    lucide.createIcons();
    
    document.getElementById('absensiForm').addEventListener('submit', handleSubmit);
});

async function loadKelasData() {
    try {
        const response = await fetch(`/api/dosen/absensi/create/${idKelas}`, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (!response.ok) throw new Error('Gagal memuat data');

        const result = await response.json();
        const kelas = result.data;

        // Update title berdasarkan mode
        if (fromPage === 'riwayat') {
            document.getElementById('page-title').textContent = `Riwayat Izin — ${kelas.nama_kelas}`;
            document.getElementById('page-subtitle').textContent = `Input riwayat izin/sakit/alpha - ${kelas.mata_kuliah?.nama_matkul || ''}`;
        } else {
            document.getElementById('page-title').textContent = `Absensi — ${kelas.nama_kelas}`;
            document.getElementById('page-subtitle').textContent = kelas.mata_kuliah?.nama_matkul || '';
        }

        renderMahasiswa(kelas.mahasiswa);

        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('absensiForm').style.display = 'block';
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('loadingState').innerHTML = `
            <i data-lucide="alert-circle" style="width:24px;height:24px;color:var(--error);"></i>
            <p style="margin-top:8px;">Gagal memuat data</p>
        `;
        lucide.createIcons();
    }
}

function renderMahasiswa(mahasiswa) {
    const tbody = document.getElementById('mahasiswa-tbody');
    
    if (!mahasiswa || mahasiswa.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center" style="padding:40px;">
                    <i data-lucide="users"></i>
                    <p style="margin-top:8px;">Belum ada mahasiswa di kelas ini</p>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = mahasiswa.map(m => `
        <tr>
            <td><span class="badge">${escapeHtml(m.nim)}</span></td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div style="width:28px;height:28px;border-radius:50%;background:var(--gradient-brand);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:600;">
                        ${escapeHtml(m.nama_mahasiswa.charAt(0).toUpperCase())}
                    </div>
                    <span class="font-medium">${escapeHtml(m.nama_mahasiswa)}</span>
                </div>
            </td>
            <td>
                <select name="status[${m.id_mahasiswa}]" class="form-control">
                    <option value="Hadir">✓ Hadir</option>
                    <option value="Izin">📝 Izin</option>
                    <option value="Sakit">🏥 Sakit</option>
                    <option value="Alpha">✗ Alpha</option>
                </select>
            </td>
        </tr>
    `).join('');
}

async function handleSubmit(e) {
    e.preventDefault();

    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = btnSubmit.querySelector('.btn-text');
    const btnIcon = btnSubmit.querySelector('.btn-icon');
    const spinner = btnSubmit.querySelector('.spinner-icon');

    btnSubmit.disabled = true;
    btnText.style.display = 'none';
    btnIcon.style.display = 'none';
    spinner.style.display = 'inline-block';

    const form = e.target;
    const formData = new FormData(form);
    
    // Convert status ke object
    const status = {};
    for (let [key, value] of formData.entries()) {
        if (key.startsWith('status[')) {
            const idMhs = key.match(/status\[(\d+)\]/)[1];
            status[idMhs] = value;
        }
    }

    const tanggal = formData.get('tanggal');
    const jsonData = {
        tanggal: tanggal,
        status: status
    };

    try {
        const response = await fetch(`/api/dosen/absensi/store/${idKelas}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(jsonData),
            credentials: 'same-origin'
        });

        if (response.ok) {
            // Tampilkan toast sukses
            showToast('Sukses', 'Absensi berhasil disimpan', 'success');
            
            // Redirect setelah 1.5 detik
            setTimeout(() => {
                // Redirect berdasarkan halaman asal
                if (fromPage === 'riwayat') {
                    // Kembali ke halaman absensi index (untuk lihat card riwayat izin lagi)
                    window.location.href = '/dosen/absensi';
                } else {
                    // Kembali ke halaman sesi
                    window.location.href = '/dosen/absensi/sesi';
                }
            }, 1500);
        } else {
            const result = await response.json();
            showToast('Error', result.message || 'Gagal menyimpan absensi', 'error');
            
            // Reset button
            btnSubmit.disabled = false;
            btnText.style.display = 'inline';
            btnIcon.style.display = 'inline';
            spinner.style.display = 'none';
            lucide.createIcons();
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Terjadi kesalahan pada server', 'error');
        
        // Reset button
        btnSubmit.disabled = false;
        btnText.style.display = 'inline';
        btnIcon.style.display = 'inline';
        spinner.style.display = 'none';
        lucide.createIcons();
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