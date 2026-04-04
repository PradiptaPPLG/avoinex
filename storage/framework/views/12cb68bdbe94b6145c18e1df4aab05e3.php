<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Avoinex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0066CC;
            --primary-dark: #004A99;
            --primary-light: #E8F1FB;
            --sidebar-bg: #080F1E;
            --surface: #ffffff;
            --surface-2: #F4F7FC;
            --text-primary: #0D1B2A;
            --text-secondary: #5A6B82;
            --text-muted: #8FA0B5;
            --border: #DDE5F0;
            --success: #0DAF7A;
            --danger: #EF4444;
            --shadow-lg: 0 10px 40px rgba(0,30,80,0.15);
            --radius: 12px;
            --radius-sm: 8px;
        }

        * { box-sizing: border-box; margin: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--sidebar-bg);
            color: var(--text-primary);
        }

        /* ── LEFT PANEL (ambient gradient orbs) ──────────────────────────── */
        .login-left {
            width: 420px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            background-color: #030A1A; /* In-depth dark blue */
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            z-index: 0;
            pointer-events: none;
        }

        .orb-1 {
            width: 350px; height: 350px;
            background: #0066CC; /* Brand Blue */
            top: -100px; left: -100px;
            animation: moveOrb1 18s ease-in-out infinite alternate;
        }

        .orb-2 {
            width: 400px; height: 400px;
            background: #0DAF7A; /* Teal/Success */
            bottom: -150px; right: -150px;
            animation: moveOrb2 22s ease-in-out infinite alternate;
        }

        .orb-3 {
            width: 300px; height: 300px;
            background: #8338EC; /* Purple Accent */
            top: 30%; left: -50px;
            animation: moveOrb3 20s ease-in-out infinite alternate;
        }

        .orb-4 {
            width: 250px; height: 250px;
            background: #3A86FF; /* Bright Blue */
            bottom: 20%; left: 30%;
            animation: moveOrb4 16s ease-in-out infinite alternate;
        }

        @keyframes moveOrb1 {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(200px, 250px) scale(1.2); }
            66% { transform: translate(350px, 50px) scale(0.8); }
            100% { transform: translate(150px, 350px) scale(1.1); }
        }

        @keyframes moveOrb2 {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-250px, -200px) scale(1.1); }
            66% { transform: translate(-400px, 100px) scale(1.3); }
            100% { transform: translate(-150px, -400px) scale(0.9); }
        }

        @keyframes moveOrb3 {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(150px, -250px) scale(1.4); }
            66% { transform: translate(250px, 150px) scale(0.7); }
            100% { transform: translate(50px, -150px) scale(1.2); }
        }

        @keyframes moveOrb4 {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-150px, 200px) scale(1.3); }
            66% { transform: translate(150px, -150px) scale(0.8); }
            100% { transform: translate(-100px, -200px) scale(1.1); }
        }

        .brand-block {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .brand-icon-lg {
            width: 72px; height: 72px;
            background: var(--primary);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 32px;
            margin: 0 auto 24px;
            box-shadow: 0 8px 24px rgba(0,102,204,0.5);
        }

        .brand-block h1 {
            color: white;
            font-weight: 800;
            font-size: 28px;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }

        .brand-block p {
            color: rgba(255,255,255,0.35);
            font-size: 12px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }

        .brand-features {
            margin-top: 48px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .brand-feature {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255,255,255,0.45);
            font-size: 13px;
            font-weight: 500;
        }

        .brand-feature i {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: rgba(255,255,255,0.5);
            flex-shrink: 0;
        }

        /* ── RIGHT PANEL (form) ──────────────────────────── */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--surface-2);
            padding: 48px;
            position: relative;
        }

        .back-home-btn {
            position: absolute;
            top: 32px;
            right: 48px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 20px;
            background: var(--surface);
            border: 1px solid var(--border);
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .back-home-btn:hover {
            color: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(0,102,204,0.15);
            transform: translateX(-3px);
        }

        @keyframes cardEntrance3D {
            0% {
                opacity: 0;
                transform: perspective(1000px) translateY(40px) rotateX(-10deg) scale(0.95);
            }
            100% {
                opacity: 1;
                transform: perspective(1000px) translateY(0) rotateX(0deg) scale(1);
            }
        }

        @keyframes fadeUpStagger {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 40px;
            opacity: 0;
            animation: cardEntrance3D 0.9s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            animation-delay: 0.1s;
        }

        .login-card h2, 
        .login-card .subtitle, 
        .login-card .alert,
        .login-card .mb-3, 
        .login-card .mb-4, 
        .login-card .btn-login, 
        .login-card .login-footer {
            opacity: 0;
            animation: fadeUpStagger 0.7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        .login-card h2 { animation-delay: 0.3s; }
        .login-card .subtitle { animation-delay: 0.4s; }
        .login-card .alert { animation-delay: 0.45s; }
        .login-card .mb-3 { animation-delay: 0.5s; }
        .login-card .mb-4 { animation-delay: 0.55s; }
        .login-card .btn-login { animation-delay: 0.6s; }
        .login-card .login-footer { animation-delay: 0.75s; }

        /* Left Panel Staggered Animation */
        .brand-icon-lg, 
        .brand-block h1, 
        .brand-block p, 
        .brand-feature {
            opacity: 0;
            animation: fadeUpStagger 0.7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        .brand-icon-lg { animation-delay: 0.2s; }
        .brand-block h1 { animation-delay: 0.3s; }
        .brand-block p { animation-delay: 0.4s; }
        .brand-feature:nth-child(1) { animation-delay: 0.5s; }
        .brand-feature:nth-child(2) { animation-delay: 0.6s; }
        .brand-feature:nth-child(3) { animation-delay: 0.7s; }
        .brand-feature:nth-child(4) { animation-delay: 0.8s; }

        .login-card h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .login-card .subtitle {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 32px;
        }

        .form-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: 0.02em;
            margin-bottom: 6px;
        }

        .form-control {
            font-size: 13.5px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 11px 14px;
            color: var(--text-primary);
            background: var(--surface);
            transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0,102,204,0.12);
            outline: none;
        }

        .form-control::placeholder { color: var(--text-muted); }

        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 15px;
        }

        .input-icon-wrap .form-control {
            padding-left: 42px;
        }

        .btn-login {
            width: 100%;
            background: var(--primary);
            border: none;
            color: white;
            padding: 12px;
            font-size: 14px;
            font-weight: 700;
            border-radius: var(--radius-sm);
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            box-shadow: 0 4px 16px rgba(0,102,204,0.4);
        }

        .alert {
            border-radius: var(--radius-sm);
            border: none;
            font-size: 13px;
            font-weight: 500;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: rgba(13,175,122,0.10);
            color: #065F46;
            border-left: 3px solid var(--success);
        }

        .alert-danger {
            background: rgba(239,68,68,0.08);
            color: #991B1B;
            border-left: 3px solid var(--danger);
        }

        .error-text {
            font-size: 12px;
            color: var(--danger);
            margin-top: 5px;
        }

        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .login-left { width: 100%; padding: 32px 24px; }
            .brand-features { display: none; }
            .login-right { padding: 32px 24px; }
            .back-home-btn { top: 16px; right: 16px; }
        }
    </style>
</head>
<body>

    <!-- LEFT BRAND PANEL -->
    <div class="login-left">
        <!-- Ambient Orbs -->
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>

        <div class="brand-block">
            <div class="brand-icon-lg">
                <i class="bi bi-airplane-fill"></i>
            </div>
            <h1>AVOINEX</h1>
            <p>Admin Portal</p>
        </div>

        <div class="brand-features">
            <div class="brand-feature">
                <i class="bi bi-shield-lock"></i>
                Secure admin access
            </div>
            <div class="brand-feature">
                <i class="bi bi-speedometer2"></i>
                Real-time dashboard
            </div>
            <div class="brand-feature">
                <i class="bi bi-airplane-engines"></i>
                Fleet & operations management
            </div>
            <div class="brand-feature">
                <i class="bi bi-ticket-perforated"></i>
                Booking & revenue tracking
            </div>
        </div>
    </div>

    <!-- RIGHT LOGIN FORM -->
    <div class="login-right">
        
        <!-- Back to Website Button -->
        <a href="<?php echo e(url('/')); ?>" class="back-home-btn">
            <i class="bi bi-arrow-left"></i> Back to Website
        </a>

        <div class="login-card">
            <h2>Welcome back</h2>
            <p class="subtitle">Sign in to access the admin panel</p>

            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i><?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.login.submit')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" class="form-control" placeholder="admin@avoinex.com" value="<?php echo e(old('email')); ?>" required autofocus>
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-text"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label mb-0">Password</label>
                        <a href="<?php echo e(route('admin.password.forgot')); ?>" style="font-size: 11.5px; color: var(--primary); text-decoration: none; font-weight: 600;">Lupa Password?</a>
                    </div>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-text"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                </button>
            </form>

            <div class="login-footer">
                <i class="bi bi-shield-check me-1"></i> Protected admin area — Avoinex © <?php echo e(date('Y')); ?>

            </div>
        </div>
    </div>

</body>
</html><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/login.blade.php ENDPATH**/ ?>