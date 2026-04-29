<?php $__env->startSection('page-title', 'Destinasi Populer'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Destinasi Populer</h5>
        <a href="<?php echo e(route('admin.featured_destinations.create')); ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Destinasi
        </a>
    </div>
    <div class="card-body p-0">    <div class="p-3 border-bottom bg-light" id="bulkActions" style="display: none;">
        <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center" onclick="submitBulkDelete('<?php echo e(route('admin.featured_destinations.bulk_delete')); ?>')" id="btnBulkDelete">
            <i class="bi bi-check-all me-1"></i> Pilih (<span id="bulkCount">0</span>) - Hapus Selected
        </button>
    </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                        <th>Urutan</th>
                        <th>Gambar</th>
                        <th>Destinasi</th>
                        <th>Trayek</th>
                        <th>Harga Mulai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="width: 40px;"><input type="checkbox" class="form-check-input row-checkbox" value="<?php echo e($dest->id); ?>"></td>
                        <td><?php echo e($dest->sort_order); ?></td>
                        <td>
                            <?php if($dest->image_path): ?>
                            <img src="<?php echo e(asset($dest->image_path)); ?>" alt="<?php echo e($dest->title); ?>" style="width: 80px; height: 50px; object-fit: cover; border-radius: 6px;">
                            <?php else: ?>
                            <div style="width: 80px; height: 50px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">No Image</div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold"><?php echo e($dest->title); ?></td>
                        <td>
                            <span class="badge bg-secondary"><?php echo e($dest->origin_iata); ?></span>
                            <i class="bi bi-arrow-right mx-1 text-muted"></i>
                            <span class="badge bg-primary"><?php echo e($dest->destination_iata); ?></span>
                            <div class="small text-muted mt-1"><?php echo e($dest->date_range); ?></div>
                        </td>
                        <td class="fw-bold text-success">Rp <?php echo e(number_format($dest->starting_price_usd * config('app.usd_to_idr', 15000), 0, ',', '.')); ?></td>
                        <td>
                            <?php if($dest->is_active): ?>
                            <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                            <span class="badge bg-danger">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('admin.featured_destinations.edit', $dest->id)); ?>" class="btn btn-sm btn-info text-white" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.featured_destinations.destroy', $dest->id)); ?>" method="POST" class="d-inline" onsubmit="confirmDelete(event, this, 'Yakin ingin menghapus destinasi ini?')">
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
<td colspan="7" class="text-center py-4 text-muted">Belum ada destinasi populer yang ditambahkan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>







<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/featured_destinations/index.blade.php ENDPATH**/ ?>