    @extends('admin.layouts.app')

    @section('title', 'Create Flight Instance')
    @section('page-title', 'Create Flight Instance')

    @section('content')

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.flights.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <div style="color: var(--text-muted); font-size: 13px;">Flight Instances → Create New</div>
    </div>

    <div class="card" style="max-width: 680px;">
        <div class="card-header">
            <div class="form-section-title mb-0">
                <i class="bi bi-airplane-engines"></i>
                New Flight Instance
            </div>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <strong>Please fix the following errors:</strong>
                    </div>
                    <ul class="mb-0 ps-4 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.flights.store') }}" method="POST">
                @csrf
                <div class="d-flex flex-column gap-4">
                    <div>
                        <label class="form-label">Schedule</label>
                        <select name="schedule_id" class="form-control" required>
                            <option value="">— Select Schedule —</option>
                            @foreach($schedules as $schedule)
                                <option value="{{ $schedule->schedule_id }}">{{ $schedule->flight_number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Aircraft Instance</label>
                        <select name="aircraft_instance_id" class="form-control" required>
                            <option value="">— Select Aircraft —</option>
                            @foreach($aircraftInstances as $instance)
                                <option value="{{ $instance->aircraft_instance_id }}">
                                    {{ $instance->aircraft->registration_number ?? 'N/A' }} — {{ $instance->aircraft->aircraft_model ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Flight Date</label>
                        <input type="date" name="flight_date" class="form-control" required value="{{ old('flight_date') }}">
                    </div>

                    <div>
                        <label class="form-label mb-3 mt-2 border-bottom pb-2" style="font-size: 14px; color: var(--primary);">
                            <i class="bi bi-cup-hot me-2"></i>In-Flight Meals Availability
                        </label>
                        <div class="row g-3">
                            @forelse($meals as $meal)
                            <div class="col-md-6">
                                <div class="form-check border rounded p-3 h-100 d-flex align-items-center" style="background-color: var(--surface-2);">
                                    <input class="form-check-input me-3" type="checkbox" name="meals[]" value="{{ $meal->id }}" id="meal_{{ $meal->id }}" style="transform: scale(1.2);">
                                    <label class="form-check-label flex-grow-1" for="meal_{{ $meal->id }}" style="cursor: pointer;">
                                        <div class="fw-bold">{{ $meal->name }}</div>
                                        <div class="small text-muted mb-1">Rp {{ number_format($meal->price_usd * config('app.usd_to_idr', 15000), 0, ',', '.') }}</div>
                                        <div class="small" style="font-size: 11px;">{{ Str::limit($meal->description, 40) }}</div>
                                    </label>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <span class="text-muted small">No active meals available. Create some in the Meals tab first.</span>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Create Flight
                    </button>
                    <a href="{{ route('admin.flights.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @endsection