<?php $__env->startSection('title', 'Booking Management'); ?>
<?php $__env->startSection('page-title', 'Booking Management'); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-ticket-perforated-fill text-primary"></i>
            <h5 class="mb-0">Reservations</h5>
        </div>
        <form method="GET" class="d-flex align-items-center gap-2">
            <div class="d-flex gap-1">
                <a href="?status=" class="btn btn-sm <?php echo e(!request('status') ? 'btn-primary' : 'btn-secondary'); ?>">All</a>
                <a href="?status=pending" class="btn btn-sm <?php echo e(request('status') == 'pending' ? 'btn-primary' : 'btn-secondary'); ?>">Pending</a>
                <a href="?status=confirmed" class="btn btn-sm <?php echo e(request('status') == 'confirmed' ? 'btn-primary' : 'btn-secondary'); ?>">Confirmed</a>
                <a href="?status=cancelled" class="btn btn-sm <?php echo e(request('status') == 'cancelled' ? 'btn-primary' : 'btn-secondary'); ?>">Cancelled</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Booking Code</th>
                        <th>Passenger</th>
                        <th>Flight</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Booking Status</th>
                        <th>Payment</th>
                        <th style="width: 70px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <span style="font-family:'JetBrains Mono',monospace; font-size: 13px; font-weight: 600; color: var(--primary);">
                                <?php echo e($booking->booking_code); ?>

                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 600; font-size: 13.5px;"><?php echo e($booking->client->first_name); ?> <?php echo e($booking->client->last_name); ?></div>
                            <div style="font-size: 12px; color: var(--text-muted);"><?php echo e($booking->client->email); ?></div>
                        </td>
                        <td>
                            <span style="font-weight: 600; font-family:'JetBrains Mono',monospace; font-size: 13px;">
                                <?php echo e($booking->flightInstance->schedule->flight_number); ?>

                            </span>
                        </td>
                        <td style="color: var(--text-secondary); font-size: 13px;"><?php echo e($booking->created_at->format('d M Y')); ?></td>
                        <td>
                            <span style="font-weight: 700; font-size: 14px;">Rp <?php echo e(number_format($booking->total_price_usd, 0, ',', '.')); ?></span>
                        </td>
                        <td>
                            <?php if($booking->booking_status == 'confirmed'): ?>
                                <span class="badge bg-success">Confirmed</span>
                            <?php elseif($booking->booking_status == 'cancelled'): ?>
                                <span class="badge bg-danger">Cancelled</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($booking->payment_status == 'paid'): ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Paid</span>
                            <?php else: ?>
                                <span class="badge bg-warning"><i class="bi bi-clock me-1"></i>Unpaid</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.bookings.show', $booking->booking_id)); ?>" class="btn btn-sm btn-info" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-ticket-perforated" style="font-size: 32px; color: var(--border); display: block; margin-bottom: 12px;"></i>
                            <span style="color: var(--text-muted); font-weight: 500;">No bookings found</span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($bookings->hasPages()): ?>
        <div class="d-flex justify-content-end px-4 py-3" style="border-top: 1px solid var(--border);">
            <?php echo e($bookings->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>