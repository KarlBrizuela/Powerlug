<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection Information - Powerlug</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
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
        .page-content {
            padding: 20px 0;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 10px;
        }
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        /* Table container with horizontal scroll */
        .table-container {
            overflow-x: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }
        
        /* Ensure table takes full width and doesn't wrap */
        .table-container table {
            min-width: 1000px; /* Minimum width to ensure horizontal scroll */
            margin-bottom: 0;
            white-space: nowrap;
        }
        
        /* Action column styling */
        .action-column {
            position: sticky;
            right: 0;
            background-color: white;
            z-index: 5;
            box-shadow: -2px 0 5px rgba(0,0,0,0.1);
            min-width: 180px;
        }
        
        .table-container thead th.action-column {
            background-color: #f8f9fa;
        }
        
        /* Button group styling */
        .btn-group {
            display: flex;
            flex-wrap: nowrap;
            gap: 4px;
        }
        .btn-group .btn {
            flex-shrink: 0;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid #e3e6f0;
        }
        
        /* Custom scrollbar styling */
        .table-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .table-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* For Firefox */
        .table-container {
            scrollbar-width: thin;
            scrollbar-color: #c1c1c1 #f1f1f1;
        }
        
        /* Ensure table cells don't wrap */
        .table-container td,
        .table-container th {
            white-space: nowrap;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Collection Information</h4>
                        <div>
                            <a href="{{ route('collections.create') }}" class="btn btn-primary me-2">
                                <i class="fas fa-plus me-1"></i> Add New Collection
                            </a>
                            <!-- <button class="btn btn-success" onclick="exportToExcel()">
                                <i class="fas fa-file-excel me-1"></i> Export to Excel
                            </button> -->
                        </div>
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
                            <div class="section-title">Collection Records</div>

                            <!-- Simple Filters -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Date Range</label>
                                    <input type="date" id="dateFilter" class="form-control">
                                </div>
                            </div>

                            <div class="table-container">
                                <table id="collectionsTable" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Collection #</th>
                                            <th>Client Name</th>
                                            <th>Invoice Number</th>
                                            <th>Billing Status</th>
                                            <th>Collection Amount</th>
                                            <th>Collection Status</th>
                                            <th>Payment Method</th>
                                            <th>Date</th>
                                            <th>Bank</th>
                                            <th class="action-column">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($collections as $collection)
                                            <tr>
                                                <td>{{ $collection->collection_number }}</td>
                                                <td>{{ $collection->client->lastName }}, {{ $collection->client->firstName }} {{ $collection->client->middleName }}</td>
                                                <td>{{ $collection->invoice_number }}</td>
                                                <td>{{ ucfirst($collection->billing_status) }}</td>
                                                <td>₱{{ number_format($collection->collection_amount, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $collection->collection_status == 'deposited' ? 'success' : ($collection->collection_status == 'pending' ? 'warning' : ($collection->collection_status == 'cleared' ? 'info' : ($collection->collection_status == 'bounced' ? 'danger' : 'primary'))) }}">
                                                        {{ ucfirst($collection->collection_status) }}
                                                    </span>
                                                </td>
                                                <td>{{ ucfirst(str_replace('_', ' ', $collection->payment_method)) }}</td>
                                                <td>{{ $collection->collection_date }}</td>
                                                <td>{{ $collection->bank_name ?? 'N/A' }}</td>
                                                <td class="action-column">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-primary view-collection" data-collection-id="{{ $collection->id }}" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <a href="{{ route('collections.edit', $collection->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-danger delete-collection" 
                                                                data-collection-id="{{ $collection->id }}" 
                                                                data-collection-number="{{ $collection->collection_number }}"
                                                                title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-database fa-2x mb-3"></i>
                                                        <p>No collection records found.</p>
                                                        <a href="{{ route('collections.create') }}" class="btn btn-primary">
                                                            Add Your First Collection
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($collections->hasPages())
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-muted">
                                                Showing {{ $collections->firstItem() }} to {{ $collections->lastItem() }} of {{ $collections->total() }} entries
                                            </div>
                                            <nav>
                                                {{ $collections->links() }}
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer mt-4">
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteCollectionModal" tabindex="-1" aria-labelledby="deleteCollectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCollectionModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete collection record: <strong id="collectionNumberToDelete"></strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteCollectionForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Collection</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Collection Details Modal -->
    <div class="modal fade" id="collectionDetailsModal" tabindex="-1" aria-labelledby="collectionDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="collectionDetailsModalLabel">Collection Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="collectionDetailsContent">
                    <!-- Details will be loaded via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#collectionsTable').DataTable({
                responsive: true,
                order: [[7, 'desc']], // Sort by date column descending
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search collections...",
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>"
                    }
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                scrollX: true, // Enable horizontal scrolling
                columnDefs: [
                    { 
                        orderable: false, 
                        targets: [9] // Disable sorting for actions column
                    }
                ]
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Delete collection functionality
            $(document).on('click', '.delete-collection', function() {
                const collectionId = $(this).data('collection-id');
                const collectionNumber = $(this).data('collection-number');
                
                $('#collectionNumberToDelete').text(collectionNumber);
                $('#deleteCollectionForm').attr('action', '/collections/' + collectionId);
                $('#deleteCollectionModal').modal('show');
            });

            // Quick view functionality
            $(document).on('click', '.view-collection', function() {
                const collectionId = $(this).data('collection-id');
                
                // Show loading state
                $('#collectionDetailsContent').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading collection details...</p>
                    </div>
                `);
                
                // Load collection details via AJAX
                $.ajax({
                    url: '/collections/' + collectionId + '/quick-view',
                    type: 'GET',
                    success: function(response) {
                        $('#collectionDetailsContent').html(response);
                    },
                    error: function() {
                        $('#collectionDetailsContent').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Failed to load collection details. Please try again.
                            </div>
                        `);
                    }
                });
                
                $('#collectionDetailsModal').modal('show');
            });

            // Filter functionality - only date filter remains
            $('#dateFilter').on('change', function() {
                table.columns(7).search(this.value).draw();
            });

            // Export to Excel functionality
            window.exportToExcel = function() {
                // Get current table data
                const table = $('#collectionsTable').DataTable();
                const data = table.rows({ search: 'applied' }).data();
                
                // Create CSV content
                let csvContent = "Collection Number,Client Name,Invoice Number,Billing Status,Collection Amount,Collection Status,Payment Method,Date,Bank\n";
                
                data.each(function(value, index) {
                    const row = [
                        value[0] || 'N/A',  // Collection Number
                        value[1] || 'N/A',  // Client Name
                        value[2] || 'N/A',  // Invoice Number
                        value[3] || 'N/A',  // Billing Status
                        value[4] || '0.00', // Collection Amount
                        value[5] || 'N/A',  // Collection Status
                        value[6] || 'N/A',  // Payment Method
                        value[7] || 'N/A',  // Date
                        value[8] || 'N/A'   // Bank
                    ];
                    csvContent += row.map(field => `"${field}"`).join(',') + '\n';
                });
                
                // Create and download file
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', `collections_${new Date().toISOString().split('T')[0]}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };
        });
    </script>
</body>
</html>