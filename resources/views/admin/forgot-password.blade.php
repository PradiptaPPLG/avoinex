<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password Admin — Avoinex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0066CC;
            --primary-dark: #004A99;
            --sidebar-bg: #080F1E;
            --surface: #ffffff;
            --surface-2: #F4F7FC;
            --text-primary: #0D1B2A;
            --text-muted: #8FA0B5;
            --border: #DDE5F0;
            --danger: #EF4444;
            --success: #0DAF7A;
            --shadow-lg: 0 10px 40px rgba(0,30,80,0.15);
            --radius: 12px;
            --radius-sm: 8px;
        }
        * { box-sizing: border-box; margin: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--sidebar-bg);
            position: relative;
            overflow: hidden;
        }

        /* Ambient orbs */
        .orb { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.5; pointer-events: none; }
        .orb-1 { width: 350px; height: 350px; background: #0066CC; top: -100px; left: -100px; animation: moveOrb 18s ease-in-out infinite alternate; }
        .orb-2 { width: 400px; height: 400px; background: #0DAF7A; bottom: -150px; right: -150px; animation: moveOrb 22s ease-in-out infinite alternate-reverse; }
        .orb-3 { width: 300px; height: 300px; background: #8338EC; top: 40%; right: -50px; animation: moveOrb 20s ease-in-out infinite alternate; }

        @keyframes moveOrb {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(100px, 80px) scale(1.2); }
            100% { transform: translate(-50px, -60px) scale(0.9); }
        }

        .forgot-card {
            width: 100%; max-width: 440px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 44px 40px;
            position: relative;
            z-index: 1;
            animation: cardEntrance 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }
        @keyframes cardEntrance {
            0% { opacity: 0; transform: translateY(30px) scale(0.96); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        .forgot-icon {
            width: 64px; height: 64px;
            background: var(--primary);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            color: #fff; font-size: 26px;
            box-shadow: 0 8px 24px rgba(0,102,204,0.4);
        }
        .forgot-card h2 { text-align: center; font-size: 20px; font-weight: 800; color: var(--text-primary); margin-bottom: 6px; }
        .forgot-card .subtitle { text-align: center; font-size: 13px; color: var(--text-muted); margin-bottom: 28px; line-height: 1.6; }

        .form-label { font-size: 12.5px; font-weight: 600; color: #5A6B82; letter-spacing: 0.02em; margin-bottom: 6px; }
        .input-icon-wrap { position: relative; }
        .input-icon-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 15px; }
        .input-icon-wrap .form-control { padding-left: 42px; }
        .form-control {
            font-size: 13.5px; border: 1.5px solid var(--border); border-radius: var(--radius-sm);
            padding: 11px 14px; color: var(--text-primary); background: var(--surface);
            transition: all 0.2s; font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(0,102,204,0.12); outline: none; }
        .form-control::placeholder { color: var(--text-muted); }

        .btn-submit {
            width: 100%; background: var(--primary); border: none; color: white;
            padding: 12px; font-size: 14px; font-weight: 700; border-radius: var(--radius-sm);
            font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer; transition: all 0.2s; margin-top: 8px;
        }
        .btn-submit:hover { background: var(--primary-dark); box-shadow: 0 4px 16px rgba(0,102,204,0.4); }

        .back-link { display: block; text-align: center; margin-top: 20px; font-size: 13px; color: var(--text-muted); font-weight: 600; text-decoration: none; }
        .back-link:hover { color: var(--primary); }

        .alert { border-radius: var(--radius-sm); border: none; font-size: 13px; font-weight: 500; padding: 12px 16px; margin-bottom: 20px; }
        .alert-danger { background: rgba(239,68,68,0.08); color: #991B1B; border-left: 3px solid var(--danger); }
        .alert-success { background: rgba(13,175,122,0.10); color: #065F46; border-left: 3px solid var(--success); }

        .security-note {
            text-align: center; font-size: 11.5px; color: var(--text-muted); margin-top: 24px;
            padding-top: 16px; border-top: 1px solid var(--border);
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="forgot-card">
        <div class="forgot-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h2>Lupa Password Admin</h2>
        <p class="subtitle">Masukkan email pemulihan yang sudah di-setting oleh admin di panel Settings untuk menerima kode verifikasi.</p>

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.password.send-code') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Pemulihan</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email pemulihan" required value="{{ old('email') }}" autofocus>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-send me-2"></i>Kirim Kode Verifikasi
            </button>
        </form>

        <a href="{{ route('admin.login') }}" class="back-link">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
        </a>

        <div class="security-note">
            <i class="bi bi-info-circle me-1"></i> Email pemulihan bisa diubah di <strong>Settings → Security & Recovery</strong>
        </div>
    </div>
</body>
</html>
