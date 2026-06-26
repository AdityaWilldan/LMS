{{-- resources/views/dosen/absensi/sesi/create.blade.php --}}
@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1><span class="icon-wrapper"><i data-lucide="calendar-plus"></i></span> Buat Sesi Absen</h1>
    <p>Buka sesi absen untuk mahasiswa</p>
</div>

<div class="card" style="max-width:600px; margin:0 auto;">
    <div class="card-body">
        <form action="{{ route('dosen.absensi.sesi.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="id_kelas">Kelas</label>
                <select name="id_kelas" id="id_kelas" class="form-control" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} - {{ $k->mataKuliah->nama_matkul ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group mb-3">
                <div class="form-check">
                    <input type="hidden" name="aktif" value="0">
                    <input type="checkbox" name="aktif" id="aktif" value="1" class="form-check-input" checked>
                    <label for="aktif" class="form-check-label">Aktifkan sesi (mahasiswa dapat absen)</label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Simpan</button>
                <a href="{{ route('dosen.absensi.sesi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection