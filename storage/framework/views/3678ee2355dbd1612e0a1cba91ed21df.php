<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-ticket-perforated"></i> My Bookings</h4>
        </div>
        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-1"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-1"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($bookings->isEmpty()): ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> You have no bookings yet.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Booking Code</th>
                                <th>Booking Date</th>
                                <th>Flight Number</th>
                                <th>Route</th>
                                <th>Flight Date</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><strong><?php echo e($booking->booking_code); ?></strong></td>
                                <td><?php echo e($booking->created_at->format('d M Y H:i')); ?></td>
                                <td><?php echo e($booking->flightInstance->schedule->flight_number); ?></td>
                                <td>
                                    <?php echo e($booking->flightInstance->schedule->originAirport->city); ?> (<?php echo e($booking->flightInstance->schedule->originAirport->iata_code); ?>)
                                    →
                                    <?php echo e($booking->flightInstance->schedule->destinationAirport->city); ?> (<?php echo e($booking->flightInstance->schedule->destinationAirport->iata_code); ?>)
                                </td>
                                <td><?php echo e($booking->flightInstance->flight_date->format('d M Y')); ?></td>
                                <td>
                                    <div>Rp <?php echo e(number_format($booking->total_price_usd, 0, ',', '.')); ?></div>
                                    <?php if($booking->bookingSeats->sum('baggage_weight') > 0): ?>
                                        <div class="small text-muted"><i class="bi bi-suitcase"></i> Includes Baggage</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    
                                    <?php if($booking->booking_status === 'confirmed'): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Confirmed</span>
                                    <?php elseif($booking->booking_status === 'refund_requested'): ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Refund Pending</span>
                                    <?php elseif($booking->booking_status === 'cancelled' && $booking->payment_status === 'refunded'): ?>
                                        <span class="badge bg-info"><i class="bi bi-arrow-counterclockwise me-1"></i>Refunded</span>
                                        <?php if($booking->refund_amount_usd): ?>
                                            <div class="small text-success mt-1">
                                                <i class="bi bi-cash-coin"></i> Rp <?php echo e(number_format($booking->refund_amount_usd, 0, ',', '.')); ?>

                                            </div>
                                        <?php endif; ?>
                                    <?php elseif($booking->booking_status === 'cancelled'): ?>
                                        <span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i>Cancelled</span>
                                    <?php elseif($booking->payment_status === 'refund_rejected'): ?>
                                        <span class="badge bg-danger"><i class="bi bi-x-octagon me-1"></i>Refund Rejected</span>
                                        <?php if($booking->refund_admin_notes): ?>
                                            <div class="small text-muted mt-1" title="<?php echo e($booking->refund_admin_notes); ?>">
                                                <i class="bi bi-chat-left-text"></i> <?php echo e(Str::limit($booking->refund_admin_notes, 30)); ?>

                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="badge bg-warning"><i class="bi bi-clock me-1"></i><?php echo e(ucfirst($booking->booking_status)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-gear-fill me-1"></i> Atur
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('booking.confirmation', $booking->booking_id)); ?>">
                                                    <i class="bi bi-eye me-2"></i> Lihat Detail
                                                </a>
                                            </li>

                                            
                                            <?php if($booking->booking_status === 'confirmed'): ?>
                                                <li>
                                                    <a class="dropdown-item text-success" href="<?php echo e(route('booking.ticket', $booking->booking_id)); ?>" target="_blank">
                                                        <i class="bi bi-file-earmark-pdf me-2"></i> Download E-Ticket
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            
                                            <?php if($booking->canRequestRefund()): ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-warning"
                                                        data-bs-toggle="modal" data-bs-target="#refundModal<?php echo e($booking->booking_id); ?>">
                                                        <i class="bi bi-arrow-counterclockwise me-2"></i> Ajukan Refund
                                                    </button>
                                                </li>
                                            <?php endif; ?>

                                            
                                            <?php if($booking->canCancel()): ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="<?php echo e(route('booking.cancel', $booking->booking_id)); ?>" method="POST" id="cancelForm<?php echo e($booking->booking_id); ?>" class="d-none">
                                                        <?php echo csrf_field(); ?>
                                                    </form>
                                                    <a class="dropdown-item text-danger" href="javascript:void(0)" 
                                                       onclick="if(confirm('Yakin ingin membatalkan booking ini?')) document.getElementById('cancelForm<?php echo e($booking->booking_id); ?>').submit();">
                                                        <i class="bi bi-x-circle me-2"></i> Batalkan Pesanan
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            
                                            <?php if($booking->booking_status === 'refund_requested'): ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <span class="dropdown-item-text small text-muted">
                                                        <i class="bi bi-clock-history me-2"></i> Refund sedang diproses...
                                                    </span>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($booking->canRequestRefund()): ?>
    <div class="modal fade" id="refundModal<?php echo e($booking->booking_id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="<?php echo e(route('booking.refund.request', $booking->booking_id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title"><i class="bi bi-arrow-counterclockwise me-2"></i>Permintaan Refund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Booking:</strong> <?php echo e($booking->booking_code); ?><br>
                            <strong>Total Bayar:</strong> Rp <?php echo e(number_format($booking->total_price_usd, 0, ',', '.')); ?>

                        </div>

                        <div class="alert alert-light border mb-3">
                            <small>
                                <i class="bi bi-exclamation-triangle text-warning me-1"></i>
                                Permintaan refund akan ditinjau oleh tim kami dalam <strong>1–3 hari kerja</strong>.
                                Jumlah refund yang dikembalikan akan ditentukan berdasarkan kebijakan pembatalan yang berlaku.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="refund_reason_<?php echo e($booking->booking_id); ?>" class="form-label fw-bold">
                                Alasan Refund <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" name="refund_reason"
                                id="refund_reason_<?php echo e($booking->booking_id); ?>"
                                rows="4" required
                                placeholder="Contoh: Perubahan jadwal perjalanan, keadaan darurat, dll."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-send me-1"></i> Kirim Permintaan Refund
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/booking/index.blade.php ENDPATH**/ ?>