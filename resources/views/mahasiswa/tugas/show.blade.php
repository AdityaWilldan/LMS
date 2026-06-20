@extends('layouts.mahasiswa')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>{{ $tugas->judul_tugas }}</h3>
    </div>
    <div class="card-body">
        <p><strong>Deskripsi:</strong> {{ $tugas->deskripsi ?? '-' }}</p>
        
        @if($tugas->file_materi)
            <div class="alert alert-info">
                <p><strong>Materi Tugas:</strong> 
                    <a href="{{ route('download.tugas', $tugas->id_tugas) }}" target="_blank" class="btn btn-sm btn-primary">
                        <i class="fas fa-download"></i> Download Materi
                    </a>
                </p>
            </div>
        @endif

        <p><strong>Deadline:</strong> {{ $tugas->deadline->format('d/m/Y H:i') }}</p>
        <p><strong>Kelas:</strong> {{ $tugas->kelas->nama_kelas ?? '-' }}</p>

        @if($upload)
            <div class="alert alert-info">
                <p><strong>Link Unggahan:</strong> <a href="{{ $upload->nama_file }}" target="_blank">{{ $upload->nama_file }}</a></p>
                <p><strong>Status:</strong> {{ $upload->status }}</p>
                @if(now()->lessThan($tugas->deadline))
                    <form action="{{ route('mahasiswa.tugas.delete-upload', $tugas->id_tugas) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus unggahan?')">Hapus Unggahan</button>
                    </form>
                @else
                    <p class="text-danger">Melewati deadline, tidak dapat mengubah/hapus.</p>
                @endif
            </div>
        @else
            <div class="alert alert-warning">
                Anda belum mengunggah tugas.
            </div>
        @endif

        @if(now()->lessThan($tugas->deadline))
            <form action="{{ route('mahasiswa.tugas.upload', $tugas->id_tugas) }}" method="POST" class="mt-3">
                @csrf
                <div class="mb-3">
                    <label for="link" class="form-label">Link Google Drive</label>
                    <input type="url" class="form-control" id="link" name="link" placeholder="https://drive.google.com/..." required>
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> {{ $upload ? 'Perbarui' : 'Upload' }}</button>
            </form>
        @else
            <p class="text-danger">Batas waktu pengumpulan telah lewat.</p>
        @endif
    </div>
</div>
@endsection