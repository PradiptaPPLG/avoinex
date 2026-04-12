<?php $__env->startSection('title', 'Flight Management'); ?>
<?php $__env->startSection('page-title', 'Flight Instances'); ?>

<?php $__env->startSection('content'); ?>

<div class="card avx-reveal">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-airplane-engines-fill text-primary"></i>
            <h5 class="mb-0">Flight Instances</h5>
        </div>
        <a href="<?php echo e(route('admin.flights.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New Flight
        </a>
    </div>
    <div class="card-body p-0">    <div class="p-3 border-bottom bg-light" id="bulkActions" style="display: none;">
        <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center" onclick="submitBulkDelete('<?php echo e(route('admin.flights.bulk_delete')); ?>')" id="btnBulkDelete">
            <i class="bi bi-check-all me-1"></i> Pilih (<span id="bulkCount">0</span>) - Hapus Selected
        </button>
    </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" class="form-check-input" id="selectAll"></th>
                        <th>Flight No.</th>
                        <th>Aircraft</th>
                        <th>Date</th>
                        <th>Seat Availability</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $flights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="width: 40px;"><input type="checkbox" class="form-check-input row-checkbox" value="<?php echo e($flight->flight_instance_id); ?>"></td>
                        <td>
                            <span style="font-family:'JetBrains Mono',monospace; font-size: 14px; font-weight: 700; color: var(--text-primary);">
                                <?php echo e($flight->schedule->flight_number ?? 'N/A'); ?>

                            </span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; background: var(--surface-2); border: 1px solid var(--border); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 14px;">
                                    <i class="bi bi-airplane"></i>
                                </div>
                                <span style="font-family:'JetBrains Mono',monospace; font-size: 13px; font-weight: 600;"><?php echo e($flight->aircraftInstance->registration_number ?? 'N/A'); ?></span>
                            </div>
                        </td>
                        <td style="font-weight: 600; font-size: 13.5px;"><?php echo e($flight->flight_date->format('d M Y')); ?></td>
                        <td>
                            <?php
                                $totalSeats = $flight->aircraftInstance->aircraft->total_seats ?? 0;
                                $bookedSeats = \App\Models\BookingSeat::whereHas('booking', function($query) use ($flight) {
                                    $query->where('flight_instance_id', $flight->flight_instance_id)
                                          ->whereIn('booking_status', ['confirmed', 'pending']);
                                })->count();
                                $availableSeats = $totalSeats - $bookedSeats;
                                $pct = $totalSeats > 0 ? round(($bookedSeats / $totalSeats) * 100) : 0;
                            ?>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex: 1; max-width: 120px; height: 6px; background: var(--surface-3); border-radius: 4px; overflow: hidden;">
                                    <div style="height: 100%; width: <?php echo e($pct); ?>%; background: <?php echo e($pct >= 90 ? 'var(--danger)' : ($pct >= 70 ? 'var(--warning)' : 'var(--success)')); ?>; border-radius: 4px; transition: width 0.3s;"></div>
                                </div>
                                <span style="font-family:'JetBrains Mono',monospace; font-size: 12px; color: var(--text-secondary);"><?php echo e($availableSeats); ?>/<?php echo e($totalSeats); ?></span>
                            </div>
                        </td>
                        <td>
                                                        <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid var(--border); box-shadow: none;">
                                    <i class="bi bi-three-dots-vertical text-secondary"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border: 1px solid var(--border); border-radius: 8px; font-size: 13px;">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo e(route('admin.flights.edit', $flight->flight_instance_id)); ?>">
                                            <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="<?php echo e(route('admin.flights.destroy', $flight->flight_instance_id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button" class="dropdown-item text-danger" onclick="confirmDelete(event, this.closest('form'), 'Delete this flight instance?')">
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
                            <i class="bi bi-airplane-engines" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No flight instances found</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($flights->hasPages()): ?>
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            <?php echo e($flights->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>






<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/flights/index.blade.php ENDPATH**/ ?>