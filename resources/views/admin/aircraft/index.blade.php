@extends('admin.layouts.app')

@section('title', 'Aircraft Management')
@section('page-title', 'Aircraft Management')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Aircraft List</h5>
        <a href="{{ route('admin.aircraft.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Aircraft
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Registration</th>
                        <th>Model</th>
                        <th>Manufacturer</th>
                        <th>Total Seats</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aircraft as $item)
                    <tr>
                        <td>{{ $item->aircraft_id }}</td>
                        <td><strong>{{ $item->registration_number }}</strong></td>
                        <td>{{ $item->model }}</td>
                        <td>{{ $item->manufacturer }}</td>
                        <td>{{ $item->total_seats }}</td>
                        <td>
                            <a href="{{ route('admin.aircraft.edit', $item->aircraft_id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.aircraft.destroy', $item->aircraft_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this aircraft?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No aircraft found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $aircraft->links() }}
    </div>
</div>
@endsection
