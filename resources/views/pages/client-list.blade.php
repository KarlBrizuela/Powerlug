<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List - Powerlug</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
        }
        .card-body {
            padding: 1.5rem;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #5a5c69;
        }
        .page-title-box {
            padding: 0;
            margin-bottom: 1.5rem;
        }
        .table th {
            border-top: none;
            font-weight: 600;
            color: #5a5c69;
            background-color: #f8f9fa;
        }
        .btn-group-sm > .btn, .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        footer {
            padding: 1.5rem 0;
            margin-top: 2rem;
            background-color: #f8f9fa;
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
                                    <table class="table table-bordered">
                                        <thead class="table-light">
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
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('clients.show', $client->id) }}" 
                                                           class="btn btn-info" 
                                                           data-bs-toggle="tooltip" 
                                                           title="View Client">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('clients.edit', $client->id) }}" 
                                                           class="btn btn-primary" 
                                                           data-bs-toggle="tooltip" 
                                                           title="Edit Client">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if(auth()->user()->position === 'superadmin')
                                                        <button type="button" 
                                                                class="btn btn-danger delete-client" 
                                                                data-client-id="{{ $client->id }}"
                                                                data-client-name="{{ $client->firstName }} {{ $client->lastName }}"
                                                                data-bs-toggle="tooltip" 
                                                                title="Delete Client">
                                                            <i class="fas fa-trash"></i>
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