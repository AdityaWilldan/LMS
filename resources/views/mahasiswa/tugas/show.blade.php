@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="file-text"></i></span>
        {{ $tugas->judul_tugas }}
    </h1>
    <p>{{ $tugas->kelas->nama_kelas ?? '' }} • Deadline: {{ $tugas->deadline->format('d/m/Y H:i') }}</p>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i data-lucide="info"></i>
        <span>Detail Tugas</span>
    </div>
    <div class="card-body">
        <div style="margin-bottom:20px;">
            <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Deskripsi</div>
            <p style="color:var(--foreground-secondary);line-height:1.7;">{{ $tugas->deskripsi ?? 'Tidak ada deskripsi' }}</p>
        </div>

        @if($tugas->file_materi)
            <div class="alert alert-info" style="margin-bottom:0;">
                <i data-lucide="download-cloud"></i>
                <div style="flex:1;">
                    <div class="font-medium" style="margin-bottom:4px;">Materi Tugas Tersedia</div>
                    <a href="{{ route('download.tugas', $tugas->id_tugas) }}" target="_blank" class="btn btn-sm btn-primary">
                        <i data-lucide="download"></i> Download Materi
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@if($upload)
    <div class="card mb-4">
        <div class="card-header">
            <i data-lucide="upload"></i>
            <span>Unggahan Anda</span>
        </div>
        <div class="card-body">
            <div style="margin-bottom:16px;">
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Link File</div>
                <a href="{{ $upload->nama_file }}" target="_blank" class="link">
                    <i data-lucide="external-link"></i>
                    {{ $upload->nama_file }}
                </a>
            </div>
            <div style="margin-bottom:16px;">
                <div style="font-size:12px;color:var(--foreground-tertiary);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.05em;">Status</div>
                <span class="badge badge-info">{{ $upload->status }}</span>
            </div>

            @if(now()->lessThan($tugas->deadline))
                <form action="{{ route('mahasiswa.tugas.delete-upload', $tugas->id_tugas) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus unggahan ini?')">
                        <i data-lucide="trash-2"></i> Hapus Unggahan
                    </button>
                </form>
            @else
                <div class="alert alert-warning" style="margin-bottom:0;">
                    <i data-lucide="alert-circle"></i>
                    <div>Melewati deadline, tidak dapat mengubah atau menghapus unggahan.</div>
                </div>
            @endif
        </div>
    </div>
@else
    <div class="alert alert-warning">
        <i data-lucide="alert-triangle"></i>
        <div>Anda belum mengunggah tugas untuk tugas ini.</div>
    </div>
@endif

@if(now()->lessThan($tugas->deadline))
    <div class="card">
        <div class="card-header">
            <i data-lucide="upload-cloud"></i>
            <span>{{ $upload ? 'Perbarui Unggahan' : 'Upload Tugas' }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('mahasiswa.tugas.upload', $tugas->id_tugas) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="link" class="form-label">
                        <i data-lucide="link"></i> Link Google Drive
                    </label>
                    <input type="url" class="form-control" id="link" name="link" placeholder="https://drive.google.com/..." required>
                    <small>
                        <i data-lucide="info"></i>
                        Pastikan link dapat diakses oleh dosen.
                    </small>
                </div>
                <button type="submit" class="btn btn-success">
                    <i data-lucide="upload"></i> {{ $upload ? 'Perbarui' : 'Upload' }} Tugas
                </button>
            </form>
        </div>
    </div>
@else
    <div class="alert alert-danger">
        <i data-lucide="x-circle"></i>
        <div>Batas waktu pengumpulan telah lewat.</div>
    </div>
@endif
@endsection