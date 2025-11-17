<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claims Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .main-content {
            margin-left: 280px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
        
        .sidebar-collapsed .main-content {
            margin-left: 80px;
        }

        .page-header {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .filter-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .table-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: white;
            border-bottom: 2px solid #dee2e6;
        }

        .table thead th {
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            color: #495057;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border: none;
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .action-btn {
            padding: 0.25rem 0.35rem;
            border: none;
            background: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .action-btn.view {
            color: #0d6efd;
        }

        .action-btn.view:hover {
            color: #0a58ca;
        }

        .action-btn.download {
            color: #198754;
        }

        .action-btn.download:hover {
            color: #146c43;
        }

        .action-btn.delete {
            color: #dc3545;
        }

        .action-btn.delete:hover {
            color: #b02a37;
        }

        .status-select {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        .status-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('components.sidebar')
        
        <!-- Main content -->
        <div class="main-content flex-grow-1">
            <div class="container-fluid py-4">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Claims</h4>
                        <a href="{{ route('claims.create') }}" class="btn btn-primary">New Claim</a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filters -->
                <div class="card filter-card mb-3">
                    <div class="card-body">
                        <form method="GET" action="{{ route('claims.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Admin Status</label>
                                    <select name="admin_status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('admin_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="billed" {{ request('admin_status') == 'billed' ? 'selected' : '' }}>Billed</option>
                                    </select>
                                </div>
                                @if(auth()->user() && auth()->user()->position === 'superadmin')
                                    <div class="col-md-3">
                                        <label class="form-label">Super Admin Status</label>
                                        <select name="superadmin_status" class="form-select">
                                            <option value="">All Status</option>
                                            <option value="cleared" {{ request('superadmin_status') == 'cleared' ? 'selected' : '' }}>Cleared</option>
                                            <option value="deposited" {{ request('superadmin_status') == 'deposited' ? 'selected' : '' }}>Deposited</option>
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            Filter
                                        </button>
                                        @if(request()->hasAny(['admin_status', 'superadmin_status']))
                                            <a href="{{ route('claims.index') }}" class="btn btn-outline-secondary">
                                                Clear
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card table-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Client</th>
                                        <th>Insurance Provider</th>
                                        <th>Policy No.</th>
                                        <th>Claim No.</th>
                                        <th>Total</th>
                                        <th>Admin Status</th>
                                        @if(auth()->user() && auth()->user()->position === 'superadmin')
                                            <th>Super Admin Status</th>
                                        @endif
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($claims as $claim)
                                        <tr>
                                            <td>{{ $claim->id }}</td>
                                            <td>{{ $claim->date_of_claim?->format('Y-m-d') }}</td>
                                            <td>{{ $claim->client_name }}</td>
                                            <td>{{ $claim->insuranceProvider->name ?? 'N/A' }}</td>
                                            <td>{{ $claim->policy_number }}</td>
                                            <td><span class="badge bg-primary">{{ $claim->claim_number }}</span></td>
                                            <td>₱{{ number_format($claim->total_amount ?? 0, 2) }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('claims.update-admin-status', $claim) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="admin_status" class="form-select form-select-sm status-select" onchange="this.form.submit()" style="width: auto;">
                                                        <option value="pending" {{ $claim->admin_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="billed" {{ $claim->admin_status == 'billed' ? 'selected' : '' }}>Billed</option>
                                                    </select>
                                                </form>
                                            </td>
                                            @if(auth()->user() && auth()->user()->position === 'superadmin')
                                                <td>
                                                    <form method="POST" action="{{ route('claims.update-superadmin-status', $claim) }}" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="superadmin_status" class="form-select form-select-sm status-select" onchange="this.form.submit()" style="width: auto;">
                                                            <option value="" {{ !$claim->superadmin_status ? 'selected' : '' }}>Not Set</option>
                                                            <option value="cleared" {{ $claim->superadmin_status == 'cleared' ? 'selected' : '' }}>Cleared</option>
                                                            <option value="deposited" {{ $claim->superadmin_status == 'deposited' ? 'selected' : '' }}>Deposited</option>
                                                        </select>
                                                    </form>
                                                </td>
                                            @endif
                                            <td>
                                                <div class="d-flex" style="gap: 0.25rem;">
                                                    <a href="{{ route('claims.show', $claim) }}" class="action-btn view" title="View">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </a>
                                                    @if($claim->file_path)
                                                        <a href="{{ route('claims.download', $claim) }}" class="action-btn download" title="Download">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                        <form method="POST" action="{{ route('claims.deleteFile', $claim->id) }}" style="display:inline" onsubmit="return confirm('Delete this file?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="action-btn delete" title="Delete File">
                                                                <i class="bi bi-file-x"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form method="POST" action="{{ route('claims.destroy', $claim) }}" style="display:inline" onsubmit="return confirm('Delete this claim?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-btn delete" title="Delete">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $claims->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Optional: Add sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('[data-bs-toggle="sidebar"]');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    document.body.classList.toggle('sidebar-collapsed');
                });
            }
        });
    </script>
</body>
</html>