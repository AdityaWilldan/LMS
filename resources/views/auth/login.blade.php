<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            padding: 30px;
            max-width: 400px;
            width: 100%;
        }
        .card-header {
            background: transparent;
            border-bottom: none;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        .btn-login {
            background: #764ba2;
            color: #fff;
            border-radius: 50px;
            padding: 12px;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #5a3d7a;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <i class="fas fa-graduation-cap text-primary"></i> LMS Login
        </div>
        <div class="card-body">
            @if(session('errors'))
                <div class="alert alert-danger">
                    {{ session('errors')->first('username') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-login w-100">Login</button>
            </form>
            <p class="mt-3 text-center text-muted small">Gunakan username dan password yang telah diberikan.</p>
        </div>
    </div>
</body>
</html>