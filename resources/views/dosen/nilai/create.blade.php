@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="award"></i></span>
        Beri Nilai
    </h1>
    <p>{{ $upload->mahasiswa->nama_mahasiswa }} — {{ $upload->tugas->judul_tugas }}</p>
</div>

<div class="card" style="max-width:640px;">
    <div class="card-body">
        <form action="{{ route('dosen.nilai.store', $upload->id_upload) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nilai" class="form-label">
                    <i data-lucide="hash"></i> Nilai (0–100)
                </label>
                <input type="number" class="form-control" id="nilai" name="nilai" step="0.01" min="0" max="100" placeholder="Masukkan nilai" required>
            </div>
            <div class="mb-4">
                <label for="feedback" class="form-label">
                    <i data-lucide="message-square"></i> Feedback
                </label>
                <textarea class="form-control" id="feedback" name="feedback" rows="4" placeholder="Tulis feedback untuk mahasiswa..."></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i data-lucide="save"></i> Simpan Nilai
                </button>
                <a href="{{ route('dosen.nilai.index') }}" class="btn">
                    <i data-lucide="arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection