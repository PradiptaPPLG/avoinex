<?php $__env->startSection('page-title', 'In-Flight Meals'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Meal Catalog</h4>
    <a href="<?php echo e(route('admin.meals.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add New Meal
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3" style="width: 80px;">Image</th>
                        <th class="py-3">Name</th>
                        <th class="py-3">Description</th>
                        <th class="py-3 text-center">Price (IDR)</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-4 py-3">
                            <?php if($meal->image_path): ?>
                                <img src="<?php echo e(asset('storage/' . $meal->image_path)); ?>" alt="<?php echo e($meal->name); ?>" class="rounded shadow-sm" style="width: 48px; height: 48px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width: 48px; height: 48px; color: #adb5bd;">
                                    <i class="bi bi-image" style="font-size: 20px;"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 fw-bold"><?php echo e($meal->name); ?></td>
                        <td class="py-3 text-muted small" style="max-width: 250px;">
                            <?php echo e(Str::limit($meal->description, 50)); ?>

                        </td>
                        <td class="py-3 text-center fw-semibold text-primary">
                            Rp <?php echo e(number_format($meal->price_usd * config('app.usd_to_idr', 15000), 0, ',', '.')); ?>

                        </td>
                        <td class="py-3 text-center">
                            <?php if($meal->is_active): ?>
                                <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <a href="<?php echo e(route('admin.meals.edit', $meal->id)); ?>" class="btn btn-sm btn-info" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="<?php echo e(route('admin.meals.destroy', $meal->id)); ?>" method="POST" class="d-inline-block">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="confirmDelete(event, this.form, 'This will permanently delete the meal.')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-3"></i>
                            No meals found. Start by adding a new one!
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <?php echo e($meals->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/meals/index.blade.php ENDPATH**/ ?>