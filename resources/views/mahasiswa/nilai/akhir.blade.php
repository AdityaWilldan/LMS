@extends('layouts.mahasiswa')

@section('content')
<h2>Nilai Akhir Mata Kuliah</h2>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Nilai Akhir</th>
                    <th>SKS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilaiAkhir as $n)
                <tr>
                    <td>{{ $n['mata_kuliah'] }}</td>
                    <td>{{ $n['nilai'] }}</td>
                    <td>{{ $n['sks'] }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection