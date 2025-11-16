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

        /* Action buttons styling */
        .action-btn {
            background: none;
            border: none;
            padding: 0.375rem 0.5rem;
            margin: 0 0.125rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .action-btn:hover {
            background-color: #f8f9fa;
        }

        .action-btn i {
            font-size: 0.875rem;
        }

        .action-btn.view-btn i {
            color: #0dcaf0;
        }

        .action-btn.edit-btn i {
            color: #ffc107;
        }

        .action-btn.installment-btn i {
            color: #0d6efd;
        }

        .action-btn.delete-btn i {
            color: #dc3545;
        }

        .action-btn:hover.view-btn i {
            color: #0aa2c0;
        }

        .action-btn:hover.edit-btn i {
            color: #cc9a06;
        }

        .action-btn:hover.installment-btn i {
            color: #0a58ca;
        }

        .action-btn:hover.delete-btn i {
            color: #b02a37;
        }

        /* Dropdown action menu styling */
        .table-responsive {
            overflow: visible !important;
        }
        
        .table {
            overflow: visible !important;
        }
        
        .table tbody {
            overflow: visible !important;
        }
        
        .table tbody tr {
            overflow: visible !important;
        }
        
        .action-dropdown {
            position: relative;
        }
        
        /* Allow overflow for dropdown in table cells */
        td {
            overflow: visible !important;
        }

        .action-toggle {
            background: none;
            border: none;
            padding: 0.375rem 0.5rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .action-toggle:hover {
            background-color: #f8f9fa;
        }

        .action-toggle i {
            color: #6c757d;
            font-size: 1.125rem;
        }

        .action-menu {
            position: absolute;
            right: 0;
            bottom: 100%;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            min-width: 150px;
            z-index: 1000;
            display: none;
            margin-bottom: 0.25rem;
            overflow: visible;
        }

        .action-menu.show {
            display: block;
        }

        .action-menu-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .action-menu-item:first-child {
            border-radius: 0 0 0.375rem 0.375rem;
        }

        .action-menu-item:last-child {
            border-radius: 0.375rem 0.375rem 0 0;
        }

        .action-menu-item:hover {
            background-color: #f8f9fa;
        }

        .action-menu-item i {
            width: 1rem;
            text-align: center;
        }

        .action-menu-item.view i {
            color: #0dcaf0;
        }

        .action-menu-item.edit i {
            color: #ffc107;
        }

        .action-menu-item.installment i {
            color: #0d6efd;
        }

        .action-menu-item.delete {
            color: #dc3545;
        }

        .action-menu-item.delete i {
            color: #dc3545;
        }

        .action-menu-divider {
            height: 1px;
            background-color: #dee2e6;
            margin: 0.25rem 0;
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
                                        <th>Balance</th>
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
                                            <td>
                                                @php
                                                    $balance = ($policy->amount_due ?? 0) - ($policy->paid_amount ?? 0);
                                                @endphp
                                                <span class="{{ $balance > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                                                    ₱ {{ number_format($balance, 2) }}
                                                </span>
                                            </td>
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
                                                <div class="action-dropdown">
                                                    <button class="action-toggle" type="button" onclick="toggleActionMenu(event, {{ $policy->id }})">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="action-menu" id="action-menu-{{ $policy->id }}">
                                                        <a href="{{ route('policies.show', $policy->id) }}" 
                                                           class="action-menu-item view">
                                                            <i class="fas fa-eye"></i>
                                                            <span>View</span>
                                                        </a>
                                                        <a href="{{ route('policies.edit', $policy->id) }}" 
                                                           class="action-menu-item edit">
                                                            <i class="fas fa-edit"></i>
                                                            <span>Edit</span>
                                                        </a>
                                                        <a href="{{ route('policies.installment', $policy->id) }}" 
                                                           class="action-menu-item installment">
                                                            <i class="fas fa-credit-card"></i>
                                                            <span>Installment</span>
                                                        </a>
                                                        <div class="action-menu-divider"></div>
                                                        <form action="{{ route('policies.destroy', $policy->id) }}" 
                                                              method="POST" style="margin: 0;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="action-menu-item delete"
                                                                    onclick="return confirm('Are you sure you want to delete this policy?')">
                                                                <i class="fas fa-trash"></i>
                                                                <span>Delete</span>
                                                            </button>
                                                        </form>
                                                    </div>
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
    
    <script>
        function toggleActionMenu(event, policyId) {
            event.stopPropagation();
            
            // Close all other open menus
            document.querySelectorAll('.action-menu.show').forEach(menu => {
                if (menu.id !== 'action-menu-' + policyId) {
                    menu.classList.remove('show');
                }
            });
            
            // Toggle current menu
            const menu = document.getElementById('action-menu-' + policyId);
            menu.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.action-dropdown')) {
                document.querySelectorAll('.action-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>