<?php $__env->startSection('title', 'Coupons & Deals'); ?>
<?php $__env->startSection('page-title', 'Coupons Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Coupons & Promo Codes</h4>
        <p class="text-muted small mb-0">Create and manage discount codes for your customers.</p>
    </div>
    <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>New Coupon
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Code</th>
                        <th>Title & Type</th>
                        <th>Value</th>
                        <th>Validity</th>
                        <th>Usage</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-4">
                            <code class="bg-light px-2 py-1 rounded text-primary fw-bold"><?php echo e($coupon->code); ?></code>
                        </td>
                        <td>
                            <div class="fw-bold text-dark"><?php echo e($coupon->title); ?></div>
                            <div class="text-muted small">
                                <?php if($coupon->discount_type == 'percentage'): ?>
                                    Percentage Discount
                                <?php else: ?>
                                    Fixed Amount Discount
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark fw-bold">
                                <?php if($coupon->discount_type == 'percentage'): ?>
                                    <?php echo e(number_format($coupon->discount_value, 0)); ?>%
                                <?php else: ?>
                                    Rp <?php echo e(number_format($coupon->discount_value, 0, ',', '.')); ?>

                                <?php endif; ?>
                            </div>
                            <div class="text-muted small">Min. Spend: Rp <?php echo e(number_format($coupon->min_spend, 0, ',', '.')); ?></div>
                        </td>
                        <td>
                            <div class="small">
                                <span class="text-muted">From:</span> <?php echo e($coupon->start_date->format('d M Y')); ?><br>
                                <span class="text-muted">To:</span> <?php echo e($coupon->end_date->format('d M Y')); ?>

                            </div>
                        </td>
                        <td>
                            <div class="progress mb-1" style="height: 4px; width: 100px;">
                                <?php 
                                    $percent = $coupon->usage_limit ? ($coupon->used_count / $coupon->usage_limit) * 100 : 0;
                                ?>
                                <div class="progress-bar" role="progressbar" style="width: <?php echo e($percent); ?>%"></div>
                            </div>
                            <div class="small text-muted"><?php echo e($coupon->used_count); ?> / <?php echo e($coupon->usage_limit ?? '∞'); ?> used</div>
                        </td>
                        <td>
                            <?php
                                $now = now();
                                $isActive = $coupon->is_active && $now->between($coupon->start_date, $coupon->end_date);
                            ?>
                            <?php if($isActive): ?>
                                <span class="badge bg-success">Active</span>
                            <?php elseif(!$coupon->is_active): ?>
                                <span class="badge bg-danger">Disabled</span>
                            <?php elseif($now->lt($coupon->start_date)): ?>
                                <span class="badge bg-warning text-dark">Upcoming</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Expired</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('admin.coupons.edit', $coupon->id)); ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.coupons.destroy', $coupon->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-ticket-perforated display-4 mb-3 d-block"></i>
                                <p>No coupons found.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/coupons/index.blade.php ENDPATH**/ ?>