@extends('layouts.dosen')

@section('content')
<h2>Tambah Tugas</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('dosen.tugas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="judul_tugas" class="form-label">Judul Tugas</label>
                <input type="text" class="form-control" id="judul_tugas" name="judul_tugas" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="file_materi" class="form-label">Upload Materi Tugas (Opsional)</label>
                <input type="file" class="form-control" id="file_materi" name="file_materi" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                <small class="text-muted">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maks 10MB.</small>
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="datetime-local" class="form-control" id="deadline" name="deadline" 
                       value="{{ now()->addDays(7)->format('Y-m-d\TH:i') }}" required>
                <small class="text-muted">Pilih tanggal dan jam deadline. Tidak ada batasan maksimal.</small>
            </div>
            <div class="mb-3">
                <label for="id_kelas" class="form-label">Kelas</label>
                <select class="form-control" id="id_kelas" name="id_kelas" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} - {{ $k->mataKuliah->nama_matkul ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('dosen.tugas.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection