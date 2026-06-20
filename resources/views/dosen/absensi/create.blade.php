@extends('layouts.dosen')

@section('content')
<h2>Absensi Kelas {{ $kelas->nama_kelas }}</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('dosen.absensi.store', $kelas->id_kelas) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelas->mahasiswa as $m)
                    <tr>
                        <td>{{ $m->nim }}</td>
                        <td>{{ $m->nama_mahasiswa }}</td>
                        <td>
                            <select name="status[{{ $m->id_mahasiswa }}]" class="form-control">
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Alpha">Alpha</option>
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Absensi</button>
            <a href="{{ route('dosen.absensi.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection