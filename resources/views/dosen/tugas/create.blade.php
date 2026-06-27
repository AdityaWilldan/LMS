@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="plus-circle"></i></span>
        Tambah Tugas
    </h1>
    <p>Buat tugas baru untuk kelas Anda</p>
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
        <form id="tugasForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judul_tugas" class="form-label">
                    <i data-lucide="type"></i> Judul Tugas
                </label>
                <input type="text" class="form-control" id="judul_tugas" name="judul_tugas" placeholder="Contoh: Tugas Akhir Bab 1" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">
                    <i data-lucide="align-left"></i> Deskripsi
                </label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi tugas..."></textarea>
            </div>
            <div class="mb-3">
                <label for="file_materi" class="form-label">
                    <i data-lucide="upload-cloud"></i> Upload Materi <span class="text-muted">(Opsional)</span>
                </label>
                <input type="file" class="form-control" id="file_materi" name="file_materi" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                <small>
                    <i data-lucide="info"></i>
                    Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maks 10MB.
                </small>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">
                    <i data-lucide="calendar-clock"></i> Deadline
                </label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                <small>
                    <i data-lucide="clock"></i>
                    Deadline harus lebih dari waktu sekarang.
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
                <button type="submit" class="btn btn-success" id="btnSubmit">
                    <i data-lucide="save" class="btn-icon"></i>
                    <span class="btn-text">Simpan Tugas</span>
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
document.addEventListener('DOMContentLoaded', async function() {
    // Set default deadline (7 hari dari sekarang) dengan timezone lokal
    const now = new Date();
    now.setDate(now.getDate() + 7);
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('deadline').value = `${year}-${month}-${day}T${hours}:${minutes}`;
    
    // Set min attribute untuk mencegah pilih tanggal masa lalu
    const minDate = new Date();
    minDate.setMinutes(minDate.getMinutes() + 5); // Minimal 5 menit dari sekarang
    const minYear = minDate.getFullYear();
    const minMonth = String(minDate.getMonth() + 1).padStart(2, '0');
    const minDay = String(minDate.getDate()).padStart(2, '0');
    const minHours = String(minDate.getHours()).padStart(2, '0');
    const minMinutes = String(minDate.getMinutes()).padStart(2, '0');
    document.getElementById('deadline').min = `${minYear}-${minMonth}-${minDay}T${minHours}:${minMinutes}`;
    
    await loadKelas();
    lucide.createIcons();

    document.getElementById('tugasForm').addEventListener('submit', handleSubmit);
});

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

    // Validasi deadline di client-side
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

    const deadline = new Date(deadlineValue);
    const now = new Date();
    
    if (deadline <= now) {
        deadlineInput.classList.add('error');
        const errorMsg = document.createElement('span');
        errorMsg.className = 'error-message';
        errorMsg.textContent = 'Deadline harus lebih dari waktu sekarang';
        deadlineInput.parentElement.appendChild(errorMsg);
        showToast('Validasi Gagal', 'Deadline harus lebih dari waktu sekarang', 'error');
        return;
    }

    // Show loading
    btnSubmit.disabled = true;
    btnText.textContent = 'Menyimpan...';
    btnIcon.style.display = 'none';
    spinner.style.display = 'inline-block';

    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('/api/dosen/tugas', {
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
            showToast('Sukses', result.message || 'Tugas berhasil ditambahkan', 'success');
            setTimeout(() => {
                window.location.href = '{{ route("dosen.tugas.index") }}';
            }, 1000);
        } else {
            // Handle validation errors
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
                showToast('Error', result.message || 'Gagal menyimpan tugas', 'error');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Error', 'Terjadi kesalahan pada server', 'error');
    } finally {
        btnSubmit.disabled = false;
        btnText.textContent = 'Simpan Tugas';
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