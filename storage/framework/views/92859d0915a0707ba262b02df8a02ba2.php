<?php $__env->startSection('title', 'Edit Schedule'); ?>
<?php $__env->startSection('page-title', 'Edit Schedule'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?php echo e(route('admin.schedules.index')); ?>" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Schedules → Edit #<?php echo e($schedule->schedule_id); ?></div>
</div>

<div class="card" style="max-width: 860px;">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-pencil-square"></i>
            Modify Flight Schedule
        </div>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('admin.schedules.update', $schedule->schedule_id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Flight Number</label>
                    <input type="text" name="flight_number" class="form-control" placeholder="e.g. GA-202" required value="<?php echo e(old('flight_number', $schedule->flight_number)); ?>">
                    <?php $__errorArgs = ['flight_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Airline</label>
                    <select name="airline_code" class="form-control" required>
                        <option value="">— Select Airline —</option>
                        <?php $__currentLoopData = $airlines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $airline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($airline->airline_code); ?>" <?php echo e($schedule->airline_code == $airline->airline_code ? 'selected' : ''); ?>>
                                <?php echo e($airline->airline_code); ?> — <?php echo e($airline->airline_name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['airline_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            
            <div style="background: var(--surface-2); border: 1.5px solid var(--border); border-radius: 10px; padding: 20px; margin-bottom: 24px;">
                <div style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin-bottom: 16px;">Route</div>
                <div class="row g-4 align-items-center">
                    <div class="col-md-5">
                        <label class="form-label">Origin Airport</label>
                        <select name="origin_iata_code" class="form-control" required>
                            <option value="">— Select Airport —</option>
                            <?php $__currentLoopData = $airports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $airport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($airport->iata_code); ?>" <?php echo e($schedule->origin_iata_code == $airport->iata_code ? 'selected' : ''); ?>>
                                    <?php echo e($airport->iata_code); ?> — <?php echo e($airport->city); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['origin_iata_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-2 text-center" style="padding-top: 24px;">
                        <i class="bi bi-arrow-right" style="font-size: 22px; color: var(--primary);"></i>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Destination Airport</label>
                        <select name="destination_iata_code" class="form-control" required>
                            <option value="">— Select Airport —</option>
                            <?php $__currentLoopData = $airports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $airport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($airport->iata_code); ?>" <?php echo e($schedule->destination_iata_code == $airport->iata_code ? 'selected' : ''); ?>>
                                    <?php echo e($airport->iata_code); ?> — <?php echo e($airport->city); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['destination_iata_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Departure Time (GMT)</label>
                    <input type="time" name="departure_time_gmt" class="form-control" required value="<?php echo e(old('departure_time_gmt', substr($schedule->departure_time_gmt, 0, 5))); ?>">
                    <?php $__errorArgs = ['departure_time_gmt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Arrival Time (GMT)</label>
                    <input type="time" name="arrival_time_gmt" class="form-control" required value="<?php echo e(old('arrival_time_gmt', substr($schedule->arrival_time_gmt, 0, 5))); ?>">
                    <?php $__errorArgs = ['arrival_time_gmt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" class="form-control" placeholder="e.g. 150" required value="<?php echo e(old('duration_minutes', $schedule->duration_minutes)); ?>">
                    <?php $__errorArgs = ['duration_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            
            <div class="row g-4 mb-4">
                <?php
                    $exchangeRate = config('app.usd_to_idr', 15000);
                    $priceIdr = round($schedule->base_price_usd * $exchangeRate, 0);
                ?>
                <div class="col-md-4">
                    <label class="form-label">Base Price (IDR)</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 600;">Rp</span>
                        <input type="number" name="base_price_idr" class="form-control rupiah-input" placeholder="0" style="padding-left: 36px;" required value="<?php echo e(old('base_price_idr', $priceIdr)); ?>">
                    </div>
                    <?php $__errorArgs = ['base_price_idr'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Effective From</label>
                    <input type="date" name="effective_from" class="form-control" required value="<?php echo e(old('effective_from', $schedule->effective_from)); ?>">
                    <?php $__errorArgs = ['effective_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Effective To <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                    <input type="date" name="effective_to" class="form-control" value="<?php echo e(old('effective_to', $schedule->effective_to)); ?>">
                    <?php $__errorArgs = ['effective_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Update Schedule
                </button>
                <a href="<?php echo e(route('admin.schedules.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/schedules/edit.blade.php ENDPATH**/ ?>