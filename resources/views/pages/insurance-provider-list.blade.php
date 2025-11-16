<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Provider List - Powerlug</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .page-content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        /* Page Header */
        .page-title-box {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        
        .page-title-box h4 {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }
        
        /* Card Styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            background: #fff;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #007bff;
            display: inline-block;
        }
        
        /* Search and Filter */
        .input-group .form-control {
            border: 1px solid #dee2e6;
            border-radius: 8px 0 0 8px;
        }
        
        .input-group .btn {
            border-radius: 0 8px 8px 0;
            border: 1px solid #dee2e6;
            background: #fff;
            color: #6c757d;
        }
        
        .input-group .btn:hover {
            background: #f8f9fa;
            color: #495057;
        }
        
        .form-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        
        /* Table Styling */
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
            border: none;
        }
        
        .table thead th {
            background-color: #fff;
            color: #495057;
            font-weight: 600;
            border: none;
            padding: 1rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #f0f0f0;
            color: #495057;
        }
        
        .table tbody tr {
            transition: background-color 0.2s;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.25rem;
            align-items: center;
        }
        
        .action-btn {
            background: none;
            border: none;
            padding: 0.25rem;
            cursor: pointer;
            transition: transform 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }
        
        .action-btn i {
            font-size: 1rem;
        }
        
        .action-btn.edit-btn i {
            color: #28a745;
        }
        
        .action-btn.delete-btn i {
            color: #dc3545;
        }
        
        /* Badge Styling */
        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        
        /* Button Styling */
        .btn-primary {
            background: #007bff;
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,123,255,0.3);
        }
        
        .btn-secondary {
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
        }
        
        .btn-danger {
            border-radius: 8px;
            font-weight: 500;
        }
        
        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        .modal-header {
            border-bottom: 1px solid #f0f0f0;
            padding: 1.5rem;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            border-top: 1px solid #f0f0f0;
            padding: 1.5rem;
        }
        
        /* DataTables Customization */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #495057;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 6px;
            margin: 0 2px;
        }
        
        /* Footer */
        .footer {
            margin-left: 250px;
            background-color: #fff;
            border-top: 1px solid #e9ecef;
            padding: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .page-content {
                margin-left: 0;
            }
            .footer {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Include Sidebar -->
    @include('components.sidebar')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Insurance Provider List</h4>
                        <a href="{{ route('insurance-providers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Add New Provider
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="section-title">Provider Records</div>

                            <!-- Search and Filter Section -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" id="searchInput" class="form-control" placeholder="Search providers...">
                                        <button class="btn btn-outline-secondary" type="button" id="searchButton">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end">
                                        <select id="statusFilter" class="form-select w-auto">
                                            <option value="">All Status</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="providersTable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Provider Code</th>
                                            <th>Provider Name</th>
                                            <th>Active Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($providers as $provider)
                                            <tr>
                                                <td><strong>{{ $provider->code }}</strong></td>
                                                <td>{{ $provider->name }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $provider->is_active ? 'success' : 'danger' }}">
                                                        {{ $provider->is_active ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('insurance-providers.edit', $provider) }}" 
                                                           class="action-btn edit-btn" 
                                                           data-bs-toggle="tooltip" 
                                                           title="Edit Provider">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <button type="button" 
                                                                class="action-btn delete-btn delete-provider" 
                                                                data-provider-id="{{ $provider->id }}"
                                                                data-provider-name="{{ $provider->name }}"
                                                                data-bs-toggle="tooltip" 
                                                                title="Delete Provider">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-briefcase fa-2x mb-3"></i>
                                                        <p>No insurance providers found.</p>
                                                        <a href="{{ route('insurance-providers.create') }}" class="btn btn-primary">
                                                            Add Your First Provider
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteProviderModal" tabindex="-1" aria-labelledby="deleteProviderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProviderModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete provider: <strong id="providerNameToDelete"></strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone and may affect existing policies.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteProviderForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Provider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Provider Details Modal -->
    <div class="modal fade" id="providerDetailsModal" tabindex="-1" aria-labelledby="providerDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="providerDetailsModalLabel">Provider Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="providerDetailsContent">
                    <div class="text-center">
                        <h4>Provider Details</h4>
                        <p class="text-muted">This is a demonstration view. In a real application, provider details would be displayed here.</p>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <p><strong>Provider Name:</strong> <span id="detailName">Sample Provider</span></p>
                                <p><strong>Contact Person:</strong> <span id="detailContact">John Doe</span></p>
                                <p><strong>Phone:</strong> <span id="detailPhone">(555) 123-4567</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Commission Rate:</strong> <span id="detailCommission">15%</span></p>
                                <p><strong>Status:</strong> <span id="detailStatus" class="badge bg-success">Active</span></p>
                                <p><strong>Active Policies:</strong> <span id="detailPolicies">25</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © Powerlug.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by <a href="#!" class="text-decoration-underline">Intracode</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#providersTable').DataTable({
                responsive: true,
                order: [[0, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search providers...",
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>"
                    }
                },
                columns: [
                    { data: 'code' },       // Provider Code
                    { data: 'name' },       // Provider Name
                    { data: 'status' },     // Active Status
                    { data: 'actions', orderable: false }  // Actions
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Delete provider functionality
            $('.delete-provider').on('click', function() {
                const providerId = $(this).data('provider-id');
                const providerName = $(this).data('provider-name');
                
                $('#providerNameToDelete').text(providerName);
                $('#deleteProviderForm').attr('action', '/providers/' + providerId);
                $('#deleteProviderModal').modal('show');
            });

            // View provider functionality
            $('.view-provider').on('click', function() {
                $('#providerDetailsModal').modal('show');
            });

            // Search functionality
            $('#searchButton').on('click', function() {
                table.search($('#searchInput').val()).draw();
            });

            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Status filter functionality
            $('#statusFilter').on('change', function() {
                const status = this.value;
                
                if (status === '') {
                    table.columns(2).search('').draw();
                } else if (status === 'active') {
                    table.columns(2).search('Yes').draw();
                } else if (status === 'inactive') {
                    table.columns(2).search('No').draw();
                }
            });
        });
    </script>
</body>
</html>