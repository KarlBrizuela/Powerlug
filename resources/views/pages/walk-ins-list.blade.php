@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">

    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold">Walk-ins</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('policy.walkin') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Add New Walk-in
            </a>
            <a href="{{ route('policy.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-list-ul"></i> View Policies
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Filter Walk-ins</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('policy.walkins-list') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control form-control-sm" id="start_date" name="start_date" 
                           value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control form-control-sm" id="end_date" name="end_date" 
                           value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-funnel"></i> Apply
                    </button>
                    <a href="{{ route('policy.walkins-list') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-lg"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card">
        <div class="card-body p-0">
            @if ($allWalkIns && $allWalkIns->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Walk-in #</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Plate Number</th>
                                <th>Total Amount</th>
                                <th>Payment Type</th>
                                <th>Date Created</th>
                                <th class="pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allWalkIns as $walkin)
                                <tr>
                                    <td class="ps-4">
                                        <strong>{{ $walkin->walkin_number ?? 'N/A' }}</strong>
                                    </td>
                                    <td>{{ $walkin->insured_name ?? 'N/A' }}</td>
                                    <td>{{ $walkin->unit ?? 'N/A' }}</td>
                                    <td>{{ $walkin->plate_number ?? 'N/A' }}</td>
                                    <td>
                                        <span class="text-success fw-bold">
                                            ₱{{ number_format($walkin->total_amount ?? 0, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($walkin->payment_type === 'down_payment')
                                            <span class="badge bg-warning text-dark">Down Payment</span>
                                        @elseif($walkin->payment_type === 'full_payment')
                                            <span class="badge bg-success">Full Payment</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $walkin->payment_type ?? 'N/A')) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($walkin->created_at)->format('M d, Y') ?? '-' }}</td>
                                    <td class="pe-4">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('walk-in.show', $walkin->id) }}" class="btn btn-outline-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('policies.installment', $walkin->id) }}" class="btn btn-outline-info" title="Installment">
                                                <i class="bi bi-credit-card"></i>
                                            </a>
                                            @if($walkin->file_path)
                                                <a href="{{ route('walk-in.download', $walkin->id) }}" class="btn btn-outline-success" title="Download">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('walk-in.destroy', $walkin->id) }}" method="POST" onsubmit="return confirm('Delete this walk-in?');" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center py-5 mb-0">
                    <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                    <p class="mt-3">No walk-ins found. <a href="{{ route('policy.walkin') }}">Create one now</a></p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
