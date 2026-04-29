<?php $__env->startSection('title', 'Hero Banners'); ?>
<?php $__env->startSection('page-title', 'Promotional Banners'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Hero Banners</h4>
        <p class="text-muted small mb-0">Manage promotional banners for the homepage carousel.</p>
    </div>
    <a href="<?php echo e(route('admin.banners.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add New Banner
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">Order</th>
                        <th>Banner Image</th>
                        <th>Title & Details</th>
                        <th>Link URL</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-secondary text-dark"><?php echo e($banner->order); ?></span>
                        </td>
                        <td>
                            <div class="rounded-3 overflow-hidden" style="width: 120px; height: 60px;">
                                <img src="<?php echo e(asset('storage/' . $banner->image_path)); ?>" alt="<?php echo e($banner->title); ?>" class="w-100 h-100 object-fit-cover">
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark"><?php echo e($banner->title); ?></div>
                            <div class="text-muted small"><?php echo e($banner->subtitle ?? 'No subtitle'); ?></div>
                        </td>
                        <td>
                            <?php if($banner->link_url): ?>
                                <a href="<?php echo e($banner->link_url); ?>" target="_blank" class="text-info text-decoration-none small">
                                    <i class="bi bi-link-45deg me-1"></i>View Link
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($banner->is_active): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid var(--border); box-shadow: none;">
                                    <i class="bi bi-three-dots-vertical text-secondary"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border: 1px solid var(--border); border-radius: 8px; font-size: 13px;">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('admin.banners.edit', $banner->id)); ?>">
                                            <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="<?php echo e(route('admin.banners.destroy', $banner->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(event, this.closest('form'), 'Delete this banner?')">
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
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-images display-4 mb-3 d-block"></i>
                                <p class="mb-0">No banners found. Start by adding a new one!</p>
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

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>