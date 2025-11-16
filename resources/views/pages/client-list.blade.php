<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List - Powerlug</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transition: all 0.3s;
        }
        .page-content {
            flex: 1;
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
            margin-bottom: 1.5rem;
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
        
        .action-btn.view-btn i {
            color: #007bff;
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
        
        /* Footer */
        footer {
            padding: 1.5rem 0;
            margin-top: 2rem;
            background-color: #fff;
            border-top: 1px solid #e3e6f0;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-wrapper {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            @include('components.sidebar')
        </div>

        <!-- Main Content -->
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Client List</h4>
                            <a href="{{ route('clients.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add New Client
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Success Alert -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="section-title">Client Records</div>

                                <!-- Search and Filter Section -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Search clients...">
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
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Client Name</th>
                                                <th>Address</th>
                                                <th>Contact Number</th>
                                                <th>Email</th>
                                                <th>Active Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($clients as $client)
                                            <tr>
                                                <td>{{ $client->firstName }} {{ $client->middleName }} {{ $client->lastName }}</td>
                                                <td>{{ $client->address }}, {{ $client->city }}, {{ $client->province }} {{ $client->postalCode }}</td>
                                                <td>{{ $client->phone }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>
                                                    <span class="badge bg-success">Yes</span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('clients.show', $client->id) }}" 
                                                           class="action-btn view-btn" 
                                                           data-bs-toggle="tooltip" 
                                                           title="View Client">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </a>
                                                        <a href="{{ route('clients.edit', $client->id) }}" 
                                                           class="action-btn edit-btn" 
                                                           data-bs-toggle="tooltip" 
                                                           title="Edit Client">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        @if(auth()->user()->position === 'superadmin')
                                                        <button type="button" 
                                                                class="action-btn delete-btn delete-client" 
                                                                data-client-id="{{ $client->id }}"
                                                                data-client-name="{{ $client->firstName }} {{ $client->lastName }}"
                                                                data-bs-toggle="tooltip" 
                                                                title="Delete Client">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No clients found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-muted">
                                                Showing {{ $clients->firstItem() ?? 0 }} to {{ $clients->lastItem() ?? 0 }} of {{ $clients->total() ?? 0 }} entries
                                            </div>
                                            {{ $clients->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="deleteClientModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteClientModalLabel">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete client: <strong id="clientNameToDelete"></strong>?</p>
                            <p class="text-danger"><small>This action cannot be undone.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form id="deleteClientForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Client</button>
                            </form>
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
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Delete client functionality
            $('.delete-client').on('click', function() {
                const clientId = $(this).data('client-id');
                const clientName = $(this).data('client-name');
                
                $('#clientNameToDelete').text(clientName);
                $('#deleteClientForm').attr('action', '/clients/' + clientId);
                $('#deleteClientModal').modal('show');
            });

            // Simple search functionality
            $('#searchButton').on('click', function() {
                filterTable();
            });

            $('#searchInput').on('keyup', function() {
                filterTable();
            });

            function filterTable() {
                const searchText = $('#searchInput').val().toLowerCase();
                const statusFilter = $('#statusFilter').val();
                
                $('tbody tr').each(function() {
                    const clientName = $(this).find('td:eq(0)').text().toLowerCase();
                    const address = $(this).find('td:eq(1)').text().toLowerCase();
                    const contact = $(this).find('td:eq(2)').text().toLowerCase();
                    const email = $(this).find('td:eq(3)').text().toLowerCase();
                    const statusBadge = $(this).find('td:eq(4) .badge').text().toLowerCase();
                    
                    const matchesSearch = clientName.includes(searchText) || 
                                         address.includes(searchText) || 
                                         contact.includes(searchText) || 
                                         email.includes(searchText);
                    
                    let matchesStatus = true;
                    if (statusFilter === 'active') {
                        matchesStatus = statusBadge === 'yes';
                    } else if (statusFilter === 'inactive') {
                        matchesStatus = statusBadge === 'no';
                    }
                    
                    if (matchesSearch && matchesStatus) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            // Status filter functionality
            $('#statusFilter').on('change', function() {
                filterTable();
            });
        });
    </script>
</body>
</html>
            <!-- Success Alert -->
            
         

    <!-- Delete Confirmation Modal -->


    

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Delete client functionality
            $('.delete-client').on('click', function() {
                const clientId = $(this).data('client-id');
                const clientName = $(this).data('client-name');
                
                $('#clientNameToDelete').text(clientName);
                $('#deleteClientForm').attr('action', '/clients/' + clientId);
                $('#deleteClientModal').modal('show');
            });

            // Simple search functionality
            $('#searchButton').on('click', function() {
                filterTable();
            });

            $('#searchInput').on('keyup', function() {
                filterTable();
            });

            function filterTable() {
                const searchText = $('#searchInput').val().toLowerCase();
                const statusFilter = $('#statusFilter').val();
                
                $('tbody tr').each(function() {
                    const clientName = $(this).find('td:eq(0)').text().toLowerCase();
                    const address = $(this).find('td:eq(1)').text().toLowerCase();
                    const contact = $(this).find('td:eq(2)').text().toLowerCase();
                    const email = $(this).find('td:eq(3)').text().toLowerCase();
                    const statusBadge = $(this).find('td:eq(4) .badge').text().toLowerCase();
                    
                    const matchesSearch = clientName.includes(searchText) || 
                                         address.includes(searchText) || 
                                         contact.includes(searchText) || 
                                         email.includes(searchText);
                    
                    let matchesStatus = true;
                    if (statusFilter === 'active') {
                        matchesStatus = statusBadge === 'yes';
                    } else if (statusFilter === 'inactive') {
                        matchesStatus = statusBadge === 'no';
                    }
                    
                    if (matchesSearch && matchesStatus) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            // Status filter functionality
            $('#statusFilter').on('change', function() {
                filterTable();
            });
        });
    </script>
</body>
</html>