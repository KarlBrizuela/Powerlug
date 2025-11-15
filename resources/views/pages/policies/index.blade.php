<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Policies</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .card {
            border: 1px solid #dee2e6;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
        }

        /* Sidebar compatibility styles */
        .main-content {
            margin-left: 250px; /* Adjust based on your sidebar width */
            padding: 20px;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }

        .badge {
            font-size: 0.75em;
        }
    </style>
</head>
<body>
    <!-- Your existing sidebar component would go here -->
    @include('components.sidebar')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h2 class="page-title">Policies</h2>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('policies.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Policy
                    </a>
                </div>
            </div>

            <!-- Date Filter Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Filter Policies</h5>
                    <form method="GET" action="{{ route('policies.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ request('end_date') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                            <a href="{{ route('policies.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear Filters
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if ($policies->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Policy #</th>
                                        <th>Client</th>
                                        <th>Provider</th>
                                        <th>Premium</th>
                                        <th>Amount Due</th>
                                        <th>Status</th>
                                        <th>Payment Terms</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($policies as $policy)
                                        <tr>
                                            <td>
                                                <strong>{{ $policy->policy_number }}</strong>
                                            </td>
                                            <td>
                                                @if($policy->client)
                                                    {{ $policy->client->firstName ?? '' }} {{ $policy->client->lastName ?? '' }}
                                                @else
                                                    {{ $policy->client_name ?? 'N/A' }}
                                                @endif
                                            </td>
                                            <td>{{ $policy->insuranceProvider->name ?? $policy->insurance_provider ?? 'N/A' }}</td>
                                            <td>₱ {{ number_format($policy->premium ?? 0, 2) }}</td>
                                            <td>₱ {{ number_format($policy->amount_due ?? 0, 2) }}</td>
                                            <td>
                                                @switch($policy->status)
                                                    @case('active')
                                                        <span class="badge bg-success">Active</span>
                                                        @break
                                                    @case('inactive')
                                                        <span class="badge bg-secondary">Inactive</span>
                                                        @break
                                                    @case('expired')
                                                        <span class="badge bg-warning">Expired</span>
                                                        @break
                                                    @case('cancelled')
                                                        <span class="badge bg-danger">Cancelled</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $policy->payment_terms ?? '-' }}</td>
                                            <td>{{ optional($policy->start_date)->format('M d, Y') ?? '-' }}</td>
                                            <td>{{ optional($policy->end_date)->format('M d, Y') ?? '-' }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('policies.show', $policy->id) }}" 
                                                       class="btn btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('policies.edit', $policy->id) }}" 
                                                       class="btn btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('policies.installment', $policy->id) }}" 
                                                       class="btn btn-primary" title="Installment">
                                                        <i class="fas fa-credit-card"></i>
                                                    </a>
                                                    <form action="{{ route('policies.destroy', $policy->id) }}" 
                                                          method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                title="Delete"
                                                                onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $policies->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center py-5">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <p>No policies found. <a href="{{ route('policies.create') }}">Create one now</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>