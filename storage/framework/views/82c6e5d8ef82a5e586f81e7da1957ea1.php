<?php $__env->startSection('title', 'Airport Management'); ?>
<?php $__env->startSection('page-title', 'Airports'); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-geo-alt-fill text-primary"></i>
            <h5 class="mb-0">Airport Registry</h5>
            <span class="badge bg-primary ms-1"><?php echo e($airports->total()); ?> airports</span>
        </div>
        <a href="<?php echo e(route('admin.airports.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Airport
        </a>
    </div>
    <div class="card-body p-0">    <div class="p-3 border-bottom bg-light" id="bulkActions" style="display: none;">
        <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center" onclick="submitBulkDelete('<?php echo e(route('admin.airports.bulk_delete')); ?>')" id="btnBulkDelete">
            <i class="bi bi-check-all me-1"></i> Pilih (<span id="bulkCount">0</span>) - Hapus Selected
        </button>
    </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                        <th>IATA Code</th>
                        <th>Airport Name</th>
                        <th>City</th>
                        <th>Country</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $airports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $airport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="width: 40px;"><input type="checkbox" class="form-check-input row-checkbox" value="<?php echo e($airport->iata_code); ?>"></td>
                        <td>
                            <span style="font-family:'JetBrains Mono',monospace; font-size: 14px; font-weight: 700; background: var(--surface-2); padding: 3px 10px; border-radius: 6px; border: 1px solid var(--border);"><?php echo e($airport->iata_code); ?></span>
                        </td>
                        <td style="font-weight: 600;"><?php echo e($airport->airport_name); ?></td>
                        <td style="color: var(--text-secondary);"><?php echo e($airport->city); ?></td>
                        <td>
                            <span class="badge bg-secondary"><?php echo e($airport->country->country_name ?? $airport->country_code); ?></span>
                        </td>
                        <td>
                                                        <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid var(--border); box-shadow: none;">
                                    <i class="bi bi-three-dots-vertical text-secondary"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border: 1px solid var(--border); border-radius: 8px; font-size: 13px;">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('admin.airports.edit', $airport->airport_id)); ?>">
                                            <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="<?php echo e(route('admin.airports.destroy', $airport->airport_id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(event, this.closest('form'), 'Delete airport <?php echo e($airport->iata_code); ?>?')">
                                                <i class="bi bi-trash me-2 text-danger"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
<td colspan="5" class="text-center py-5">
                            <i class="bi bi-geo-alt" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No airports found</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($airports->hasPages()): ?>
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            <?php echo e($airports->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>







<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/airports/index.blade.php ENDPATH**/ ?>