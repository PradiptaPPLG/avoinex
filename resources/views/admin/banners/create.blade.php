@extends('admin.layouts.app')

@section('title', 'Add New Banner')
@section('page-title', 'Create Banner')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.banners.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Back to List
    </a>
    <h4 class="mt-2">Add New Promotional Banner</h4>
</div>

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm">
            @csrf
            <div class="card-body p-4">
                <div class="mb-4">
                    <label class="form-label">Banner Image <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                    <div class="form-text">Recommended size: 1200x400px (3:1 ratio). Max size: 2MB.</div>
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Summer Vacation Deals" value="{{ old('title') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Subtitle (Optional)</label>
                        <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" placeholder="e.g. Save up to 20% on all flights" value="{{ old('subtitle') }}">
                        @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Description / Content (Optional)</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3" placeholder="Enter more details about this promo...">{{ old('content') }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-8">
                        <label class="form-label">Link URL (Optional)</label>
                        <input type="url" name="link_url" class="form-control @error('link_url') is-invalid @enderror" placeholder="https://avoinex.com/promo/summer" value="{{ old('link_url') }}">
                        @error('link_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}" min="0">
                        @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" checked>
                        <label class="form-check-label" for="isActive">Activate this banner immediately</label>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-cloud-arrow-up me-2"></i>Save Banner
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-lightbulb me-2"></i>Tips</h5>
                <ul class="small mb-0 opacity-75">
                    <li class="mb-2">Use high-quality images with good contrast.</li>
                    <li class="mb-2">Keep the title short and catchy.</li>
                    <li class="mb-2">The order determines the sequence in the carousel (lower numbers first).</li>
                    <li>Inactive banners will not be shown to users.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
