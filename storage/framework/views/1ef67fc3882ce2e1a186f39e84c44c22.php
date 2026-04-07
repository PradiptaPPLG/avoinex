<?php $__env->startSection('title', 'Login - Avoinex'); ?>

<?php $__env->startSection('content'); ?>
<div class="avx-login-page">
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-md-5">
                <div class="avx-login-card shadow-lg animate__animated animate__fadeInUp">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Avoinex</h2>
                            <p class="text-muted">Welcome back! Please login to your account.</p>
                        </div>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger mb-4">
                                <i class="bi bi-exclamation-circle me-2"></i> <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(session('success')): ?>
                            <div class="alert alert-success mb-4">
                                <i class="bi bi-check-circle me-2"></i> <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <form action="<?php echo e(route('login.submit')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Email or Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-person text-primary"></i></span>
                                    <input type="text" name="identifier" class="form-control border-start-0" placeholder="Enter your email or phone" required value="<?php echo e(old('identifier')); ?>">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label small fw-bold">Password</label>
                                    <a href="<?php echo e(route('password.forgot')); ?>" class="small text-decoration-none">Forgot Password?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock text-primary"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0" placeholder="Enter your password" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-4">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                            </div>

                            <div class="text-center">
                                <p class="small text-muted mb-0">Don't have an account? <a href="<?php echo e(route('register')); ?>" class="fw-bold text-decoration-none">Create Account</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avx-login-page {
    background: linear-gradient(135deg, #f0f7fc 0%, #e8f4fd 50%, #f5f5f5 100%);
    margin-top: -20px;
    padding-top: 20px;
}

.avx-login-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
}

.form-control:focus {
    box-shadow: 0 0 0 0.25rem rgba(39, 158, 214, 0.1);
    border-color: #279ED6;
}

.btn-primary {
    background: linear-gradient(135deg, #279ED6, #1a7ab5);
    border: none;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(39, 158, 214, 0.3);
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/auth/login.blade.php ENDPATH**/ ?>