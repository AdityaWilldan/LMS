@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="pencil"></i></span>
        Edit Tugas
    </h1>
    <p>Perbarui detail tugas yang sudah ada</p>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form action="{{ route('dosen.tugas.update', $tugas->id_tugas) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="judul_tugas" class="form-label">
                    <i data-lucide="type"></i> Judul Tugas
                </label>
                <input type="text" class="form-control" id="judul_tugas" name="judul_tugas" value="{{ $tugas->judul_tugas }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">
                    <i data-lucide="align-left"></i> Deskripsi
                </label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $tugas->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label for="file_materi" class="form-label">
                    <i data-lucide="upload-cloud"></i> Upload Materi <span class="text-muted">(Opsional)</span>
                </label>
                @if($tugas->file_materi)
                    <div class="mb-3">
                        <a href="{{ route('download.tugas', $tugas->id_tugas) }}" target="_blank" class="btn btn-sm">
                            <i data-lucide="file-text"></i> Lihat File Saat Ini
                        </a>
                    </div>
                @endif
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
                <input type="datetime-local" class="form-control" id="deadline" name="deadline"
                       value="{{ $tugas->deadline->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="mb-4">
                <label for="id_kelas" class="form-label">
                    <i data-lucide="users"></i> Kelas
                </label>
                <select class="form-control" id="id_kelas" name="id_kelas" required>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id_kelas }}" {{ $k->id_kelas == $tugas->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i> Update Tugas
                </button>
                <a href="{{ route('dosen.tugas.index') }}" class="btn">
                    <i data-lucide="x"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection