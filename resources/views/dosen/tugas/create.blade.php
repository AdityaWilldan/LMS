@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="plus-circle"></i></span>
        Tambah Tugas
    </h1>
    <p>Buat tugas baru untuk kelas Anda</p>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form action="{{ route('dosen.tugas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                <input type="datetime-local" class="form-control" id="deadline" name="deadline"
                       value="{{ now()->addDays(7)->format('Y-m-d\TH:i') }}" required>
                <small>
                    <i data-lucide="clock"></i>
                    Pilih tanggal dan jam deadline.
                </small>
            </div>
            <div class="mb-4">
                <label for="id_kelas" class="form-label">
                    <i data-lucide="users"></i> Kelas
                </label>
                <select class="form-control" id="id_kelas" name="id_kelas" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} — {{ $k->mataKuliah->nama_matkul ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i data-lucide="save"></i> Simpan Tugas
                </button>
                <a href="{{ route('dosen.tugas.index') }}" class="btn">
                    <i data-lucide="x"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection