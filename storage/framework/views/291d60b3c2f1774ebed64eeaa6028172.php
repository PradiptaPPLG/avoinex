<?php $__env->startSection('title', 'Register Aircraft'); ?>
<?php $__env->startSection('page-title', 'Register Aircraft'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?php echo e(route('admin.aircraft.index')); ?>" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Aircraft Management → Register New Aircraft</div>
</div>

<form action="<?php echo e(route('admin.aircraft.store')); ?>" method="POST" id="aircraft-form">
<?php echo csrf_field(); ?>

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


<div class="card mb-3">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-info-circle"></i>
            Basic Information
        </div>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-4">
                <label class="form-label">Registration Number</label>
                <input type="text" name="registration_number" class="form-control" placeholder="e.g. PK-GEA" value="<?php echo e(old('registration_number')); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Aircraft Model</label>
                <input type="text" name="model" class="form-control" placeholder="e.g. Boeing 737-800" value="<?php echo e(old('model')); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Manufacturer</label>
                <select name="manufacturer" class="form-control" required>
                    <option value="">— Select Manufacturer —</option>
                    <?php $__currentLoopData = $manufacturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mfg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($mfg->aircraft_manufacturer_id); ?>" <?php echo e(old('manufacturer') == $mfg->aircraft_manufacturer_id ? 'selected' : ''); ?>>
                            <?php echo e($mfg->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        
        <div class="row g-4 mt-1">
            <div class="col-md-4">
                <label class="form-label">Baggage Capacity (kg)</label>
                <input type="number" name="baggage_capacity_kg" class="form-control" placeholder="e.g. 20" value="<?php echo e(old('baggage_capacity_kg', 20)); ?>" min="0" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="has_meal" id="has_meal" value="1" <?php echo e(old('has_meal', true) ? 'checked' : ''); ?>>
                    <label class="form-check-label ms-2" for="has_meal">Meal Included</label>
                </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="has_wifi" id="has_wifi" value="1" <?php echo e(old('has_wifi') ? 'checked' : ''); ?>>
                    <label class="form-check-label ms-2" for="has_wifi">Free Wi-Fi Available</label>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-3">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-grid-3x3"></i>
            Seat Configuration
        </div>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-3">
                <label class="form-label">Seats per Row (Width)</label>
                <input type="number" name="seat_columns" id="seat_columns" class="form-control" min="2" max="12" value="<?php echo e(old('seat_columns', 6)); ?>" required>
                <small class="text-muted">e.g. 6 = A B C | D E F</small>
            </div>
            <div class="col-md-3">
                <label class="form-label">Total Rows (Length)</label>
                <input type="number" name="seat_rows" id="seat_rows" class="form-control" min="5" max="80" value="<?php echo e(old('seat_rows', 30)); ?>" required>
                <small class="text-muted">Rows from front to back</small>
            </div>
            <div class="col-md-3">
                <label class="form-label">Total Seats</label>
                <div class="form-control bg-light fw-bold text-primary" id="total_seats_display" style="font-family:'JetBrains Mono',monospace; font-size: 15px;">180</div>
                <small class="text-muted">Auto-calculated</small>
            </div>
            <div class="col-md-3">
                <label class="form-label">Seat Letter Preview</label>
                <div class="form-control bg-light" id="seat_letters_preview" style="font-family:'JetBrains Mono',monospace; font-size: 13px; letter-spacing: 0.1em; color: var(--primary);">A B C | D E F</div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-3">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-stars"></i>
            Class Configuration
        </div>
    </div>
    <div class="card-body">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <label class="form-label">Business Class Rows</label>
                <input type="number" name="business_rows" id="business_rows" class="form-control" min="0" max="20" value="<?php echo e(old('business_rows', 2)); ?>" required>
                <small class="text-muted">Starting from row 1</small>
            </div>
            <div class="col-md-4">
                <label class="form-label">Business Class Seats</label>
                <div class="form-control bg-light" id="business_seats_display" style="font-family:'JetBrains Mono',monospace;">12</div>
                <small class="text-muted">Auto-calculated</small>
            </div>
            <div class="col-md-4">
                <label class="form-label">Economy Class Seats</label>
                <div class="form-control bg-light" id="economy_seats_display" style="font-family:'JetBrains Mono',monospace;">168</div>
                <small class="text-muted">Auto-calculated</small>
            </div>
        </div>

        
        <div style="background: var(--surface-2); border: 1.5px solid var(--border); border-radius: 10px; padding: 18px;">
            <div class="form-check form-switch d-flex align-items-center gap-3 mb-0">
                <input class="form-check-input" type="checkbox" name="preferred_zone_enabled" id="preferred_zone_enabled" value="1" <?php echo e(old('preferred_zone_enabled') ? 'checked' : ''); ?> style="width: 40px; height: 22px;">
                <div>
                    <label class="form-check-label fw-semibold" for="preferred_zone_enabled" style="font-size: 13.5px;">
                        <i class="bi bi-arrows-angle-expand text-info me-1"></i> Enable Preferred Zone (Extra Legroom)
                    </label>
                    <div class="text-muted" style="font-size: 12px; margin-top: 2px;">Designate specific rows with extra legroom for an additional surcharge</div>
                </div>
            </div>

            <div id="preferred_zone_fields" style="display: none; margin-top: 20px; padding-top: 18px; border-top: 1px solid var(--border);">
                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label">Start Row</label>
                        <input type="number" name="preferred_zone_start_row" id="preferred_zone_start_row" class="form-control" min="1" value="<?php echo e(old('preferred_zone_start_row', 3)); ?>">
                        <small class="text-muted">Auto-filled: after business rows</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Row</label>
                        <input type="number" name="preferred_zone_end_row" id="preferred_zone_end_row" class="form-control" min="1" value="<?php echo e(old('preferred_zone_end_row', 5)); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Preferred Zone Seats</label>
                        <div class="form-control bg-light" id="preferred_seats_display" style="font-family:'JetBrains Mono',monospace;">18</div>
                        <small class="text-muted">Auto-calculated</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-layout-text-window-reverse text-primary"></i>
        <h5 class="mb-0">Cabin Layout Summary</h5>
    </div>
    <div class="card-body">
        <div id="layout_summary" class="d-flex flex-wrap gap-2 align-items-center">
            <!-- filled by JS -->
        </div>
    </div>
</div>


<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-lg me-1"></i> Register Aircraft
    </button>
    <a href="<?php echo e(route('admin.aircraft.index')); ?>" class="btn btn-secondary">Cancel</a>
</div>

</form>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cols = document.getElementById('seat_columns');
    const rows = document.getElementById('seat_rows');
    const bizRows = document.getElementById('business_rows');
    const prefEnabled = document.getElementById('preferred_zone_enabled');
    const prefStart = document.getElementById('preferred_zone_start_row');
    const prefEnd = document.getElementById('preferred_zone_end_row');
    const prefFields = document.getElementById('preferred_zone_fields');

    function getLetters(n) {
        let letters = [];
        for (let i = 0; i < n; i++) letters.push(String.fromCharCode(65 + i));
        return letters;
    }

    function update() {
        const c = parseInt(cols.value) || 6;
        const r = parseInt(rows.value) || 30;
        const b = parseInt(bizRows.value) || 0;
        const total = c * r;
        const letters = getLetters(c);
        const half = Math.ceil(c / 2);
        const leftSide = letters.slice(0, half).join(' ');
        const rightSide = letters.slice(half).join(' ');

        document.getElementById('total_seats_display').textContent = total;
        document.getElementById('seat_letters_preview').textContent = leftSide + ' | ' + rightSide;
        document.getElementById('business_seats_display').textContent = c * b;

        let econStart = b + 1;
        let prefSeats = 0;

        if (prefEnabled.checked) {
            prefFields.style.display = 'block';
            if (!prefStart.dataset.userEdited) {
                prefStart.value = b + 1;
            }
            const ps = parseInt(prefStart.value) || (b + 1);
            const pe = parseInt(prefEnd.value) || (b + 3);
            prefSeats = c * (pe - ps + 1);
            econStart = pe + 1;
            document.getElementById('preferred_seats_display').textContent = prefSeats;
        } else {
            prefFields.style.display = 'none';
        }

        const econRows = Math.max(0, r - econStart + 1);
        document.getElementById('economy_seats_display').textContent = c * econRows;

        let summary = '';
        if (b > 0) summary += `<span class="badge bg-warning"><i class="bi bi-stars me-1"></i>Business: Rows 1–${b} &nbsp;(${c * b} seats)</span>`;
        if (prefEnabled.checked) {
            const ps = parseInt(prefStart.value) || (b + 1);
            const pe = parseInt(prefEnd.value) || (b + 3);
            summary += `<span class="badge bg-info"><i class="bi bi-arrows-angle-expand me-1"></i>Preferred: Rows ${ps}–${pe} &nbsp;(${prefSeats} seats)</span>`;
        }
        if (econRows > 0) summary += `<span class="badge bg-success"><i class="bi bi-person me-1"></i>Economy: Rows ${econStart}–${r} &nbsp;(${c * econRows} seats)</span>`;
        summary += `<span class="badge bg-primary"><i class="bi bi-grid me-1"></i>Total: ${total} seats</span>`;
        document.getElementById('layout_summary').innerHTML = summary;
    }

    cols.addEventListener('input', update);
    rows.addEventListener('input', update);
    bizRows.addEventListener('input', update);
    prefEnabled.addEventListener('change', update);
    prefStart.addEventListener('input', function() { this.dataset.userEdited = '1'; update(); });
    prefEnd.addEventListener('input', update);

    update();
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/aircraft/create.blade.php ENDPATH**/ ?>