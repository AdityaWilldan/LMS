@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="file-text"></i></span>
        <span id="page-title">Detail Tugas</span>
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

<!-- Loading State -->
<div id="loadingState" class="card">
    <div class="card-body" style="text-align:center;padding:40px;">
        <i data-lucide="loader-2" style="width:24px;height:24px;animation:spin 1s linear infinite;"></i>
        <p style="margin-top:8px;">Memuat data tugas...</p>
    </div>
</div>

<!-- Content (hidden until loaded) -->
<div id="contentState" style="display:none;">
    <!-- Detail Tugas -->
    <div class="card mb-4">
        <div class="card-header">
            <i data-lucide="info"></i>
            <span>Detail Tugas</span>
        </div>
        <div class="card-body">
            <div style="margin-bottom:20px;">
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Deskripsi</div>
                <p id="deskripsi" style="color:var(--foreground-secondary);line-height:1.7;">-</p>
            </div>

            <div id="materi-container" style="display:none;">
                <div class="alert" style="background:var(--info-bg);border-color:var(--info-border);color:var(--info);margin-bottom:0;">
                    <i data-lucide="download-cloud"></i>
                    <div style="flex:1;">
                        <div class="font-medium" style="margin-bottom:4px;">Materi Tugas Tersedia</div>
                        <a href="#" id="materi-link" target="_blank" class="btn btn-sm btn-primary">
                            <i data-lucide="download"></i> Download Materi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Unggahan Saya (jika sudah upload) -->
    <div id="upload-container" class="card mb-4" style="display:none;">
        <div class="card-header">
            <i data-lucide="upload"></i>
            <span>Unggahan Anda</span>
        </div>
        <div class="card-body">
            <div style="margin-bottom:16px;">
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Link File</div>
                <a href="#" id="upload-link" target="_blank" class="link">
                    <i data-lucide="external-link"></i>
                    <span id="upload-link-text"></span>
                </a>
            </div>
            <div style="margin-bottom:16px;">
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Status</div>
                <span class="badge badge-info" id="upload-status"></span>
            </div>

            <div id="delete-container">
                <button type="button" class="btn btn-danger" id="btn-delete-upload">
                    <i data-lucide="trash-2"></i> Hapus Unggahan
                </button>
            </div>

            <div id="deadline-warning" class="alert" style="background:var(--warning-bg);border-color:var(--warning-border);color:var(--warning);margin-bottom:0;display:none;">
                <i data-lucide="alert-circle"></i>
                <div>Melewati deadline, tidak dapat mengubah atau menghapus unggahan.</div>
            </div>
        </div>
    </div>

    <!-- Belum Upload Warning -->
    <div id="no-upload-warning" class="alert" style="background:var(--warning-bg);border-color:var(--warning-border);color:var(--warning);display:none;">
        <i data-lucide="alert-triangle"></i>
        <div>Anda belum mengunggah tugas untuk tugas ini.</div>
    </div>

    <!-- Form Upload (hanya tampil jika belum deadline) -->
    <div id="upload-form-container" class="card" style="display:none;">
        <div class="card-header">
            <i data-lucide="upload-cloud"></i>
            <span id="upload-form-title">Upload Tugas</span>
        </div>
        <div class="card-body">
            <form id="uploadForm">
                <div class="mb-3">
                    <label for="link" class="form-label">
                        <i data-lucide="link"></i> Link Google Drive
                    </label>
                    <input type="url" class="form-control" id="link" name="link" placeholder="https://drive.google.com/..." required>
                    <small>
                        <i data-lucide="info"></i>
                        Pastikan link dapat diakses oleh dosen.
                    </small>
                </div>
                <button type="submit" class="btn btn-success" id="btn-upload">
                    <i data-lucide="upload" class="btn-icon"></i>
                    <span class="btn-text">Upload Tugas</span>
                    <i data-lucide="loader-2" class="spinner-icon" style="display:none;animation:spin 1s linear infinite;"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Deadline Lepas Warning -->
    <div id="deadline-expired" class="alert" style="background:var(--error-bg);border-color:var(--error-border);color:var(--error);display:none;">
        <i data-lucide="x-circle"></i>
        <div>Batas waktu pengumpulan telah lewat.</div>
    </div>

    <!-- Tombol Kembali -->
    <div style="padding:16px 0; text-align:center;">
        <a href="javascript:history.back()" class="btn">
            <i data-lucide="arrow-left"></i> Kembali
        </a>
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

.form-control.error {
    border-color: var(--error);
    box-shadow: 0 0 0 3px var(--error-bg);
}
</style>

<script>
const idTugas = {{ $id_tugas }};
let tugasData = null;

document.addEventListener('DOMContentLoaded', async function() {
    await loadTugas();
    lucide.createIcons();
});

async function loadTugas() {
    try {
        const response = await fetch(`/api/mahasiswa/tugas/${idTugas}`, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (response.status === 401) {
            window.location.href = '/login';
            return;
        }

        if (!response.ok) throw new Error('Gagal memuat data');

        const result = await response.json();
        tugasData = result.data;
        
        renderContent();
        
        // Setup event listeners
        document.getElementById('uploadForm').addEventListener('submit', handleUpload);
        document.getElementById('btn-delete-upload').addEventListener('click', handleDeleteUpload);
        
        // Show content, hide loading
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('contentState').style.display = 'block';
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('loadingState').innerHTML = `
            <div class="card-body" style="text-align:center;padding:40px;">
                <i data-lucide="alert-circle" style="width:24px;height:24px;color:var(--error);"></i>
                <p style="margin-top:8px;">Gagal memuat data tugas</p>
                <a href="/mahasiswa/tugas" class="btn btn-sm" style="margin-top:12px;">Kembali</a>
            </div>
        `;
        lucide.createIcons();
    }
}

function renderContent() {
    const { tugas, upload, now } = tugasData;
    const deadline = new Date(tugas.deadline);
    const nowDate = new Date(now);
    const isExpired = deadline < nowDate;
    
    // Update header
    document.getElementById('page-title').textContent = tugas.judul_tugas;
    const formattedDeadline = deadline.toLocaleString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    document.getElementById('page-subtitle').textContent = 
        `${tugas.kelas?.nama_kelas || ''} • Deadline: ${formattedDeadline}`;
    
    // Deskripsi
    document.getElementById('deskripsi').textContent = tugas.deskripsi || 'Tidak ada deskripsi';
    
    // Materi
    if (tugas.file_materi) {
        document.getElementById('materi-container').style.display = 'block';
        document.getElementById('materi-link').href = `/download/tugas/${tugas.id_tugas}`;
    }
    
    // Upload section
    if (upload) {
        document.getElementById('upload-container').style.display = 'block';
        document.getElementById('upload-link').href = upload.nama_file;
        document.getElementById('upload-link-text').textContent = upload.nama_file;
        document.getElementById('upload-status').textContent = upload.status;
        
        if (isExpired) {
            document.getElementById('delete-container').style.display = 'none';
            document.getElementById('deadline-warning').style.display = 'block';
        }
    } else {
        document.getElementById('no-upload-warning').style.display = 'flex';
    }
    
    // Form upload
    if (!isExpired) {
        document.getElementById('upload-form-container').style.display = 'block';
        if (upload) {
            document.getElementById('upload-form-title').textContent = 'Perbarui Unggahan';
            document.getElementById('btn-upload').querySelector('.btn-text').textContent = 'Perbarui';
            document.getElementById('link').value = upload.nama_file;
        }
    } else {
        document.getElementById('deadline-expired').style.display = 'flex';
    }
}

async function handleUpload(e) {
    e.preventDefault();
    
    const btnUpload = document.getElementById('btn-upload');
    const btnText = btnUpload.querySelector('.btn-text');
    const btnIcon = btnUpload.querySelector('.btn-icon');
    const spinner = btnUpload.querySelector('.spinner-icon');
    
    // Clear previous errors
    document.getElementById('link').classList.remove('error');
    
    // Client-side validation
    const linkInput = document.getElementById('link');
    const linkValue = linkInput.value.trim();
    
    try {
        new URL(linkValue);
    } catch (err) {
        linkInput.classList.add('error');
        showToast('Validasi Gagal', 'Link tidak valid. Pastikan format URL benar.', 'error');
        return;
    }
    
    // Show loading
    btnUpload.disabled = true;
    btnText.style.display = 'none';
    btnIcon.style.display = 'none';
    spinner.style.display = 'inline-block';
    
    try {
        const response = await fetch(`/api/mahasiswa/tugas/upload/${idTugas}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ link: linkValue }),
            credentials: 'same-origin'
        });
        
        const result = await response.json();
        
        if (response.ok) {
            showToast('Sukses', result.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast('Error', result.message || 'Gagal mengunggah tugas', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Terjadi kesalahan pada server', 'error');
    } finally {
        btnUpload.disabled = false;
        btnText.style.display = 'inline';
        btnIcon.style.display = 'inline';
        spinner.style.display = 'none';
        lucide.createIcons();
    }
}

async function handleDeleteUpload() {
    if (!confirm('Hapus unggahan ini?')) return;
    
    const btnDelete = document.getElementById('btn-delete-upload');
    btnDelete.disabled = true;
    btnDelete.innerHTML = '<i data-lucide="loader-2" style="animation:spin 1s linear infinite;"></i> Menghapus...';
    lucide.createIcons();
    
    try {
        const response = await fetch(`/api/mahasiswa/tugas/upload/${idTugas}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        });
        
        const result = await response.json();
        
        if (response.ok) {
            showToast('Sukses', result.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast('Error', result.message || 'Gagal menghapus unggahan', 'error');
            btnDelete.disabled = false;
            btnDelete.innerHTML = '<i data-lucide="trash-2"></i> Hapus Unggahan';
            lucide.createIcons();
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Terjadi kesalahan pada server', 'error');
        btnDelete.disabled = false;
        btnDelete.innerHTML = '<i data-lucide="trash-2"></i> Hapus Unggahan';
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