<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background: #2c3e50;
            padding-top: 20px;
            position: fixed;
            width: 250px;
        }
        .sidebar a {
            color: #ccc;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #34495e;
            color: #fff;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar .active {
            background: #0d6efd;
            color: #fff;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .navbar-custom {
            background: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center text-white mb-4">LMS Mahasiswa</h4>
        <a href="{{ route('mahasiswa.dashboard') }}" class="{{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('mahasiswa.profil') }}" class="{{ request()->routeIs('mahasiswa.profil*') ? 'active' : '' }}">
            <i class="fas fa-user"></i> Profil
        </a>
        <a href="{{ route('mahasiswa.matakuliah.index') }}" class="{{ request()->routeIs('mahasiswa.matakuliah*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Mata Kuliah
        </a>
        <a href="{{ route('mahasiswa.tugas.index') }}" class="{{ request()->routeIs('mahasiswa.tugas*') ? 'active' : '' }}">
            <i class="fas fa-tasks"></i> Tugas
        </a>
        <a href="{{ route('mahasiswa.nilai.index') }}" class="{{ request()->routeIs('mahasiswa.nilai*') ? 'active' : '' }}">
            <i class="fas fa-star"></i> Nilai
        </a>
        <a href="{{ route('mahasiswa.jadwal.index') }}" class="{{ request()->routeIs('mahasiswa.jadwal*') ? 'active' : '' }}">
            <i class="fas fa-calendar"></i> Jadwal
        </a>
        <a href="{{ route('mahasiswa.absensi.index') }}" class="{{ request()->routeIs('mahasiswa.absensi*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> Absensi
        </a>
        <a href="{{ route('mahasiswa.notifikasi.index') }}" class="{{ request()->routeIs('mahasiswa.notifikasi*') ? 'active' : '' }}">
            <i class="fas fa-bell"></i> Notifikasi
        </a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="main-content">
        <div class="navbar-custom d-flex justify-content-between align-items-center">
            <h5>Selamat Datang, {{ Auth::guard('mahasiswa')->user()->nama_mahasiswa }}</h5>
            <div>
                <span class="badge bg-primary">{{ Auth::guard('mahasiswa')->user()->nim }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>