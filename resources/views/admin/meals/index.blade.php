@extends('admin.layouts.app')

@section('page-title', 'In-Flight Meals')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Meal Catalog</h4>
    <a href="{{ route('admin.meals.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add New Meal
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3" style="width: 80px;">Image</th>
                        <th class="py-3">Name</th>
                        <th class="py-3">Description</th>
                        <th class="py-3 text-center">Price (USD)</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($meals as $meal)
                    <tr>
                        <td class="px-4 py-3">
                            @if($meal->image_path)
                                <img src="{{ asset('storage/' . $meal->image_path) }}" alt="{{ $meal->name }}" class="rounded shadow-sm" style="width: 48px; height: 48px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width: 48px; height: 48px; color: #adb5bd;">
                                    <i class="bi bi-image" style="font-size: 20px;"></i>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 fw-bold">{{ $meal->name }}</td>
                        <td class="py-3 text-muted small" style="max-width: 250px;">
                            {{ Str::limit($meal->description, 50) }}
                        </td>
                        <td class="py-3 text-center fw-semibold text-primary">
                            ${{ number_format($meal->price_usd, 2) }}
                        </td>
                        <td class="py-3 text-center">
                            @if($meal->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('admin.meals.edit', $meal->id) }}" class="btn btn-sm btn-info" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.meals.destroy', $meal->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="confirmDelete(event, this.form, 'This will permanently delete the meal.')">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-3"></i>
                            No meals found. Start by adding a new one!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $meals->links() }}
</div>
@endsection
