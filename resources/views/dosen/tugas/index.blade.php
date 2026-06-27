@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>
                <span class="icon-wrapper"><i data-lucide="clipboard-list"></i></span>
                Tugas
            </h1>
            <p>Kelola tugas untuk setiap kelas</p>
        </div>
        <a href="#" class="btn btn-primary" onclick="openCreateModal(); return false;">
            <i data-lucide="plus"></i> Tambah Tugas
        </a>
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Judul Tugas</th>
                    <th>Deadline</th>
                    <th>Kelas</th>
                    <th>Materi</th>
                    <th style="width:150px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tugas-tbody">
                <tr>
                    <td colspan="6" class="text-center" style="padding: 40px;">
                        <i data-lucide="loader-2" style="width:24px;height:24px;animation:spin 1s linear infinite;color:var(--foreground-tertiary);"></i>
                        <div style="margin-top:8px;color:var(--foreground-tertiary);">Memuat data...</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create/Edit -->
<div class="modal-overlay" id="tugasModal" style="display:none;">
    <div class="modal-container">
        <form id="tugasForm" enctype="multipart/form-data">
            <input type="hidden" id="tugas_id" name="id">
            
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Tugas</h3>
                <button type="button" class="modal-close" onclick="closeModal()">
                    <i data-lucide="x"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="mb-3">
                    <label for="judul_tugas" class="form-label">
                        <i data-lucide="file-text"></i> Judul Tugas <span style="color:var(--error);">*</span>
                    </label>
                    <input type="text" class="form-control" id="judul_tugas" name="judul_tugas" placeholder="Masukkan judul tugas" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">
                        <i data-lucide="align-left"></i> Deskripsi
                    </label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi tugas (opsional)"></textarea>
                </div>

                <div class="grid grid-2" style="gap:16px;">
                    <div class="mb-3">
                        <label for="id_kelas" class="form-label">
                            <i data-lucide="users"></i> Kelas <span style="color:var(--error);">*</span>
                        </label>
                        <select class="form-select" id="id_kelas" name="id_kelas" required>
                            <option value="">Pilih Kelas</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deadline" class="form-label">
                            <i data-lucide="calendar"></i> Deadline <span style="color:var(--error);">*</span>
                        </label>
                        <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="file_materi" class="form-label">
                        <i data-lucide="upload"></i> File Materi
                    </label>
                    <input type="file" class="form-control" id="file_materi" name="file_materi" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                    <small>
                        <i data-lucide="info"></i> Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maks 10MB.
                    </small>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i data-lucide="save"></i>
                    <span class="btn-text">Simpan</span>
                    <i data-lucide="loader-2" class="spinner-icon" style="display:none;animation:spin 1s linear infinite;"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete Confirmation -->
<div class="modal-overlay" id="deleteModal" style="display:none;">
    <div class="modal-container" style="max-width:440px;">
        <div class="modal-header">
            <h3>Konfirmasi Hapus</h3>
            <button type="button" class="modal-close" onclick="closeDeleteModal()">
                <i data-lucide="x"></i>
            </button>
        </div>
        <div class="modal-body">
            <div style="display:flex;align-items:flex-start;gap:12px;padding:12px;background:var(--error-bg);border-radius:8px;border:1px solid var(--error-border);">
                <i data-lucide="alert-triangle" style="color:var(--error);flex-shrink:0;"></i>
                <div>
                    <div style="font-weight:600;color:var(--error);margin-bottom:4px;">Perhatian!</div>
                    <div style="font-size:13px;color:var(--foreground-secondary);">
                        Apakah Anda yakin ingin menghapus tugas ini? Tindakan ini tidak dapat dibatalkan.
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" onclick="closeDeleteModal()">Batal</button>
            <button type="button" class="btn btn-danger" id="btnDelete">
                <i data-lucide="trash-2"></i>
                <span>Hapus</span>
                <i data-lucide="loader-2" class="spinner-icon" style="display:none;animation:spin 1s linear infinite;"></i>
            </button>
        </div>
    </div>
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

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 20px;
    animation: fadeIn 0.2s ease-out;
}

.modal-container {
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 12px;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: var(--foreground);
}

.modal-close {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: transparent;
    color: var(--foreground-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: var(--bg-hover);
    color: var(--foreground);
}

.modal-close svg {
    width: 18px;
    height: 18px;
}

.modal-body {
    padding: 24px;
}

.modal-footer {
    padding: 16px 24px;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    background: var(--bg-secondary);
}

/* Toast */
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

.toast-close svg {
    width: 14px;
    height: 14px;
}

@media (max-width: 768px) {
    .modal-container { max-width: 100%; margin: 0 10px; }
    .modal-body .grid.grid-2 { grid-template-columns: 1fr; }
    .toast-notification { left: 20px; right: 20px; min-width: auto; }
}
</style>

<script>
let currentDeleteId = null;

document.addEventListener('DOMContentLoaded', function() {
    loadData();
    loadKelas();

    document.getElementById('tugasForm').addEventListener('submit', handleSubmit);
    document.getElementById('btnDelete').addEventListener('click', handleDelete);

    // Close modal on overlay click
    document.getElementById('tugasModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // ESC to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
            closeDeleteModal();
        }
    });
});

// ===== LOAD DATA =====
async function loadData() {
    try {
        const response = await fetch('/api/dosen/tugas', {
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
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Gagal memuat data tugas', 'error');
        renderTable([]);
    }
}

async function loadKelas() {
    try {
        const response = await fetch('/api/dosen/absensi', {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (!response.ok) throw new Error('Gagal memuat data kelas');

        const result = await response.json();
        const select = document.getElementById('id_kelas');
        select.innerHTML = '<option value="">Pilih Kelas</option>';
        
        result.data.forEach(kelas => {
            const option = document.createElement('option');
            option.value = kelas.id_kelas;
            option.textContent = kelas.nama_kelas;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error:', error);
    }
}

function renderTable(data) {
    const tbody = document.getElementById('tugas-tbody');
    
    if (!data || data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i data-lucide="inbox"></i>
                        </div>
                        <h3>Belum ada tugas</h3>
                        <p>Mulai buat tugas pertama Anda untuk kelas</p>
                    </div>
                </td>
            </tr>
        `;
        lucide.createIcons();
        return;
    }

    tbody.innerHTML = data.map((tugas, index) => {
        const deadline = new Date(tugas.deadline);
        const formattedDeadline = deadline.toLocaleString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        const materiCell = tugas.file_materi 
            ? `<a href="/download/tugas/${tugas.id_tugas}" target="_blank" class="btn btn-sm">
                   <i data-lucide="download"></i> File
               </a>`
            : '<span class="text-muted">—</span>';

        return `
            <tr>
                <td><span class="badge">${index + 1}</span></td>
                <td>
                    <div class="font-semibold" style="display:flex;align-items:center;gap:8px;">
                        <i data-lucide="file-text" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                        ${escapeHtml(tugas.judul_tugas)}
                    </div>
                </td>
                <td>
                    <span class="badge">
                        <i data-lucide="clock"></i>
                        ${formattedDeadline}
                    </span>
                </td>
                <td>
                    <span style="display:inline-flex;align-items:center;gap:4px;">
                        <i data-lucide="book-open" style="width:12px;height:12px;color:var(--foreground-tertiary);"></i>
                        ${escapeHtml(tugas.kelas?.nama_kelas || '—')}
                    </span>
                </td>
                <td>${materiCell}</td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-warning" onclick="openEditModal(${tugas.id_tugas}); return false;" data-tooltip="Edit">
                            <i data-lucide="pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete(${tugas.id_tugas})" data-tooltip="Hapus">
                            <i data-lucide="trash-2"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
    
    lucide.createIcons();
}

// ===== MODAL HANDLERS =====
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Tugas';
    document.getElementById('tugasForm').reset();
    document.getElementById('tugas_id').value = '';
    
    // Set default deadline 7 hari dari sekarang dengan timezone lokal
    const now = new Date();
    now.setDate(now.getDate() + 7);
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('deadline').value = `${year}-${month}-${day}T${hours}:${minutes}`;
    
    document.getElementById('tugasModal').style.display = 'flex';
    lucide.createIcons();
}

async function openEditModal(id) {
    try {
        const response = await fetch(`/api/dosen/tugas/${id}`, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (!response.ok) throw new Error('Gagal memuat data');

        const result = await response.json();
        const tugas = result.data;

        document.getElementById('modalTitle').textContent = 'Edit Tugas';
        document.getElementById('tugas_id').value = tugas.id_tugas;
        document.getElementById('judul_tugas').value = tugas.judul_tugas;
        document.getElementById('deskripsi').value = tugas.deskripsi || '';
        document.getElementById('id_kelas').value = tugas.id_kelas;
        
        // Format datetime untuk input dengan timezone lokal (PERBAIKAN)
        const deadline = new Date(tugas.deadline);
        const year = deadline.getFullYear();
        const month = String(deadline.getMonth() + 1).padStart(2, '0');
        const day = String(deadline.getDate()).padStart(2, '0');
        const hours = String(deadline.getHours()).padStart(2, '0');
        const minutes = String(deadline.getMinutes()).padStart(2, '0');
        document.getElementById('deadline').value = `${year}-${month}-${day}T${hours}:${minutes}`;

        document.getElementById('tugasModal').style.display = 'flex';
        lucide.createIcons();
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Gagal memuat data tugas', 'error');
    }
}

function closeModal() {
    document.getElementById('tugasModal').style.display = 'none';
}

function confirmDelete(id) {
    currentDeleteId = id;
    document.getElementById('deleteModal').style.display = 'flex';
    lucide.createIcons();
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    currentDeleteId = null;
}

// ===== FORM SUBMIT =====
async function handleSubmit(e) {
    e.preventDefault();

    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = btnSubmit.querySelector('.btn-text');
    const spinner = btnSubmit.querySelector('.spinner-icon');

    const form = e.target;
    const formData = new FormData(form);
    const id = document.getElementById('tugas_id').value;
    const isEdit = id !== '';

    // Validasi deadline di client-side (hanya untuk create)
    if (!isEdit) {
        const deadlineInput = document.getElementById('deadline');
        const deadlineValue = deadlineInput.value;
        
        if (!deadlineValue) {
            showToast('Validasi Gagal', 'Deadline wajib diisi', 'error');
            return;
        }

        const deadline = new Date(deadlineValue);
        const now = new Date();
        
        if (deadline <= now) {
            showToast('Validasi Gagal', 'Deadline harus lebih dari waktu sekarang', 'error');
            return;
        }
    }

    btnSubmit.disabled = true;
    btnText.style.display = 'none';
    spinner.style.display = 'inline-block';

    try {
        let url, method;
        
        if (isEdit) {
            url = `/api/dosen/tugas/${id}`;
            method = 'POST';
            formData.append('_method', 'PUT');
        } else {
            url = '/api/dosen/tugas';
            method = 'POST';
        }

        const response = await fetch(url, {
            method: method,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData,
            credentials: 'same-origin'
        });

        const result = await response.json();

        if (response.ok) {
            closeModal();
            loadData();
            showToast('Sukses', result.message || 'Data berhasil disimpan', 'success');
        } else {
            if (result.errors) {
                const errorMsg = Object.values(result.errors).flat().join(', ');
                showToast('Validasi Gagal', errorMsg, 'error');
            } else {
                showToast('Error', result.message || 'Gagal menyimpan data', 'error');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Terjadi kesalahan pada server', 'error');
    } finally {
        btnSubmit.disabled = false;
        btnText.style.display = 'inline';
        spinner.style.display = 'none';
    }
}

// ===== DELETE =====
async function handleDelete() {
    if (!currentDeleteId) return;

    const btnDelete = document.getElementById('btnDelete');
    const btnText = btnDelete.querySelector('span');
    const spinner = btnDelete.querySelector('.spinner-icon');

    btnDelete.disabled = true;
    btnText.style.display = 'none';
    spinner.style.display = 'inline-block';

    try {
        const response = await fetch(`/api/dosen/tugas/${currentDeleteId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        });

        const result = await response.json();

        if (response.ok) {
            closeDeleteModal();
            loadData();
            showToast('Sukses', result.message || 'Tugas berhasil dihapus', 'success');
        } else {
            showToast('Error', result.message || 'Gagal menghapus tugas', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Terjadi kesalahan pada server', 'error');
    } finally {
        btnDelete.disabled = false;
        btnText.style.display = 'inline';
        spinner.style.display = 'none';
    }
}

// ===== TOAST =====
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

// ===== UTILITY =====
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
@endsection