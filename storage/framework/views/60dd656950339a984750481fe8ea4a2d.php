<?php $__env->startSection('title', 'Edit Flight Instance'); ?>
<?php $__env->startSection('page-title', 'Edit Flight Instance'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?php echo e(route('admin.flights.index')); ?>" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Flight Instances → Edit</div>
    <span style="font-family:'JetBrains Mono',monospace; font-size: 12px; font-weight: 700; color: var(--primary); background: var(--primary-light); padding: 4px 12px; border-radius: 6px; border: 1px solid rgba(0,102,204,0.2);">
        #<?php echo e($flight->flight_instance_id); ?>

    </span>
</div>

<div class="card" style="max-width: 680px;">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-pencil-square"></i>
            Edit Flight Instance
        </div>
    </div>
    <div class="card-body">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger mb-4">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>Please fix the following errors:</strong>
                </div>
                <ul class="mb-0 ps-4 mt-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.flights.update', $flight->flight_instance_id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="d-flex flex-column gap-4">
                <div>
                    <label class="form-label">Schedule</label>
                    <select name="schedule_id" class="form-control" required>
                        <option value="">— Select Schedule —</option>
                        <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($schedule->schedule_id); ?>" <?php echo e(old('schedule_id', $flight->schedule_id) == $schedule->schedule_id ? 'selected' : ''); ?>>
                                <?php echo e($schedule->flight_number); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Aircraft Instance</label>
                    <select name="aircraft_instance_id" class="form-control" required>
                        <option value="">— Select Aircraft —</option>
                        <?php $__currentLoopData = $aircraftInstances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($instance->aircraft_instance_id); ?>" <?php echo e(old('aircraft_instance_id', $flight->aircraft_instance_id) == $instance->aircraft_instance_id ? 'selected' : ''); ?>>
                                <?php echo e($instance->registration_number ?? 'N/A'); ?> — <?php echo e($instance->aircraft->aircraft_model ?? 'N/A'); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Flight Date</label>
                    <input type="date" name="flight_date" class="form-control" value="<?php echo e(old('flight_date', $flight->flight_date->format('Y-m-d'))); ?>" required>
                </div>
                
                <?php
                    $flightMealIds = $flight->meals->pluck('id')->toArray();
                ?>
                <div>
                    <label class="form-label mb-3 mt-2 border-bottom pb-2" style="font-size: 14px; color: var(--primary);">
                        <i class="bi bi-cup-hot me-2"></i>In-Flight Meals Availability
                    </label>
                    <div class="row g-3">
                        <?php $__empty_1 = true; $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-md-6">
                            <div class="form-check border rounded p-3 h-100 d-flex align-items-center" style="background-color: var(--surface-2);">
                                <input class="form-check-input me-3" type="checkbox" name="meals[]" value="<?php echo e($meal->id); ?>" id="meal_<?php echo e($meal->id); ?>" style="transform: scale(1.2);"
                                <?php echo e((is_array(old('meals')) && in_array($meal->id, old('meals'))) || (old('meals') === null && in_array($meal->id, $flightMealIds)) ? 'checked' : ''); ?>>
                                <label class="form-check-label flex-grow-1" for="meal_<?php echo e($meal->id); ?>" style="cursor: pointer;">
                                    <div class="fw-bold"><?php echo e($meal->name); ?></div>
                                    <div class="small text-muted mb-1">Rp <?php echo e(number_format($meal->price_usd * config('app.usd_to_idr', 15000), 0, ',', '.')); ?></div>
                                    <div class="small" style="font-size: 11px;"><?php echo e(Str::limit($meal->description, 40)); ?></div>
                                </label>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12">
                            <span class="text-muted small">No active meals available. Create some in the Meals tab first.</span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Update Flight
                </button>
                <a href="<?php echo e(route('admin.flights.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/flights/edit.blade.php ENDPATH**/ ?>