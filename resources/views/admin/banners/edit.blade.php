@extends('admin.layouts.app')

@section('title', 'Edit Banner')
@section('page-title', 'Edit Banner')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.banners.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Back to List
    </a>
    <h4 class="mt-2">Edit Promotional Banner</h4>
</div>

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm">
            @csrf
            @method('PUT')
            <div class="card-body p-4">
                <div class="mb-4">
                    <label class="form-label">Current Banner Image</label>
                    <div class="mb-3 rounded-3 overflow-hidden border" style="max-width: 400px;">
                        <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" class="w-100">
                    </div>
                    
                    <label class="form-label">Change Image (Optional)</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <div class="form-text">Leave blank to keep the current image. Recommended size: 1200x400px.</div>
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Subtitle (Optional)</label>
                        <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $banner->subtitle) }}">
                        @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Description / Content (Optional)</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3">{{ old('content', $banner->content) }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-md-8">
                        <label class="form-label">Link URL (Optional)</label>
                        <input type="url" name="link_url" class="form-control @error('link_url') is-invalid @enderror" value="{{ old('link_url', $banner->link_url) }}">
                        @error('link_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $banner->order) }}" min="0">
                        @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ $banner->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Banner is active</label>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check2-circle me-2"></i>Update Banner
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
