@extends('layouts.dosen')

@section('content')
<h2>Edit Tugas</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('dosen.tugas.update', $tugas->id_tugas) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="judul_tugas" class="form-label">Judul Tugas</label>
                <input type="text" class="form-control" id="judul_tugas" name="judul_tugas" value="{{ $tugas->judul_tugas }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $tugas->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label for="file_materi" class="form-label">Upload Materi Tugas (Opsional)</label>
                @if($tugas->file_materi)
                    <div class="mb-2">
                        <a href="{{ route('download.tugas', $tugas->id_tugas) }}" target="_blank" class="btn btn-sm btn-info">
                            <i class="fas fa-file"></i> Lihat File Saat Ini
                        </a>
                    </div>
                @endif
                <input type="file" class="form-control" id="file_materi" name="file_materi" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                <small class="text-muted">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maks 10MB. Kosongkan jika tidak ingin mengubah.</small>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline" 
                       value="{{ $tugas->deadline->format('Y-m-d\TH:i') }}" required>
                <small class="text-muted">Anda dapat mengubah deadline kapan saja.</small>
            </div>
            <div class="mb-3">
                <label for="id_kelas" class="form-label">Kelas</label>
                <select class="form-control" id="id_kelas" name="id_kelas" required>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id_kelas }}" {{ $k->id_kelas == $tugas->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Update</button>
            <a href="{{ route('dosen.tugas.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection