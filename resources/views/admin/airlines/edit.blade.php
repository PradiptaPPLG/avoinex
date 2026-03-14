@extends('admin.layouts.app')

@section('title', 'Edit Airline')
@section('page-title', 'Edit Airline')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.airlines.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
    <div style="color: var(--text-muted); font-size: 13px;">Airlines → Edit {{ $airline->airline_name }}</div>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-header">
        <div class="form-section-title mb-0">
            <i class="bi bi-pencil-square"></i>
            Edit Airline — {{ $airline->airline_name }}
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.airlines.update', $airline->airline_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Airline Code</label>
                    <input type="text" name="airline_code" class="form-control" maxlength="10" style="text-transform: uppercase;" value="{{ old('airline_code', $airline->airline_code) }}" required>
                    @error('airline_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Airline Name</label>
                    <input type="text" name="airline_name" class="form-control" value="{{ old('airline_name', $airline->airline_name) }}" required>
                    @error('airline_name')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Country</label>
                    <select name="country_code" class="form-control" required>
                        <option value="">— Select Country —</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->country_code }}" {{ old('country_code', $airline->country_code) == $country->country_code ? 'selected' : '' }}>{{ $country->country_code }} — {{ $country->country_name }}</option>
                        @endforeach
                    </select>
                    @error('country_code')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact Phone <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $airline->contact_phone) }}">
                    @error('contact_phone')
                        <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Airline Logo <span style="color: var(--text-muted); font-weight: 400;">(Upload to update, required 1:1 format)</span></label>
                <input type="file" id="logo_input" class="form-control" accept="image/*">
                <input type="hidden" name="cropped_logo" id="cropped_logo">
                <div id="image_preview_container" style="display:none; margin-top: 15px; max-width: 300px;">
                    <img id="image_preview" src="" style="max-width: 100%;">
                    <button type="button" id="crop_btn" class="btn btn-primary mt-2 btn-sm"><i class="bi bi-crop me-1"></i>Confirm Crop</button>
                    <div id="crop_result_msg" class="text-success mt-1" style="display:none; font-size: 13px;"><i class="bi bi-check-circle me-1"></i>Image cropped and ready to save.</div>
                </div>
                @if(isset($airline) && $airline->logo_path)
                <div class="mt-2" id="current_logo_container">
                    <p class="mb-1 text-muted" style="font-size: 13px;">Current Logo:</p>
                    <img src="{{ asset('logo_maskapai/' . $airline->logo_path) }}" alt="Airline Logo" style="width: 80px; height: 80px; object-fit: contain; border-radius: 50%; border: 1px solid #ddd; background: #f8f9fa;">
                </div>
                @endif
                @error('cropped_logo')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Website <span style="color: var(--text-muted); font-weight: 400;">(optional)</span></label>
                <input type="url" name="website" class="form-control" value="{{ old('website', $airline->website) }}">
                @error('website')
                    <div class="text-danger" style="font-size: 12px; margin-top: 5px;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> Update Airline
                </button>
                <a href="{{ route('admin.airlines.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper = null;
    const logoInput = document.getElementById('logo_input');
    const imagePreview = document.getElementById('image_preview');
    const previewContainer = document.getElementById('image_preview_container');
    const cropBtn = document.getElementById('crop_btn');
    const croppedLogoHidden = document.getElementById('cropped_logo');
    const cropResultMsg = document.getElementById('crop_result_msg');
    const currentLogoContainer = document.getElementById('current_logo_container');

    logoInput.addEventListener('change', function(e) {
        if(currentLogoContainer) currentLogoContainer.style.display = 'none';
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                previewContainer.style.display = 'block';
                cropResultMsg.style.display = 'none';
                
                if (cropper) {
                    cropper.destroy();
                }
                
                cropper = new Cropper(imagePreview, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                });
            };
            
            reader.readAsDataURL(file);
        }
    });

    cropBtn.addEventListener('click', function() {
        if (!cropper) return;
        
        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300
        });
        
        croppedLogoHidden.value = canvas.toDataURL('image/png');
        cropResultMsg.style.display = 'block';
    });
</script>

@endsection
