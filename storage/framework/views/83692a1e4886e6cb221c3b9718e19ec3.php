<?php $__env->startSection('page-title', 'Add New Meal'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>
<style>
    .image-workspace {
        width: 100%;
        max-height: 400px;
        background: #f8f9fa;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        border: 1px dashed #ced4da;
        border-radius: 8px;
    }
    .preview-container {
        width: 200px;
        height: 200px;
        overflow: hidden;
        border-radius: 8px;
        border: 2px solid #279ED6;
        background: #e9ecef;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="<?php echo e(route('admin.meals.store')); ?>" method="POST" id="mealForm">
                    <?php echo csrf_field(); ?>
                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-4 small border-0 shadow-sm" role="alert">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Meal Name *</label>
                        <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="e.g. Nasi Goreng Spesial" required value="<?php echo e(old('name')); ?>">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Price (IDR) *</label>
                            <div class="input-group <?php $__errorArgs = ['price_idr'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-validation <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <span class="input-group-text">Rp</span>
                                <input type="number" step="0.01" min="0" name="price_idr" class="form-control <?php $__errorArgs = ['price_idr'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required value="<?php echo e(old('price_idr', 0)); ?>">
                                <?php $__errorArgs = ['price_idr'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActive" value="1" checked>
                                <label class="form-check-label" for="isActive">Active (Available for flights)</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3" required placeholder="A brief description of the meal ingredients..."><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-section-title mt-4">
                        <i class="bi bi-image"></i> Meal Image (1:1 Ratio)
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <input type="file" id="imageInput" class="form-control mb-3" accept="image/png, image/jpeg, image/jpg, image/webp">
                            <div class="image-workspace d-none" id="workspace">
                                <img id="imageToCrop" src="" style="max-width: 100%;">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column align-items-center">
                            <label class="form-label w-100 text-center">Preview</label>
                            <div class="preview-container d-flex align-items-center justify-content-center text-muted">
                                No image
                            </div>
                            <button type="button" id="cropBtn" class="btn btn-secondary btn-sm w-100 mt-3 d-none">
                                <i class="bi bi-crop"></i> Apply Crop
                            </button>
                        </div>
                    </div>

                    <!-- Hidden input for base64 -->
                    <input type="hidden" name="cropped_image" id="croppedImageInput">

                    <hr class="mt-5 mb-4">
                    
                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.meals.index')); ?>" class="btn btn-light px-4">Cancel</a>
                        <button type="button" class="btn btn-primary px-4" id="submitBtn">
                            <i class="bi bi-save me-1"></i> Save Meal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const imageToCrop = document.getElementById('imageToCrop');
    const workspace = document.getElementById('workspace');
    const cropBtn = document.getElementById('cropBtn');
    const previewContainer = document.querySelector('.preview-container');
    const croppedImageInput = document.getElementById('croppedImageInput');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('mealForm');
    
    let cropper = null;

    imageInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            const url = URL.createObjectURL(file);
            
            imageToCrop.src = url;
            workspace.classList.remove('d-none');
            cropBtn.classList.remove('d-none');
            previewContainer.innerHTML = ''; // clear preview text
            
            if (cropper) {
                cropper.destroy();
            }
            
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 1, // 1:1 auto crop
                viewMode: 2,
                preview: '.preview-container'
            });
        }
    });

    // Apply Crop button simply takes a snapshot to show user it works, though we auto-save it on submit
    cropBtn.addEventListener('click', function() {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({
            width: 500,
            height: 500
        });
        
        // Update input
        croppedImageInput.value = canvas.toDataURL('image/jpeg', 0.85);
        
        // Visual feedback
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Image cropped successfully',
            showConfirmButton: false,
            timer: 1500
        });
    });

    form.addEventListener('submit', function(e) {
        // If they uploaded an image but forgot to click Apply Crop, auto crop it
        if (cropper && imageInput.files.length > 0) {
            const canvas = cropper.getCroppedCanvas({ width: 500, height: 500 });
            croppedImageInput.value = canvas.toDataURL('image/jpeg', 0.85);
        }
    });

    submitBtn.addEventListener('click', function() {
        form.requestSubmit(); // This triggers 'submit' event correctly
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Avoinex\resources\views/admin/meals/create.blade.php ENDPATH**/ ?>