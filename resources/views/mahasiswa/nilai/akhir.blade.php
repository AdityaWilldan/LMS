@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="award"></i></span>
        Nilai Akhir
    </h1>
    <p>Nilai akhir mata kuliah yang Anda ambil</p>
</div>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th style="width:150px;">Nilai Akhir</th>
                    <th style="width:100px;">SKS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilaiAkhir as $n)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="book" style="width:14px;height:14px;color:var(--foreground-tertiary);"></i>
                            <span class="font-medium">{{ $n['mata_kuliah'] }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-success" style="font-size:14px;padding:4px 12px;">
                            {{ $n['nilai'] }}
                        </span>
                    </td>
                    <td>
                        <span class="badge">{{ $n['sks'] }} SKS</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i data-lucide="award"></i>
                            </div>
                            <h3>Belum ada data</h3>
                            <p>Nilai akhir belum tersedia</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection