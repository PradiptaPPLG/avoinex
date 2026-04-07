<?php $__env->startSection('title', 'Aircraft Management'); ?>
<?php $__env->startSection('page-title', 'Aircraft Management'); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-airplane-fill text-primary"></i>
            <h5 class="mb-0">Fleet Registry</h5>
            <span class="badge bg-primary ms-1"><?php echo e($aircraft->total()); ?> aircraft</span>
        </div>
        <a href="<?php echo e(route('admin.aircraft.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Register Aircraft
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Registration</th>
                        <th>Model</th>
                        <th>Manufacturer</th>
                        <th>Layout</th>
                        <th>Total Seats</th>
                        <th>Business</th>
                        <th>Preferred Zone</th>
                        <th>Economy</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $aircraft; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 34px; height: 34px; background: var(--primary-light); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 14px;">
                                    <i class="bi bi-airplane"></i>
                                </div>
                                <strong style="font-family: 'JetBrains Mono', monospace; font-size: 13px; color: var(--primary);"><?php echo e($item->registration_number); ?></strong>
                            </div>
                        </td>
                        <td style="font-weight: 600;"><?php echo e($item->aircraft_model); ?></td>
                        <td style="color: var(--text-secondary);"><?php echo e($item->manufacturer->name ?? '—'); ?></td>
                        <td>
                            <span class="badge bg-secondary">
                                <i class="bi bi-grid-3x3 me-1" style="font-size: 9px;"></i>
                                <?php echo e($item->seat_columns ?? 6); ?> × <?php echo e($item->seat_rows ?? 30); ?>

                            </span>
                        </td>
                        <td>
                            <span style="font-weight: 700; font-size: 15px;"><?php echo e($item->total_seats); ?></span>
                        </td>
                        <td>
                            <?php if(($item->business_rows ?? 0) > 0): ?>
                                <span class="badge bg-warning"><?php echo e(($item->seat_columns ?? 6) * ($item->business_rows ?? 0)); ?> seats</span>
                            <?php else: ?>
                                <span style="color: var(--text-muted);">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($item->preferred_zone_enabled): ?>
                                <span class="badge bg-info">Rows <?php echo e($item->preferred_zone_start_row); ?>–<?php echo e($item->preferred_zone_end_row); ?></span>
                            <?php else: ?>
                                <span style="color: var(--text-muted);">—</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight: 600;"><?php echo e($item->economy_seats ?? '—'); ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('admin.aircraft.edit', $item->aircraft_id)); ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.aircraft.destroy', $item->aircraft_id)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="confirmDelete(event, this.closest('form'), 'Delete aircraft <?php echo e($item->registration_number); ?>?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="bi bi-airplane" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No aircraft registered</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($aircraft->hasPages()): ?>
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            <?php echo e($aircraft->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/aircraft/index.blade.php ENDPATH**/ ?>