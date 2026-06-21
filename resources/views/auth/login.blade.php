<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #000;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Fog/Mist Effect */
        .fog-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 800px;
            height: 800px;
            pointer-events: none;
            z-index: 1;
        }

        .fog-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.05) 40%, transparent 70%);
            filter: blur(60px);
            animation: fogFloat 8s ease-in-out infinite;
        }

        .fog-circle:nth-child(1) {
            width: 400px;
            height: 400px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 0s;
        }

        .fog-circle:nth-child(2) {
            width: 300px;
            height: 300px;
            top: 40%;
            left: 60%;
            animation-delay: 2s;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.03) 40%, transparent 70%);
        }

        .fog-circle:nth-child(3) {
            width: 350px;
            height: 350px;
            top: 60%;
            left: 40%;
            animation-delay: 4s;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.02) 40%, transparent 70%);
        }

        .fog-circle:nth-child(4) {
            width: 250px;
            height: 250px;
            top: 45%;
            left: 50%;
            animation-delay: 6s;
            background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0.04) 40%, transparent 70%);
        }

        @keyframes fogFloat {
            0%, 100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.5;
            }
            50% {
                transform: translate(-50%, -50%) scale(1.1);
                opacity: 0.8;
            }
        }

        /* Additional ambient glow */
        .ambient-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(ellipse, rgba(255,255,255,0.08) 0%, transparent 60%);
            filter: blur(80px);
            z-index: 0;
            animation: pulse 6s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 0.4;
                transform: translate(-50%, -50%) scale(1);
            }
            50% {
                opacity: 0.7;
                transform: translate(-50%, -50%) scale(1.05);
            }
        }

        /* Main Container - Horizontal Layout */
        .main-container {
            width: 100%;
            max-width: 900px;
            position: relative;
            z-index: 2;
        }

        .login-wrapper {
            display: flex;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Left Side - Logo Section */
        .logo-section {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.03);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .logo-wrapper {
            position: relative;
            width: 180px;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo-glow {
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,200,0,0.3) 0%, transparent 70%);
            filter: blur(30px);
            animation: logoPulse 3s ease-in-out infinite;
        }

        @keyframes logoPulse {
            0%, 100% {
                opacity: 0.5;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        .logo-img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 0 20px rgba(255,200,0,0.4));
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 8px;
            color: #fff;
            text-transform: uppercase;
            margin-top: 10px;
            text-shadow: 0 0 20px rgba(255,255,255,0.5);
        }

        /* Right Side - Form Section */
        .form-section {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 10px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: #fff;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-input:focus {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.08);
        }

        .form-input:hover {
            border-color: rgba(255, 255, 255, 0.3);
        }

        .btn-login {
            width: 100%;
            padding: 14px 24px;
            background: #fff;
            color: #000;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            padding: 12px 16px;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 8px;
            color: #fca5a5;
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert i {
            font-size: 16px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .logo-section {
                padding: 40px 30px;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .form-section {
                padding: 40px 30px;
            }

            .logo-wrapper {
                width: 140px;
                height: 140px;
            }

            .logo-img {
                width: 120px;
                height: 120px;
            }

            .logo-text {
                font-size: 20px;
                letter-spacing: 6px;
            }

            .form-title {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .logo-section,
            .form-section {
                padding: 30px 20px;
            }

            .form-title {
                font-size: 22px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-wrapper {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    <!-- Fog Effect -->
    <div class="fog-container">
        <div class="fog-circle"></div>
        <div class="fog-circle"></div>
        <div class="fog-circle"></div>
        <div class="fog-circle"></div>
    </div>
    
    <!-- Ambient Glow -->
    <div class="ambient-glow"></div>

    <div class="main-container">
        <div class="login-wrapper">
            <!-- Left Side - Logo -->
            <div class="logo-section">
                <div class="logo-wrapper">
                    <div class="logo-glow"></div>
                    <!-- Ganti src dengan path logo universitas Anda -->
                    <img src="" alt="Universitas Mandiri" class="logo-img">
                </div>
                <div class="logo-text">LMS</div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="form-section">
                <div class="form-header">
                    <h1 class="form-title">Login</h1>
                    <p class="form-subtitle">Masukkan kredensial Anda untuk melanjutkan</p>
                </div>

                @if(session('errors'))
                    <div class="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('errors')->first('username') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="username" class="form-label">NPM / NIM</label>
                        <input 
                            type="text" 
                            class="form-input" 
                            id="username" 
                            name="username" 
                            placeholder="Masukkan NPM / NIM"
                            required 
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input 
                            type="password" 
                            class="form-input" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn-login">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>