<?php $__env->startSection('page-title', 'Create Flash Sale'); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle text-primary me-2"></i>New Flash Sale</h5>
    </div>
    <div class="card-body p-4">
        <form action="<?php echo e(route('admin.flash_sales.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="row g-4">
                <!-- Flight Selection -->
                <div class="col-12">
                    <label for="flight_id" class="form-label">Select Flight Instance <span class="text-danger">*</span></label>
                    <select name="flight_id" id="flight_id" class="form-select <?php $__errorArgs = ['flight_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">-- Choose an active flight --</option>
                        <?php $__currentLoopData = $flights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($flight->id); ?>" <?php echo e(old('flight_id') == $flight->id ? 'selected' : ''); ?>>
                                <?php echo e($flight->text); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['flight_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Discount Settings -->
                <div class="col-md-6">
                    <label for="discount_type" class="form-label">Discount Type <span class="text-danger">*</span></label>
                    <select name="discount_type" id="discount_type" class="form-select <?php $__errorArgs = ['discount_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="percentage" <?php echo e(old('discount_type') == 'percentage' ? 'selected' : ''); ?>>Percentage (%)</option>
                        <option value="fixed" <?php echo e(old('discount_type') == 'fixed' ? 'selected' : ''); ?>>Fixed Amount ($)</option>
                    </select>
                    <?php $__errorArgs = ['discount_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="col-md-6">
                    <label for="discount_value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                    <input type="number" name="discount_value" id="discount_value" class="form-control <?php $__errorArgs = ['discount_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('discount_value')); ?>" required min="1">
                    <?php $__errorArgs = ['discount_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Time Settings -->
                <div class="col-md-6">
                    <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="start_time" id="start_time" class="form-control <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('start_time', now()->format('Y-m-d\TH:i'))); ?>" required>
                    <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="col-md-6">
                    <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="end_time" id="end_time" class="form-control <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('end_time', now()->addDays(2)->format('Y-m-d\TH:i'))); ?>" required>
                    <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Configuration -->
                <div class="col-md-4">
                    <label for="max_seats" class="form-label">Max Promo Seats <span class="text-danger">*</span></label>
                    <input type="number" name="max_seats" id="max_seats" class="form-control <?php $__errorArgs = ['max_seats'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('max_seats', 10)); ?>" required min="1">
                    <?php $__errorArgs = ['max_seats'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="col-md-4">
                    <label for="priority" class="form-label">Display Priority <small class="text-muted">(Higher = Top)</small> <span class="text-danger">*</span></label>
                    <input type="number" name="priority" id="priority" class="form-control <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('priority', 0)); ?>" required min="0">
                    <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="col-md-4">
                    <label for="is_active" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="is_active" id="is_active" class="form-select <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="1" <?php echo e(old('is_active') == '1' ? 'selected' : ''); ?>>Active</option>
                        <option value="0" <?php echo e(old('is_active') == '0' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                    <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="<?php echo e(route('admin.flash_sales.index')); ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i> Save Flash Sale</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/flash_sales/create.blade.php ENDPATH**/ ?>