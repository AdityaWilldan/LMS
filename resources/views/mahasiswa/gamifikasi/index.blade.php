@extends('layouts.mahasiswa')

@section('content')
<div class="page-header">
    <h1>
        <span class="icon-wrapper"><i data-lucide="trophy"></i></span>
        Leaderboard & Rank
    </h1>
    <p>Lihat progress dan peringkatmu di antara mahasiswa lain</p>
</div>

<!-- Loading State -->
<div id="loadingState" style="text-align:center;padding:40px;">
    <i data-lucide="loader-2" style="width:24px;height:24px;animation:spin 1s linear infinite;"></i>
    <p style="margin-top:8px;">Memuat data...</p>
</div>

<!-- Content -->
<div id="contentState" style="display:none;">
    <!-- Profil Saya dengan Gambar Rank -->
    <div class="card mb-4" id="profil-card">
    </div>

    <!-- Leaderboard -->
    <div class="card">
        <div class="card-header">
            <i data-lucide="trophy"></i>
            <span>Top Global Leaderboard</span>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Mahasiswa</th>
                        <th style="width:100px;">Upload</th>
                        <th style="width:100px;">Hadir</th>
                        <th style="width:120px;">Poin</th>
                        <th style="width:160px;">Rank</th>
                    </tr>
                </thead>
                <tbody id="leaderboard-tbody">
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

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

.profil-header {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    flex-wrap: wrap;
}

.profil-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--border);
}

.profil-info {
    flex: 1;
    min-width: 200px;
}

.profil-nama {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 4px;
}

.profil-nim {
    font-size: 13px;
    color: var(--foreground-secondary);
}

/* Rank Badge Besar di Profil */
.rank-badge-large {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 16px 24px;
    border-radius: 16px;
    color: #fff;
    font-weight: 700;
    min-width: 140px;
}

.rank-badge-large img {
    width: 80px;
    height: 80px;
    object-fit: contain;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
}

.rank-badge-large .rank-name {
    font-size: 18px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    padding: 20px;
    border-top: 1px solid var(--border);
}

.stat-item {
    text-align: center;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--foreground);
}

.stat-label {
    font-size: 12px;
    color: var(--foreground-secondary);
    margin-top: 4px;
}

@keyframes rankGlow {
    0%, 100% { filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3)); }
    50% { filter: drop-shadow(0 4px 20px rgba(255,215,0,0.6)); }
}

.rank-glow {
    animation: rankGlow 2s ease-in-out infinite;
}

.medal-icon {
    font-size: 20px;
}

.highlight-row {
    background: var(--accent-bg) !important;
    border-left: 3px solid var(--accent);
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .profil-header {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', async function() {
    await Promise.all([loadProfil(), loadLeaderboard()]);
    lucide.createIcons();
    
    document.getElementById('loadingState').style.display = 'none';
    document.getElementById('contentState').style.display = 'block';
});

async function loadProfil() {
    try {
        const response = await fetch('/api/mahasiswa/gamifikasi/profil', {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (!response.ok) throw new Error('Gagal memuat data');

        const result = await response.json();
        const { mahasiswa, stats, rank } = result.data;

        // Tambahkan efek glow untuk rank tinggi
        const rankGlowClass = (rank.nama === 'Great' || rank.nama === 'Sage') ? 'rank-glow' : '';

        document.getElementById('profil-card').innerHTML = `
            <div class="profil-header">
                <img src="${mahasiswa.foto}" alt="${escapeHtml(mahasiswa.nama)}" class="profil-avatar">
                <div class="profil-info">
                    <div class="profil-nama">${escapeHtml(mahasiswa.nama)}</div>
                    <div class="profil-nim">NIM: ${escapeHtml(mahasiswa.nim)}</div>
                </div>
                <div class="rank-badge-large" style="background: ${rank.warna_bg || rank.warna};">
                    <img src="${rank.gambar}" alt="${rank.nama}" class="${rankGlowClass}">
                    <div class="rank-name">${rank.nama}</div>
                </div>
            </div>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value">${stats.total_upload}</div>
                    <div class="stat-label">Tugas Diupload</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">${stats.total_hadir}</div>
                    <div class="stat-label">Kehadiran</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">${stats.total_poin}</div>
                    <div class="stat-label">Total Poin</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value" style="color: ${rank.warna};">${rank.nama}</div>
                    <div class="stat-label">Rank Saat Ini</div>
                </div>
            </div>
        `;
    } catch (error) {
        console.error('Error:', error);
    }
}

async function loadLeaderboard() {
    try {
        const response = await fetch('/api/mahasiswa/gamifikasi/leaderboard', {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        });

        if (!response.ok) throw new Error('Gagal memuat data');

        const result = await response.json();
        renderLeaderboard(result.data);
    } catch (error) {
        console.error('Error:', error);
    }
}

function renderLeaderboard(data) {
    const tbody = document.getElementById('leaderboard-tbody');
    const currentUserId = {{ Auth::guard('mahasiswa')->user()->id_mahasiswa }};
    
    if (!data || data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center" style="padding:40px;">
                    <i data-lucide="inbox"></i>
                    <p style="margin-top:8px;">Belum ada data</p>
                </td>
            </tr>
        `;
        lucide.createIcons();
        return;
    }

    tbody.innerHTML = data.map(item => {
        const isTop3 = item.posisi <= 3;
        const rowStyle = isTop3 ? 'background: var(--bg-tertiary);' : '';
        const isCurrentUser = item.id_mahasiswa == currentUserId;
        const rowClass = isCurrentUser ? 'highlight-row' : '';
        
        let posisiBadge = '';
        if (item.posisi === 1) {
            posisiBadge = '🥇';
        } else if (item.posisi === 2) {
            posisiBadge = '🥈';
        } else if (item.posisi === 3) {
            posisiBadge = '🥉';
        } else {
            posisiBadge = item.posisi;
        }

        // Glow effect untuk rank tinggi
        const rankGlowClass = (item.rank.nama === 'Great' || item.rank.nama === 'Sage') ? 'rank-glow' : '';

        return `
            <tr style="${rowStyle}" class="${rowClass}">
                <td>
                    <span class="badge" style="font-size: 16px;">${posisiBadge}</span>
                </td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <img src="${item.foto}" alt="${escapeHtml(item.nama)}" 
                             style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                        <div>
                            <div class="font-medium">
                                ${escapeHtml(item.nama)}
                                ${isCurrentUser ? '<span style="font-size:11px; color:var(--accent); margin-left:4px;">(Anda)</span>' : ''}
                            </div>
                            <div style="font-size:12px;color:var(--foreground-tertiary);">${escapeHtml(item.nim)}</div>
                        </div>
                    </div>
                </td>
                <td>${item.total_upload}</td>
                <td>${item.total_hadir}</td>
                <td><strong>${item.total_poin}</strong></td>
                <td>
                    <span class="rank-badge-img" style="background: ${item.rank.warna_bg || item.rank.warna};">
                        <img src="${item.rank.gambar}" alt="${item.rank.nama}" class="${rankGlowClass}">
                        ${item.rank.nama}
                    </span>
                </td>
            </tr>
        `;
    }).join('');
    
    lucide.createIcons();
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
@endsection