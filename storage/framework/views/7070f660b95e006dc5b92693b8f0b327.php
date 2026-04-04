<?php $__env->startSection('title', 'Site Settings'); ?>
<?php $__env->startSection('page-title', 'Site Settings'); ?>

<?php $__env->startSection('content'); ?>

<form action="<?php echo e(route('admin.settings.update')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1" style="font-weight: 800; font-size: 20px;">Website Settings</h4>
            <p class="text-muted mb-0" style="font-size: 13px;">Kelola informasi yang ditampilkan di footer dan halaman publik website.</p>
        </div>
        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-check-lg"></i> Save All Changes
        </button>
    </div>

    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $groupInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-3">
                <div style="width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px;
                    <?php if($groupKey === 'social'): ?> background: rgba(59,130,246,0.1); color: #3B82F6;
                    <?php elseif($groupKey === 'contact'): ?> background: rgba(13,175,122,0.1); color: #0DAF7A;
                    <?php else: ?> background: rgba(245,158,11,0.1); color: #D97706;
                    <?php endif; ?>">
                    <i class="bi <?php echo e($groupInfo['icon']); ?>"></i>
                </div>
                <div>
                    <h5 class="mb-0"><?php echo e($groupInfo['label']); ?></h5>
                    <small class="text-muted"><?php echo e($groupInfo['description']); ?></small>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <?php if(isset($settings[$groupKey])): ?>
                        <?php $__currentLoopData = $settings[$groupKey]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="<?php echo e($setting->type === 'textarea' ? 'col-12' : 'col-md-6'); ?>">
                                <label class="form-label d-flex align-items-center gap-2">
                                    <?php if($groupKey === 'social'): ?>
                                        <?php
                                            $iconMap = [
                                                'social_instagram' => 'bi-instagram',
                                                'social_facebook' => 'bi-facebook',
                                                'social_twitter' => 'bi-twitter-x',
                                                'social_youtube' => 'bi-youtube',
                                                'social_tiktok' => 'bi-tiktok',
                                                'social_whatsapp' => 'bi-whatsapp',
                                            ];
                                        ?>
                                        <i class="bi <?php echo e($iconMap[$setting->key] ?? 'bi-link-45deg'); ?>" style="font-size: 15px;"></i>
                                    <?php elseif($groupKey === 'contact'): ?>
                                        <?php
                                            $contactIconMap = [
                                                'contact_email' => 'bi-envelope-fill',
                                                'contact_phone' => 'bi-telephone-fill',
                                                'contact_address' => 'bi-geo-alt-fill',
                                            ];
                                        ?>
                                        <i class="bi <?php echo e($contactIconMap[$setting->key] ?? 'bi-info-circle'); ?>" style="font-size: 14px;"></i>
                                    <?php endif; ?>
                                    <?php echo e($setting->label); ?>

                                </label>

                                <?php if($setting->type === 'textarea'): ?>
                                    <textarea class="form-control" name="<?php echo e($setting->key); ?>" rows="2" placeholder="<?php echo e($setting->label); ?>"><?php echo e($setting->value); ?></textarea>
                                <?php else: ?>
                                    <input type="<?php echo e($setting->type === 'email' ? 'email' : 'text'); ?>" 
                                           class="form-control" 
                                           name="<?php echo e($setting->key); ?>" 
                                           value="<?php echo e($setting->value); ?>" 
                                           placeholder="<?php echo e($setting->label); ?>">
                                <?php endif; ?>

                                <?php if($setting->type === 'url'): ?>
                                    <small class="text-muted d-block mt-1">
                                        <i class="bi bi-info-circle" style="font-size: 10px;"></i> 
                                        Masukkan URL lengkap (contoh: https://instagram.com/avoinex)
                                    </small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="d-flex justify-content-end mb-4">
        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 px-4">
            <i class="bi bi-check-lg"></i> Save All Changes
        </button>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>