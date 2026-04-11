<?php $__env->startSection('page-title', 'Flash Sales'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Manage Flash Sales</h4>
    <a href="<?php echo e(route('admin.flash_sales.create')); ?>" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-lg me-2"></i> Create Flash Sale
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">    <div class="p-3 border-bottom bg-light" id="bulkActions" style="display: none;">
        <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center" onclick="submitBulkDelete('<?php echo e(route('admin.flash_sales.bulk_delete')); ?>')" id="btnBulkDelete">
            <i class="bi bi-check-all me-1"></i> Pilih (<span id="bulkCount">0</span>) - Hapus Selected
        </button>
    </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                        <th class="px-4 py-3">Flight & Route</th>
                        <th class="py-3">Discount</th>
                        <th class="py-3">Period</th>
                        <th class="py-3">Seats</th>
                        <th class="py-3 text-center">Priority</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $flashSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold"><?php echo e($sale->flightInstance->flightInstanceCode()); ?></div>
                                <small class="text-muted">
                                    <?php echo e($sale->flightInstance->schedule->originAirport->iata_code); ?> &rarr; <?php echo e($sale->flightInstance->schedule->destinationAirport->iata_code); ?> 
                                    (<?php echo e($sale->flightInstance->flight_date->format('d M y')); ?>)
                                </small>
                            </td>
                            <td class="py-3 fw-semibold text-primary">
                                <?php if($sale->discount_type == 'percentage'): ?>
                                    <?php echo e($sale->discount_value); ?>% OFF
                                <?php else: ?>
                                    Rp <?php echo e(number_format($sale->discount_value, 0, ',', '.')); ?> OFF
                                <?php endif; ?>
                            </td>
                            <td class="py-3">
                                <div class="small"><i class="bi bi-clock me-1"></i> <?php echo e($sale->start_time->format('d M H:i')); ?></div>
                                <div class="small text-muted"><i class="bi bi-chevron-right me-1"></i> <?php echo e($sale->end_time->format('d M H:i')); ?></div>
                            </td>
                            <td class="py-3">
                                <div><?php echo e($sale->seats_sold); ?> / <?php echo e($sale->max_seats); ?></div>
                                <div class="progress mt-1" style="height: 4px; width: 80px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo e($sale->max_seats > 0 ? ($sale->seats_sold / $sale->max_seats) * 100 : 0); ?>%"></div>
                                </div>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge bg-secondary rounded-pill px-3"><?php echo e($sale->priority); ?></span>
                            </td>
                            <td class="py-3 text-center">
                                <?php if($sale->is_active && $sale->end_time > now()): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php elseif(!$sale->is_active): ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Expired</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="<?php echo e(route('admin.flash_sales.edit', $sale->id)); ?>" class="btn btn-sm btn-info text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.flash_sales.destroy', $sale->id)); ?>" method="POST" class="d-inline" onsubmit="confirmDelete(event, this, 'Are you sure you want to delete this flash sale? This action cannot be undone.')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                        <td style="width: 40px;"><input type="checkbox" class="form-check-input row-checkbox" value="<?php echo e($item->flash_sale_id); ?>"></td>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-1 d-block mb-3 opacity-50"></i>
                                No flash sales found. Start by creating a new one!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($flashSales->hasPages()): ?>
        <div class="card-footer bg-white border-top-0 pt-3 pb-3 px-4">
            <?php echo e($flashSales->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/flash_sales/index.blade.php ENDPATH**/ ?>