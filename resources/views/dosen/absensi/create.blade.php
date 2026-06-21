@extends('layouts.dosen')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="clipboard-check"></i></span>
        Absensi — {{ $kelas->nama_kelas }}
    </h1>
    <p>{{ $kelas->mataKuliah->nama_matkul ?? '' }}</p>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('dosen.absensi.store', $kelas->id_kelas) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="tanggal" class="form-label">
                    <i data-lucide="calendar"></i> Tanggal Absensi
                </label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" style="max-width:280px;" required>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width:140px;">NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th style="width:200px;">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelas->mahasiswa as $m)
                        <tr>
                            <td><span class="badge">{{ $m->nim }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:28px;height:28px;border-radius:50%;background:var(--gradient-brand);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:600;">
                                        {{ strtoupper(substr($m->nama_mahasiswa, 0, 1)) }}
                                    </div>
                                    <span class="font-medium">{{ $m->nama_mahasiswa }}</span>
                                </div>
                            </td>
                            <td>
                                <select name="status[{{ $m->id_mahasiswa }}]" class="form-control">
                                    <option value="Hadir">✓ Hadir</option>
                                    <option value="Izin">📝 Izin</option>
                                    <option value="Sakit">🏥 Sakit</option>
                                    <option value="Alpha">✗ Alpha</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-success">
                    <i data-lucide="check-circle-2"></i> Simpan Absensi
                </button>
                <a href="{{ route('dosen.absensi.index') }}" class="btn">
                    <i data-lucide="arrow-left"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection