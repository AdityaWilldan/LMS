@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="star"></i></span>
        Penilaian Tugas
    </h1>
    <p>Beri nilai dan feedback untuk tugas mahasiswa</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Mahasiswa</th>
                    <th>Tugas</th>
                    <th style="width:100px;">File</th>
                    <th style="width:100px;">Nilai</th>
                    <th style="width:130px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="nilai-tbody">
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

<!-- Modal Beri Nilai -->
<div class="modal-overlay" id="nilaiModal" style="display:none;">
    <div class="modal-container" style="max-width:540px;">
        <form id="nilaiForm">
            <input type="hidden" id="id_upload" name="id_upload">
            
            <div class="modal-header">
                <h3 id="modalTitle">Beri Nilai</h3>
                <button type="button" class="modal-close" onclick="closeModal()">
                    <i data-lucide="x"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <!-- Info Mahasiswa & Tugas -->
                <div style="padding:14px;background:var(--bg-tertiary);border-radius:10px;margin-bottom:20px;border:1px solid var(--border);">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
                        <div id="modalAvatar" style="width:36px;height:36px;border-radius:50%;background:var(--gradient-brand);display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:600;"></div>
                        <div>
                            <div id="modalMahasiswa" class="font-semibold" style="font-size:14px;"></div>
                            <div id="modalTugas" style="font-size:12px;color:var(--foreground-secondary);"></div>
                        </div>
                    </div>
                    <div id="modalFileLink" style="display:none;">
                        <a href="#" id="modalFileUrl" target="_blank" class="link" style="font-size:12px;">
                            <i data-lucide="external-link" style="width:12px;height:12px;"></i> Lihat file yang diunggah
                        </a>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="nilai" class="form-label">
                        <i data-lucide="hash"></i> Nilai (0–100) <span style="color:var(--error);">*</span>
                    </label>
                    <input type="number" class="form-control" id="nilai" name="nilai" step="0.01" min="0" max="100" placeholder="Masukkan nilai" required>
                </div>
                <div class="mb-3">
                    <label for="feedback" class="form-label">
                        <i data-lucide="message-square"></i> Feedback
                    </label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="4" placeholder="Tulis feedback untuk mahasiswa..."></textarea>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-success" id="btnSubmit">
                    <i data-lucide="save" class="btn-icon"></i>
                    <span class="btn-text">Simpan Nilai</span>
                    <i data-lucide="loader-2" class="spinner-icon" style="display:none;animation:spin 1s linear infinite;"></i>
                </button>
            </div>
        </form>
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

.form-control.error {
    border-color: var(--error);
    box-shadow: 0 0 0 3px var(--error-bg);
}

.error-message {
    display: block;
    color: var(--error);
    font-size: 12px;
    margin-top: 4px;
}

@media (max-width: 768px) {
    .modal-container { max-width: 100%; margin: 0 10px; }
    .toast-notification { left: 20px; right: 20px; min-width: auto; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadData();
    
    document.getElementById('nilaiForm').addEventListener('submit', handleSubmit);
    
    // Close modal on overlay click
    document.getElementById('nilaiModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    // ESC to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
});

// ===== LOAD DATA =====
async function loadData() {
    try {
        const response = await fetch('/api/dosen/nilai', {
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
        showToast('Error', 'Gagal memuat data penilaian', 'error');
        renderTable([]);
    }
}

function renderTable(data) {
    const tbody = document.getElementById('nilai-tbody');
    
    if (!data || data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i data-lucide="inbox"></i>
                        </div>
                        <h3>Belum ada unggahan</h3>
                        <p>Belum ada tugas yang diunggah mahasiswa</p>
                    </div>
                </td>
            </tr>
        `;
        lucide.createIcons();
        return;
    }

    tbody.innerHTML = data.map((u, index) => {
        const namaMhs = u.mahasiswa?.nama_mahasiswa || '—';
        const initial = namaMhs !== '—' ? namaMhs.charAt(0).toUpperCase() : '?';
        const judulTugas = u.tugas?.judul_tugas || '—';
        
        // Handle file link (bisa URL atau path)
        const fileUrl = u.nama_file || '#';
        const isExternalLink = fileUrl.startsWith('http');
        
        const fileCell = isExternalLink || fileUrl !== '#'
            ? `<a href="${escapeHtml(fileUrl)}" target="_blank" class="link">
                   <i data-lucide="external-link"></i> Lihat
               </a>`
            : '<span class="text-muted">—</span>';

        const nilaiCell = u.penilaian
            ? `<span class="badge badge-success">
                   <i data-lucide="check-circle"></i>
                   ${u.penilaian.nilai}
               </span>`
            : '<span class="text-muted">—</span>';

        const btnLabel = u.penilaian ? 'Edit Nilai' : 'Beri Nilai';

        return `
            <tr>
                <td><span class="badge">${index + 1}</span></td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:28px;height:28px;border-radius:50%;background:var(--gradient-brand);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:600;">
                            ${initial}
                        </div>
                        <span class="font-medium">${escapeHtml(namaMhs)}</span>
                    </div>
                </td>
                <td>
                    <div class="font-medium">${escapeHtml(judulTugas)}</div>
                </td>
                <td>${fileCell}</td>
                <td>${nilaiCell}</td>
                <td>
                    <button class="btn btn-sm btn-accent" onclick='openNilaiModal(${JSON.stringify(u).replace(/'/g, "\\'")})'>
                        <i data-lucide="star"></i> ${btnLabel}
                    </button>
                </td>
            </tr>
        `;
    }).join('');
    
    lucide.createIcons();
}

// ===== MODAL HANDLERS =====
function openNilaiModal(uploadData) {
    document.getElementById('id_upload').value = uploadData.id_upload;
    
    // Info mahasiswa & tugas
    const namaMhs = uploadData.mahasiswa?.nama_mahasiswa || '—';
    const initial = namaMhs !== '—' ? namaMhs.charAt(0).toUpperCase() : '?';
    const judulTugas = uploadData.tugas?.judul_tugas || '—';
    
    document.getElementById('modalAvatar').textContent = initial;
    document.getElementById('modalMahasiswa').textContent = namaMhs;
    document.getElementById('modalTugas').textContent = judulTugas;
    
    // File link
    const fileUrl = uploadData.nama_file;
    if (fileUrl && (fileUrl.startsWith('http') || fileUrl !== '#')) {
        document.getElementById('modalFileLink').style.display = 'block';
        document.getElementById('modalFileUrl').href = fileUrl;
    } else {
        document.getElementById('modalFileLink').style.display = 'none';
    }
    
    // Pre-fill nilai & feedback jika sudah ada
    if (uploadData.penilaian) {
        document.getElementById('modalTitle').textContent = 'Edit Nilai';
        document.getElementById('nilai').value = uploadData.penilaian.nilai;
        document.getElementById('feedback').value = uploadData.penilaian.feedback || '';
    } else {
        document.getElementById('modalTitle').textContent = 'Beri Nilai';
        document.getElementById('nilai').value = '';
        document.getElementById('feedback').value = '';
    }
    
    document.getElementById('nilaiModal').style.display = 'flex';
    lucide.createIcons();
    
    // Focus ke input nilai
    setTimeout(() => document.getElementById('nilai').focus(), 100);
}

function closeModal() {
    document.getElementById('nilaiModal').style.display = 'none';
    document.getElementById('nilaiForm').reset();
    
    // Clear errors
    document.querySelectorAll('.form-control.error').forEach(el => el.classList.remove('error'));
    document.querySelectorAll('.error-message').forEach(el => el.remove());
}

// ===== FORM SUBMIT =====
async function handleSubmit(e) {
    e.preventDefault();

    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = btnSubmit.querySelector('.btn-text');
    const btnIcon = btnSubmit.querySelector('.btn-icon');
    const spinner = btnSubmit.querySelector('.spinner-icon');

    // Clear previous errors
    document.querySelectorAll('.form-control.error').forEach(el => el.classList.remove('error'));
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    // Client-side validation
    const nilaiInput = document.getElementById('nilai');
    const nilaiValue = parseFloat(nilaiInput.value);
    
    if (isNaN(nilaiValue) || nilaiValue < 0 || nilaiValue > 100) {
        nilaiInput.classList.add('error');
        const errorMsg = document.createElement('span');
        errorMsg.className = 'error-message';
        errorMsg.textContent = 'Nilai harus antara 0 dan 100';
        nilaiInput.parentElement.appendChild(errorMsg);
        showToast('Validasi Gagal', 'Nilai harus antara 0 dan 100', 'error');
        return;
    }

    // Show loading
    btnSubmit.disabled = true;
    btnText.style.display = 'none';
    btnIcon.style.display = 'none';
    spinner.style.display = 'inline-block';

    const idUpload = document.getElementById('id_upload').value;
    const formData = new FormData(e.target);
    
    // Convert FormData to JSON
    const jsonData = {
        nilai: parseFloat(formData.get('nilai')),
        feedback: formData.get('feedback') || null
    };

    try {
        const response = await fetch(`/api/dosen/nilai/store/${idUpload}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(jsonData),
            credentials: 'same-origin'
        });

        const result = await response.json();

        if (response.ok) {
            closeModal();
            loadData();
            showToast('Sukses', result.message || 'Nilai berhasil disimpan', 'success');
        } else {
            if (result.errors) {
                Object.keys(result.errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('error');
                        const errorMsg = document.createElement('span');
                        errorMsg.className = 'error-message';
                        errorMsg.textContent = result.errors[field][0];
                        input.parentElement.appendChild(errorMsg);
                    }
                });
                showToast('Validasi Gagal', 'Mohon periksa kembali form Anda', 'error');
            } else {
                showToast('Error', result.message || 'Gagal menyimpan nilai', 'error');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Terjadi kesalahan pada server', 'error');
    } finally {
        btnSubmit.disabled = false;
        btnText.style.display = 'inline';
        btnIcon.style.display = 'inline';
        spinner.style.display = 'none';
        lucide.createIcons();
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