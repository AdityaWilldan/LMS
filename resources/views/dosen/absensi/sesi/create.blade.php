@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1><span class="icon-wrapper"><i data-lucide="calendar-plus"></i></span> Buat Sesi Absen</h1>
    <p>Buka sesi absen untuk mahasiswa</p>
</div>

<div class="card" style="max-width:600px; margin:0 auto;">
    <div class="card-body">
        <form id="sesiForm">
            <div class="form-group mb-3">
                <label for="id_kelas" class="form-label">
                    <i data-lucide="book-open"></i> Kelas
                </label>
                <select name="id_kelas" id="id_kelas" class="form-control" required>
                    <option value="">Memuat kelas...</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="tanggal" class="form-label">
                    <i data-lucide="calendar"></i> Tanggal
                </label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group mb-3">
                <div class="form-check">
                    <input type="hidden" name="aktif" value="0">
                    <input type="checkbox" name="aktif" id="aktif" value="1" class="form-check-input" checked>
                    <label for="aktif" class="form-check-label">Aktifkan sesi (mahasiswa dapat absen)</label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i data-lucide="save" class="btn-icon"></i>
                    <span class="btn-text">Simpan</span>
                    <i data-lucide="loader-2" class="spinner-icon" style="display:none;animation:spin 1s linear infinite;"></i>
                </button>
                <a href="/dosen/absensi/sesi" class="btn">
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
</style>

<script>
document.addEventListener('DOMContentLoaded', async function() {
    await loadKelas();
    lucide.createIcons();
    
    document.getElementById('sesiForm').addEventListener('submit', handleSubmit);
});

async function loadKelas() {
    try {
        const response = await fetch('/api/dosen/absensi/sesi/create', {
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
            option.textContent = `${kelas.nama_kelas} - ${kelas.mata_kuliah?.nama_matkul || ''}`;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data kelas');
    }
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
    
    const jsonData = {
        id_kelas: formData.get('id_kelas'),
        tanggal: formData.get('tanggal'),
        aktif: formData.get('aktif') === '1'
    };

    try {
        const response = await fetch('/api/dosen/absensi/sesi', {
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
            window.location.href = '/dosen/absensi/sesi';
        } else {
            const result = await response.json();
            alert(result.message || 'Gagal menyimpan sesi');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    } finally {
        btnSubmit.disabled = false;
        btnText.style.display = 'inline';
        btnIcon.style.display = 'inline';
        spinner.style.display = 'none';
        lucide.createIcons();
    }
}
</script>
@endsection