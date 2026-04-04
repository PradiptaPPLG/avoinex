<!DOCTYPE html>
<html>
<head>
    <title>Reset Password Admin Avoinex</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
        }
        .logo {
            font-size: 24px;
            font-weight: 800;
            color: #0066CC;
            margin-bottom: 20px;
        }
        h2 {
            color: #111;
            font-size: 20px;
            margin-bottom: 15px;
        }
        p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .otp-box {
            background: #e8f1fb;
            color: #0066CC;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 10px;
            padding: 15px 20px;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .footer {
            font-size: 12px;
            color: #999;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">AVOINEX</div>
        <h2>Reset Password Admin</h2>
        <p>Anda menerima email ini karena ada permintaan untuk mereset password akun Admin Avoinex Anda. Berikut adalah kode verifikasi Anda (berlaku 15 menit):</p>
        
        <div class="otp-box">
            <?php echo e($otpCode); ?>

        </div>
        
        <p>Jika Anda tidak meminta reset password, abaikan email ini dan pastikan keamanan akun Anda terjaga.</p>
        
        <div class="footer">
            &copy; <?php echo e(date('Y')); ?> Avoinex. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/emails/admin_reset_password.blade.php ENDPATH**/ ?>