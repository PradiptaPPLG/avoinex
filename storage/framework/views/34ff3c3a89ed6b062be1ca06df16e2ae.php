<?php $__env->startSection('title', 'Manufacturer Management'); ?>
<?php $__env->startSection('page-title', 'Aircraft Manufacturers'); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-building text-primary"></i>
            <h5 class="mb-0">Manufacturer Registry</h5>
            <span class="badge bg-primary ms-1"><?php echo e($manufacturers->total()); ?> manufacturers</span>
        </div>
        <a href="<?php echo e(route('admin.manufacturers.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Manufacturer
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Founded Year</th>
                        <th>Aircraft Count</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $manufacturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mfr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>    
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 34px; height: 34px; background: var(--primary-light); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 14px;">
                                    <i class="bi bi-building"></i>
                                </div>
                                <strong><?php echo e($mfr->name); ?></strong>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?php echo e($mfr->country->country_name ?? $mfr->country_code); ?></span>
                        </td>
                        <td style="font-family:'JetBrains Mono',monospace; font-size: 13px;"><?php echo e($mfr->founded_year ?? '—'); ?></td>
                        <td>
                            <span class="badge bg-info"><?php echo e($mfr->aircrafts->count()); ?> models</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('admin.manufacturers.edit', $mfr->aircraft_manufacturer_id)); ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.manufacturers.destroy', $mfr->aircraft_manufacturer_id)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="confirmDelete(event, this.closest('form'), 'Delete manufacturer <?php echo e($mfr->name); ?>?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-building" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No manufacturers found</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($manufacturers->hasPages()): ?>
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            <?php echo e($manufacturers->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/manufacturers/index.blade.php ENDPATH**/ ?>