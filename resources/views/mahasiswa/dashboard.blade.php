@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="layout-dashboard"></i></span>
        Dashboard
    </h1>
    <p>Ringkasan aktivitas akademik Anda</p>
</div>

<div class="grid grid-3 mb-6">
    <div class="stat-card accent-blue">
        <div class="stat-card-header">
            <div class="stat-card-icon blue">
                <i data-lucide="book-open"></i>
            </div>
            <div class="stat-card-trend up">
                <i data-lucide="trending-up"></i>
                Active
            </div>
        </div>
        <div class="stat-card-label">Mata Kuliah</div>
        <div class="stat-card-value">{{ Auth::guard('mahasiswa')->user()->kelas->count() }}</div>
    </div>

    <div class="stat-card accent-green">
        <div class="stat-card-header">
            <div class="stat-card-icon green">
                <i data-lucide="clipboard-list"></i>
            </div>
            <div class="stat-card-trend up">
                <i data-lucide="activity"></i>
                Pending
            </div>
        </div>
        <div class="stat-card-label">Total Tugas</div>
        <div class="stat-card-value">{{ \App\Models\Tugas::whereIn('id_kelas', Auth::guard('mahasiswa')->user()->kelas->pluck('id_kelas'))->count() }}</div>
    </div>

    <div class="stat-card accent-pink">
        <div class="stat-card-header">
            <div class="stat-card-icon pink">
                <i data-lucide="bell"></i>
            </div>
            <div class="stat-card-trend up">
                <i data-lucide="alert-circle"></i>
                Tugas
            </div>
        </div>
        <div class="stat-card-label">Belum Dikerjakan</div>
        <div class="stat-card-value" id="tugasBelumDikerjakanCount">0</div>
    </div>
</div>

<div class="grid grid-2 mb-4">
    <div class="card">
        <div class="card-header">
            <i data-lucide="sparkles"></i>
            <span>Selamat Datang</span>
        </div>
        <div class="card-body">
            <p style="color: var(--foreground-secondary); line-height:1.7;">
                Halo, <strong>{{ Auth::guard('mahasiswa')->user()->nama_mahasiswa }}</strong>! Anda login sebagai mahasiswa. Gunakan menu di samping untuk mengakses berbagai fitur akademik.
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i data-lucide="zap"></i>
            <span>Aksi Cepat</span>
        </div>
        <div class="card-body">
            <div class="d-flex gap-2" style="flex-wrap:wrap;">
                <a href="{{ route('mahasiswa.tugas.index') }}" class="btn btn-success">
                    <i data-lucide="clipboard-list"></i> Tugas
                </a>
                <a href="{{ route('mahasiswa.nilai.index') }}" class="btn">
                    <i data-lucide="star"></i> Nilai
                </a>
                <a href="{{ route('mahasiswa.jadwal.index') }}" class="btn">
                    <i data-lucide="calendar"></i> Jadwal
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- ===== MODAL NOTIFIKASI TUGAS BELUM DIKERJAKAN ===== --}}
<div id="tugasModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; backdrop-filter: blur(4px);">
    <div style="background:var(--bg-elevated); border-radius:16px; max-width:600px; width:90%; max-height:80vh; overflow-y:auto; padding:32px; border:1px solid var(--border); box-shadow:var(--shadow-lg);">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
            <div style="width:40px; height:40px; border-radius:50%; background:var(--gradient-warning); display:flex; align-items:center; justify-content:center;">
                <i data-lucide="bell" style="color:#fff; width:20px; height:20px;"></i>
            </div>
            <h2 style="font-size:20px; font-weight:700; margin:0;">Tugas Belum Dikerjakan</h2>
            <button onclick="closeTugasModal()" style="margin-left:auto; background:none; border:none; font-size:24px; cursor:pointer; color:var(--foreground-secondary);">&times;</button>
        </div>
        <div id="tugasList" style="display:flex; flex-direction:column; gap:12px;">
            {{-- diisi oleh JavaScript --}}
        </div>
        <div style="margin-top:24px; text-align:right;">
            <button onclick="closeTugasModal()" class="btn btn-primary">Tutup</button>
        </div>
    </div>
</div>

{{-- ===== SCRIPT ===== --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/tugas-belum-dikerjakan')
            .then(response => response.json())
            .then(data => {
                // Update counter di stat card
                const countEl = document.getElementById('tugasBelumDikerjakanCount');
                if (countEl) {
                    countEl.textContent = data.length;
                }

                if (data.length > 0) {
                    const modal = document.getElementById('tugasModal');
                    const list = document.getElementById('tugasList');
                    list.innerHTML = '';
                    data.forEach(tugas => {
                        const item = document.createElement('div');
                        item.style.cssText = 'padding:12px 16px; border:1px solid var(--border); border-radius:8px; background:var(--bg-secondary); display:flex; justify-content:space-between; align-items:center;';
                        const info = document.createElement('div');
                        info.innerHTML = `
                            <strong>${tugas.judul}</strong>
                            <div style="font-size:13px; color:var(--foreground-secondary);">
                                Kelas: ${tugas.kelas} &bull; Deadline: ${tugas.deadline}
                            </div>
                        `;
                        const status = document.createElement('div');
                        if (tugas.is_expired) {
                            status.innerHTML = `<span class="badge badge-danger">Lewat</span>`;
                        } else {
                            status.innerHTML = `<span class="badge badge-warning">Menunggu</span>`;
                        }
                        item.appendChild(info);
                        item.appendChild(status);
                        list.appendChild(item);
                    });
                    modal.style.display = 'flex';
                    // refresh icon lucide di dalam modal
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }
            })
            .catch(err => console.error('Gagal memuat data tugas:', err));
    });

    function closeTugasModal() {
        document.getElementById('tugasModal').style.display = 'none';
    }
</script>