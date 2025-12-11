<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Walk-ins List - Powerlug</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Powerlug" name="description" />
    <meta content="Powerlug" name="author" />

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

        .action-btn.download-btn i {
            color: #198754;
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

        .action-btn:hover.download-btn i {
            color: #146c43;
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

        .action-menu-item.download i {
            color: #198754;
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

        /* Installment Payment Cards */
        .payment-card {
            border-left: 4px solid #0d6efd;
            transition: all 0.3s;
        }

        .payment-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .amount-large {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
        }

        .installment-stats {
            display: flex;
            gap: 1rem;
        }

        .stat-card {
            flex: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
@include('components.sidebar')

<div class="main-content">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="page-title">Walk-ins</h2>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('walk-in.export') }}" class="btn btn-success btn-sm me-2">
                    <i class="fas fa-download"></i> Export Excel
                </a>
                <a href="{{ route('walk-in.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Walk-in
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Walk-ins Table -->
        <div class="card">
            <div class="card-body">
                @if($walkIns->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Walk-in No.</th>
                                    <th>Name</th>
                                    <th>Unit</th>
                                    <th>Plate Number</th>
                                    <th>Total Amount</th>
                                    <th>Payment Type</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($walkIns as $walkIn)
                                    <tr>
                                        <td>{{ $walkIn->id }}</td>
                                        <td>
                                            <strong>{{ $walkIn->walkin_number }}</strong>
                                        </td>
                                        <td>{{ $walkIn->insured_name }}</td>
                                        <td>{{ $walkIn->unit }}</td>
                                        <td>{{ $walkIn->plate_number }}</td>
                                        <td>
                                            <span class="fw-bold text-primary">
                                                ₱ {{ number_format($walkIn->total_amount ?? 0, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $walkIn->payment_type ?? 'N/A')) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $status = $walkIn->status ?? 'pending';
                                            @endphp
                                            @switch($status)
                                                @case('completed')
                                                    <span class="badge bg-success">Completed</span>
                                                    @break
                                                @case('pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">{{ ucfirst($status) }}</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $walkIn->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <div class="action-dropdown">
                                                <button class="action-toggle" type="button" onclick="toggleActionMenu(event, {{ $walkIn->id }})">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="action-menu" id="action-menu-{{ $walkIn->id }}">
                                                    <a href="{{ route('walk-in.show', $walkIn) }}" 
                                                       class="action-menu-item view">
                                                        <i class="fas fa-eye"></i>
                                                        <span>View</span>
                                                    </a>

                                                    @if($walkIn->file_path)
                                                        <a href="{{ route('walk-in.download', $walkIn) }}" 
                                                           class="action-menu-item download">
                                                            <i class="fas fa-download"></i>
                                                            <span>Download</span>
                                                        </a>
                                                    @endif

                                                    <a href="{{ route('walk-in.installment', $walkIn->id) }}" 
                                                       class="action-menu-item installment">
                                                        <i class="fas fa-credit-card"></i>
                                                        <span>Installments</span>
                                                    </a>

                                                    <div class="action-menu-divider"></div>

                                                    <form action="{{ route('walk-in.destroy', $walkIn) }}" 
                                                          method="POST" style="margin: 0;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-menu-item delete"
                                                                onclick="return confirm('Are you sure you want to delete this walk-in?')">
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
                    @if($walkIns->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $walkIns->links() }}
                        </div>
                    @endif
                @else
                    <div class="alert alert-info text-center py-5">
                        <i class="fas fa-info-circle fa-2x mb-3"></i>
                        <p>No walk-ins found. <a href="{{ route('walk-in.create') }}">Create one now</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleActionMenu(event, walkInId) {
        event.stopPropagation();
        
        // Close all other open menus
        document.querySelectorAll('.action-menu.show').forEach(menu => {
            if (menu.id !== 'action-menu-' + walkInId) {
                menu.classList.remove('show');
            }
        });
        
        // Toggle current menu
        const menu = document.getElementById('action-menu-' + walkInId);
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
