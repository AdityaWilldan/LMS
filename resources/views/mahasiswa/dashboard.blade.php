@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="layout-dashboard"></i></span>
        Dashboard
    </h1>
    <p>Ringkasan aktivitas akademik Anda</p>
</div>

<!-- Stat Cards Grid (4 kolom) -->
<div class="grid grid-4 mb-6">
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

    <div class="stat-card accent-orange">
        <div class="stat-card-header">
            <div class="stat-card-icon orange">
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

    <!-- NEW: Rank & Poin Card dengan Gambar PNG -->
    <div class="stat-card" style="--card-accent: var(--gradient-purple);">
        <div class="stat-card-header">
            <div class="stat-card-icon" style="background: var(--gradient-purple);">
                <i data-lucide="trophy"></i>
            </div>
            <a href="{{ route('mahasiswa.gamifikasi.index') }}" class="stat-card-trend" style="color: var(--accent); cursor:pointer; text-decoration:none;">
                Lihat <i data-lucide="arrow-right" style="width:12px;height:12px;"></i>
            </a>
        </div>
        <div class="stat-card-label">Rank & Poin</div>
        <div class="stat-card-value" id="rankValue" style="font-size:20px; display:flex; align-items:center; gap:10px;">
            <img id="rankImage" src="{{ asset('images/bronze-removebg-preview.png') }}" 
                 alt="Rank" 
                 style="width:48px; height:48px; object-fit:contain;">
            <span id="rankText" style="color:#CD7F32;">Bronze</span>
        </div>
        <div style="margin-top:8px; font-size:13px; color:var(--foreground-secondary);">
            <span id="poinValue">0</span> poin
        </div>
    </div>
</div>

<!-- NEW: Rank Progress Card dengan Gambar -->
<div class="card mb-4" id="rankProgressCard" style="display:none;">
    <div class="card-header">
        <i data-lucide="target"></i>
        <span>Progress Rank</span>
    </div>
    <div class="card-body">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:16px;">
            <div style="display:flex; align-items:center; gap:16px;">
                <img id="rankProgressImage" 
                     src="{{ asset('images/bronze-removebg-preview.png') }}" 
                     alt="Rank" 
                     style="width:80px; height:80px; object-fit:contain; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));">
                <div>
                    <div style="font-size:20px; font-weight:700;" id="rankNama">Bronze</div>
                    <div style="font-size:13px; color:var(--foreground-secondary);" id="rankRange">0 - 20 poin</div>
                </div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:12px; color:var(--foreground-secondary);">Menuju Rank Berikutnya</div>
                <div style="font-size:20px; font-weight:700;" id="sisaPoin">-</div>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div style="position:relative; height:12px; background:var(--bg-tertiary); border-radius:6px; overflow:hidden;">
            <div id="progressBar" style="height:100%; background:var(--gradient-brand); border-radius:6px; transition:width 0.5s ease; width:0%;"></div>
        </div>
        <div style="display:flex; justify-content:space-between; margin-top:8px; font-size:12px; color:var(--foreground-tertiary);">
            <span id="progressMin">0</span>
            <span id="progressMax">20</span>
        </div>
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
                <a href="{{ route('mahasiswa.gamifikasi.index') }}" class="btn" style="background:var(--gradient-purple); color:#fff; border:none;">
                    <i data-lucide="trophy"></i> Leaderboard
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Mini Leaderboard dengan Gambar Rank -->
<div class="card mb-4">
    <div class="card-header" style="justify-content:space-between;">
        <div style="display:flex; align-items:center; gap:8px;">
            <i data-lucide="trophy"></i>
            <span>Top Leaderboard</span>
        </div>
        <a href="{{ route('mahasiswa.gamifikasi.index') }}" style="font-size:13px; color:var(--accent); text-decoration:none; display:flex; align-items:center; gap:4px;">
            Lihat Semua <i data-lucide="arrow-right" style="width:14px; height:14px;"></i>
        </a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Mahasiswa</th>
                    <th style="width:100px;">Upload</th>
                    <th style="width:100px;">Hadir</th>
                    <th style="width:100px;">Poin</th>
                    <th style="width:140px;">Rank</th>
                </tr>
            </thead>
            <tbody id="miniLeaderboard">
                <tr>
                    <td colspan="6" class="text-center" style="padding:24px;">
                        <i data-lucide="loader-2" style="width:20px; height:20px; animation:spin 1s linear infinite;"></i>
                        <span style="margin-left:8px; color:var(--foreground-tertiary);">Memuat...</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Rank Badge dengan Gambar PNG */
.rank-badge-img {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 4px 12px 4px 4px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    color: #fff;
}

.rank-badge-img img {
    width: 28px;
    height: 28px;
    object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}

.medal-icon {
    font-size: 20px;
}

.highlight-row {
    background: var(--accent-bg) !important;
    border-left: 3px solid var(--accent);
}

/* Animasi glow untuk rank tinggi */
@keyframes rankGlow {
    0%, 100% { filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); }
    50% { filter: drop-shadow(0 4px 16px rgba(255,215,0,0.5)); }
}

.rank-glow {
    animation: rankGlow 2s ease-in-out infinite;
}
</style>

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
        </div>
        <div style="margin-top:24px; text-align:right;">
            <button onclick="closeTugasModal()" class="btn btn-primary">Tutup</button>
        </div>
    </div>
</div>

{{-- ===== SCRIPT ===== --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load tugas belum dikerjakan
        fetch('/api/tugas-belum-dikerjakan')
            .then(response => response.json())
            .then(data => {
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
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }
            })
            .catch(err => console.error('Gagal memuat data tugas:', err));

        // Load profil gamifikasi
        loadProfilGamifikasi();
        
        // Load mini leaderboard
        loadMiniLeaderboard();
    });

    async function loadProfilGamifikasi() {
        try {
            const response = await fetch('/api/mahasiswa/gamifikasi/profil', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Gagal memuat data');

            const result = await response.json();
            const { stats, rank } = result.data;

            // Update stat card rank dengan gambar PNG
            document.getElementById('rankImage').src = rank.gambar;
            document.getElementById('rankText').textContent = rank.nama;
            document.getElementById('rankText').style.color = rank.warna;
            document.getElementById('poinValue').textContent = stats.total_poin;

            // Tambahkan efek glow untuk rank tinggi (Great & Sage)
            const rankImage = document.getElementById('rankImage');
            if (rank.nama === 'Great' || rank.nama === 'Sage') {
                rankImage.classList.add('rank-glow');
            }

            // Update rank progress card
            document.getElementById('rankProgressCard').style.display = 'block';
            document.getElementById('rankProgressImage').src = rank.gambar;
            document.getElementById('rankNama').textContent = rank.nama;
            document.getElementById('rankNama').style.color = rank.warna;
            
            if (rank.max_poin === null) {
                // Rank tertinggi (Sage)
                document.getElementById('rankRange').textContent = 'Rank Tertinggi! 🎉';
                document.getElementById('sisaPoin').textContent = 'MAX';
                document.getElementById('progressBar').style.width = '100%';
                document.getElementById('progressBar').style.background = rank.warna_bg || rank.warna;
                document.getElementById('progressMin').textContent = rank.min_poin + '+';
                document.getElementById('progressMax').textContent = '∞';
                
                // Glow effect untuk rank tertinggi
                document.getElementById('rankProgressImage').classList.add('rank-glow');
            } else {
                document.getElementById('rankRange').textContent = `${rank.min_poin} - ${rank.max_poin} poin`;
                const sisa = rank.max_poin - stats.total_poin + 1;
                document.getElementById('sisaPoin').textContent = `${sisa} poin lagi`;
                
                // Hitung progress bar
                const range = rank.max_poin - rank.min_poin;
                const progress = stats.total_poin - rank.min_poin;
                const percentage = Math.min(100, Math.max(0, (progress / range) * 100));
                document.getElementById('progressBar').style.width = percentage + '%';
                document.getElementById('progressBar').style.background = rank.warna_bg || rank.warna;
                document.getElementById('progressMin').textContent = rank.min_poin;
                document.getElementById('progressMax').textContent = rank.max_poin;
            }

        } catch (error) {
            console.error('Error loading gamifikasi:', error);
            document.getElementById('rankText').innerHTML = '<span style="color:var(--error);">-</span>';
        }
    }

    async function loadMiniLeaderboard() {
        try {
            const response = await fetch('/api/mahasiswa/gamifikasi/leaderboard', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Gagal memuat data');

            const result = await response.json();
            renderMiniLeaderboard(result.data.slice(0, 5));
        } catch (error) {
            console.error('Error loading leaderboard:', error);
            document.getElementById('miniLeaderboard').innerHTML = `
                <tr>
                    <td colspan="6" class="text-center" style="padding:24px; color:var(--foreground-tertiary);">
                        Gagal memuat data leaderboard
                    </td>
                </tr>
            `;
        }
    }

    function renderMiniLeaderboard(data) {
        const tbody = document.getElementById('miniLeaderboard');
        const currentUserId = {{ Auth::guard('mahasiswa')->user()->id_mahasiswa }};
        
        if (!data || data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center" style="padding:24px;">
                        <i data-lucide="inbox"></i>
                        <p style="margin-top:8px;">Belum ada data</p>
                    </td>
                </tr>
            `;
            if (typeof lucide !== 'undefined') lucide.createIcons();
            return;
        }

        tbody.innerHTML = data.map(item => {
            let posisiBadge = '';
            if (item.posisi === 1) posisiBadge = '<span class="medal-icon">🥇</span>';
            else if (item.posisi === 2) posisiBadge = '<span class="medal-icon">🥈</span>';
            else if (item.posisi === 3) posisiBadge = '<span class="medal-icon">🥉</span>';
            else posisiBadge = `<span class="badge">${item.posisi}</span>`;

            const isCurrentUser = item.id_mahasiswa == currentUserId;
            const rowClass = isCurrentUser ? 'highlight-row' : '';
            
            // Tambahkan glow untuk rank tinggi
            const rankGlowClass = (item.rank.nama === 'Great' || item.rank.nama === 'Sage') ? 'rank-glow' : '';

            return `
                <tr class="${rowClass}">
                    <td>${posisiBadge}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="${item.foto}" alt="${escapeHtml(item.nama)}" 
                                 style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                            <div>
                                <div class="font-medium">
                                    ${escapeHtml(item.nama)}
                                    ${isCurrentUser ? '<span style="font-size:11px; color:var(--accent); margin-left:4px;">(Anda)</span>' : ''}
                                </div>
                                <div style="font-size:12px; color:var(--foreground-tertiary);">${escapeHtml(item.nim)}</div>
                            </div>
                        </div>
                    </td>
                    <td>${item.total_upload}</td>
                    <td>${item.total_hadir}</td>
                    <td><strong>${item.total_poin}</strong></td>
                    <td>
                        <span class="rank-badge-img" style="background:${item.rank.warna_bg || item.rank.warna};">
                            <img src="${item.rank.gambar}" alt="${item.rank.nama}" class="${rankGlowClass}">
                            ${item.rank.nama}
                        </span>
                    </td>
                </tr>
            `;
        }).join('');

        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function closeTugasModal() {
        document.getElementById('tugasModal').style.display = 'none';
    }
</script>