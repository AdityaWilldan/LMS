@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="pencil"></i></span>
        Edit Tugas
    </h1>
    <p>Perbarui detail tugas yang sudah ada</p>
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

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <!-- Loading State -->
        <div id="loadingState" style="text-align:center;padding:40px;">
            <i data-lucide="loader-2" style="width:24px;height:24px;animation:spin 1s linear infinite;color:var(--foreground-tertiary);"></i>
            <div style="margin-top:8px;color:var(--foreground-tertiary);">Memuat data tugas...</div>
        </div>

        <!-- Form (hidden until data loaded) -->
        <form id="tugasForm" enctype="multipart/form-data" style="display:none;">
            <input type="hidden" id="tugas_id" value="{{ $id_tugas }}">
            
            <div class="mb-3">
                <label for="judul_tugas" class="form-label">
                    <i data-lucide="type"></i> Judul Tugas
                </label>
                <input type="text" class="form-control" id="judul_tugas" name="judul_tugas" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">
                    <i data-lucide="align-left"></i> Deskripsi
                </label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="file_materi" class="form-label">
                    <i data-lucide="upload-cloud"></i> Upload Materi <span class="text-muted">(Opsional)</span>
                </label>
                <div id="currentFileContainer" class="mb-2" style="display:none;">
                    <a href="#" id="currentFileLink" target="_blank" class="btn btn-sm">
                        <i data-lucide="file-text"></i> Lihat File Saat Ini
                    </a>
                </div>
                <input type="file" class="form-control" id="file_materi" name="file_materi" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                <small>
                    <i data-lucide="info"></i>
                    Kosongkan jika tidak ingin mengubah file.
                </small>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">
                    <i data-lucide="calendar-clock"></i> Deadline
                </label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                <small>
                    <i data-lucide="info"></i>
                    Deadline yang sudah lewat tetap dapat disimpan.
                </small>
            </div>
            <div class="mb-4">
                <label for="id_kelas" class="form-label">
                    <i data-lucide="users"></i> Kelas
                </label>
                <select class="form-control" id="id_kelas" name="id_kelas" required>
                    <option value="">Memuat kelas...</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i data-lucide="save" class="btn-icon"></i>
                    <span class="btn-text">Update Tugas</span>
                    <i data-lucide="loader-2" class="spinner-icon" style="display:none;animation:spin 1s linear infinite;"></i>
                </button>
                <a href="{{ route('dosen.tugas.index') }}" class="btn">
                    <i data-lucide="x"></i> Batal
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
</style>

<script>
const tugasId = {{ $id_tugas }};

document.addEventListener('DOMContentLoaded', async function() {
    await Promise.all([loadTugas(), loadKelas()]);
    lucide.createIcons();

    document.getElementById('tugasForm').addEventListener('submit', handleSubmit);
});

async function loadTugas() {
    try {
        const response = await fetch(`/api/dosen/tugas/${tugasId}`, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (response.status === 401) {
            window.location.href = '/login';
            return;
        }

        if (!response.ok) throw new Error('Gagal memuat data tugas');

        const result = await response.json();
        const tugas = result.data;

        // Populate form
        document.getElementById('judul_tugas').value = tugas.judul_tugas;
        document.getElementById('deskripsi').value = tugas.deskripsi || '';
        
        // Format deadline untuk datetime-local dengan timezone lokal
        const deadline = new Date(tugas.deadline);
        const year = deadline.getFullYear();
        const month = String(deadline.getMonth() + 1).padStart(2, '0');
        const day = String(deadline.getDate()).padStart(2, '0');
        const hours = String(deadline.getHours()).padStart(2, '0');
        const minutes = String(deadline.getMinutes()).padStart(2, '0');
        document.getElementById('deadline').value = `${year}-${month}-${day}T${hours}:${minutes}`;

        // Handle file
        if (tugas.file_materi) {
            document.getElementById('currentFileContainer').style.display = 'block';
            document.getElementById('currentFileLink').href = `/download/tugas/${tugas.id_tugas}`;
        }

        // id_kelas akan di-set setelah kelas dimuat
        window.tugasData = tugas;

        // Show form, hide loading
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('tugasForm').style.display = 'block';
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Gagal memuat data tugas', 'error');
        document.getElementById('loadingState').innerHTML = `
            <div style="color:var(--error);">
                <i data-lucide="alert-circle" style="width:24px;height:24px;margin-bottom:8px;"></i>
                <div>Gagal memuat data tugas</div>
                <a href="{{ route('dosen.tugas.index') }}" class="btn btn-sm" style="margin-top:12px;">Kembali</a>
            </div>
        `;
        lucide.createIcons();
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
            option.textContent = `${kelas.nama_kelas} — ${kelas.mata_kuliah?.nama_matkul || ''}`;
            select.appendChild(option);
        });

        // Set selected kelas setelah data tugas dimuat
        if (window.tugasData) {
            select.value = window.tugasData.id_kelas;
        } else {
            // Tunggu sampai tugasData tersedia
            const checkInterval = setInterval(() => {
                if (window.tugasData) {
                    select.value = window.tugasData.id_kelas;
                    clearInterval(checkInterval);
                }
            }, 100);
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Gagal memuat data kelas', 'error');
    }
}

async function handleSubmit(e) {
    e.preventDefault();

    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = btnSubmit.querySelector('.btn-text');
    const btnIcon = btnSubmit.querySelector('.btn-icon');
    const spinner = btnSubmit.querySelector('.spinner-icon');

    // Clear previous errors
    document.querySelectorAll('.form-control.error').forEach(el => el.classList.remove('error'));
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    // Validasi deadline di client-side (opsional untuk edit, karena deadline bisa sudah lewat)
    const deadlineInput = document.getElementById('deadline');
    const deadlineValue = deadlineInput.value;
    
    if (!deadlineValue) {
        deadlineInput.classList.add('error');
        const errorMsg = document.createElement('span');
        errorMsg.className = 'error-message';
        errorMsg.textContent = 'Deadline wajib diisi';
        deadlineInput.parentElement.appendChild(errorMsg);
        showToast('Validasi Gagal', 'Deadline wajib diisi', 'error');
        return;
    }

    // Show loading
    btnSubmit.disabled = true;
    btnText.textContent = 'Mengupdate...';
    btnIcon.style.display = 'none';
    spinner.style.display = 'inline-block';

    const form = e.target;
    const formData = new FormData(form);
    formData.append('_method', 'PUT');

    try {
        const response = await fetch(`/api/dosen/tugas/${tugasId}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData,
            credentials: 'same-origin'
        });

        const result = await response.json();

        if (response.ok) {
            showToast('Sukses', result.message || 'Tugas berhasil diupdate', 'success');
            setTimeout(() => {
                window.location.href = '{{ route("dosen.tugas.index") }}';
            }, 1000);
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
                showToast('Error', result.message || 'Gagal mengupdate tugas', 'error');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Terjadi kesalahan pada server', 'error');
    } finally {
        btnSubmit.disabled = false;
        btnText.textContent = 'Update Tugas';
        btnIcon.style.display = 'inline';
        spinner.style.display = 'none';
        lucide.createIcons();
    }
}

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
</script>
@endsection