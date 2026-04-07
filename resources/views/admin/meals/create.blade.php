@extends('admin.layouts.app')

@section('page-title', 'Add New Meal')

@push('styles')
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
@endpush

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.meals.store') }}" method="POST" id="mealForm">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-4 small border-0 shadow-sm" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Meal Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Nasi Goreng Spesial" required value="{{ old('name') }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Price (IDR) *</label>
                            <div class="input-group @error('price_idr') has-validation @enderror">
                                <span class="input-group-text">Rp</span>
                                <input type="number" step="0.01" min="0" name="price_idr" class="form-control @error('price_idr') is-invalid @enderror" required value="{{ old('price_idr', 0) }}">
                                @error('price_idr')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" required placeholder="A brief description of the meal ingredients...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                        <a href="{{ route('admin.meals.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="button" class="btn btn-primary px-4" id="submitBtn">
                            <i class="bi bi-save me-1"></i> Save Meal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
@endpush
