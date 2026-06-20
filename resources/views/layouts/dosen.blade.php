<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background: #343a40;
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
            background: #495057;
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
        <h4 class="text-center text-white mb-4">LMS Dosen</h4>
        <a href="{{ route('dosen.dashboard') }}" class="{{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('dosen.tugas.index') }}" class="{{ request()->routeIs('dosen.tugas.*') ? 'active' : '' }}">
            <i class="fas fa-tasks"></i> Tugas
        </a>
        <a href="{{ route('dosen.nilai.index') }}" class="{{ request()->routeIs('dosen.nilai.*') ? 'active' : '' }}">
            <i class="fas fa-star"></i> Nilai
        </a>
        <a href="{{ route('dosen.mahasiswa.index') }}" class="{{ request()->routeIs('dosen.mahasiswa.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Mahasiswa
        </a>
        <a href="{{ route('dosen.absensi.index') }}" class="{{ request()->routeIs('dosen.absensi.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check"></i> Absensi
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
            <h5>Selamat Datang, {{ Auth::guard('dosen')->user()->nama_dosen }}</h5>
            <div>
                <span class="badge bg-primary">{{ Auth::guard('dosen')->user()->username }}</span>
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