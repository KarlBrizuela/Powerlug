@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Freebie</h2>
        <a href="{{ route('freebies.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('freebies.update', $freebie->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input name="name" class="form-control" value="{{ old('name', $freebie->name) }}" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Unit</label>
                        <input name="unit" class="form-control" value="{{ old('unit', $freebie->unit) }}" placeholder="e.g. pc, set, hour">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Service</label>
                        <input name="service" class="form-control" value="{{ old('service', $freebie->service) }}" placeholder="e.g. Painting, Detailing">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $freebie->description) }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Schedule Type</label>
                        <select name="schedule_type" class="form-select">
                            <option value="">Manual/One-off</option>
                            <option value="daily" {{ old('schedule_type', $freebie->schedule_type) == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ old('schedule_type', $freebie->schedule_type) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ old('schedule_type', $freebie->schedule_type) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Schedule Value</label>
                        <input name="schedule_value" class="form-control" value="{{ old('schedule_value', is_array($freebie->schedule_value) ? implode(',', $freebie->schedule_value) : $freebie->schedule_value) }}" placeholder="Comma or newline separated values (e.g. Mon,Tue or 1,15)">
                        <div class="form-text">For weekly supply day names (Mon,Tue) or monthly day numbers (1,15). Leave empty for manual.</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($freebie->start_date)->toDateString()) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($freebie->end_date)->toDateString()) }}">
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $freebie->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>

                <div class="text-end">
                    <button class="btn btn-secondary" type="reset">Reset</button>
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
