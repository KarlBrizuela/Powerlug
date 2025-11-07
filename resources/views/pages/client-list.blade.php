@extends('layouts.app')

@section('title', 'Client List - Powerlug')

@section('content')
    <style>
        .page-content {
            padding: 20px 0;
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
    </style>
</head>
<body>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Client List</h4>
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Add New Client
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success Alert -->
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                Client created successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

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
                                        <tr>
                                            <td>John Smith</td>
                                            <td>123 Main Street, New York, NY 10001</td>
                                            <td>(555) 123-4567</td>
                                            <td>john.smith@example.com</td>
                                            <td>
                                                <span class="badge bg-success">Yes</span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="#" 
                                                       class="btn btn-info" 
                                                       data-bs-toggle="tooltip" 
                                                       title="View Client">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="#" 
                                                       class="btn btn-primary" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit Client">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-client" 
                                                            data-client-id="1"
                                                            data-client-name="John Smith"
                                                            data-bs-toggle="tooltip" 
                                                            title="Delete Client">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sarah Johnson</td>
                                            <td>456 Oak Avenue, Los Angeles, CA 90210</td>
                                            <td>(555) 987-6543</td>
                                            <td>sarah.j@example.com</td>
                                            <td>
                                                <span class="badge bg-success">Yes</span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="#" 
                                                       class="btn btn-info" 
                                                       data-bs-toggle="tooltip" 
                                                       title="View Client">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="#" 
                                                       class="btn btn-primary" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit Client">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-client" 
                                                            data-client-id="2"
                                                            data-client-name="Sarah Johnson"
                                                            data-bs-toggle="tooltip" 
                                                            title="Delete Client">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Michael Brown</td>
                                            <td>789 Pine Road, Chicago, IL 60601</td>
                                            <td>(555) 456-7890</td>
                                            <td>m.brown@example.com</td>
                                            <td>
                                                <span class="badge bg-danger">No</span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="#" 
                                                       class="btn btn-info" 
                                                       data-bs-toggle="tooltip" 
                                                       title="View Client">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="#" 
                                                       class="btn btn-primary" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit Client">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-client" 
                                                            data-client-id="3"
                                                            data-client-name="Michael Brown"
                                                            data-bs-toggle="tooltip" 
                                                            title="Delete Client">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Showing 1 to 3 of 3 entries
                                        </div>
                                        <nav>
                                            <ul class="pagination mb-0">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                                </li>
                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#">Next</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
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
@endsection