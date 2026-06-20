@extends('layouts.dosen')

@section('content')
<h2>Beri Nilai untuk {{ $upload->mahasiswa->nama_mahasiswa }} - {{ $upload->tugas->judul_tugas }}</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('dosen.nilai.store', $upload->id_upload) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nilai" class="form-label">Nilai (0-100)</label>
                <input type="number" class="form-control" id="nilai" name="nilai" step="0.01" min="0" max="100" required>
            </div>
            <div class="mb-3">
                <label for="feedback" class="form-label">Feedback</label>
                <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Nilai</button>
            <a href="{{ route('dosen.nilai.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection