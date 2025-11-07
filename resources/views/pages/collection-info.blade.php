@extends('layouts.app')

@section('title', 'Collection Information - Powerlug')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Collection Information</h4>
                    <div>
                        <a href="{{ route('collections.index') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus me-1"></i> Add New Collection
                        </a>
                        <button class="btn btn-success" onclick="exportToExcel()">
                            <i class="fas fa-file-excel me-1"></i> Export to Excel
                        </button>
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

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">₱{{ number_format($stats['total_amount'], 2) }}</h4>
                                <p class="mb-0">Total Collected</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-money-bill-wave fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">{{ $stats['total_collections'] }}</h4>
                                <p class="mb-0">Total Records</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-database fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">{{ $stats['pending_collections'] }}</h4>
                                <p class="mb-0">Pending</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">{{ $stats['deposited_collections'] }}</h4>
                                <p class="mb-0">Deposited</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-university fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="section-title">Collection Records</div>

                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Status Filter</label>
                                <select id="statusFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="deposited">Deposited</option>
                                    <option value="pending">Pending</option>
                                    <option value="cleared">Cleared</option>
                                    <option value="bounced">Bounced</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Billing Status</label>
                                <select id="billingStatusFilter" class="form-select">
                                    <option value="">All Billing Status</option>
                                    <option value="billed">Billed</option>
                                    <option value="pending">Pending</option>
                                    <option value="overdue">Overdue</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date Range</label>
                                <input type="date" id="dateFilter" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Client Filter</label>
                                <select id="clientFilter" class="form-select">
                                    <option value="">All Clients</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($collections as $collection)
                                        @include('collections.partials.collection-row', ['collection' => $collection])
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-database fa-2x mb-3"></i>
                                                    <p>No collection records found.</p>
                                                    <a href="{{ route('collections.index') }}" class="btn btn-primary">
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
                            <div class="row mt-3">
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
@endsection

@push('styles')
<!-- DataTables CSS -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

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
            columnDefs: [
                { orderable: false, targets: [9] } // Disable sorting for actions column
            ]
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Delete collection functionality
        $('.delete-collection').on('click', function() {
            const collectionId = $(this).data('collection-id');
            const collectionNumber = $(this).data('collection-number');
            
            $('#collectionNumberToDelete').text(collectionNumber);
            $('#deleteCollectionForm').attr('action', '/collections/' + collectionId);
            $('#deleteCollectionModal').modal('show');
        });

        // Quick view functionality
        $('.view-collection').on('click', function() {
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

        // Filter functionality
        $('#statusFilter').on('change', function() {
            table.columns(5).search(this.value).draw();
        });

        $('#billingStatusFilter').on('change', function() {
            table.columns(3).search(this.value).draw();
        });

        $('#dateFilter').on('change', function() {
            table.columns(7).search(this.value).draw();
        });

        $('#clientFilter').on('change', function() {
            table.columns(1).search(this.value).draw();
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
                    value[0],  // Collection Number
                    value[1],  // Client Name
                    value[2],  // Invoice Number
                    value[3],  // Billing Status
                    value[4],  // Collection Amount
                    value[5],  // Collection Status
                    value[6],  // Payment Method
                    value[7],  // Date
                    value[8]   // Bank
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

        // Ensure feather icons are initialized
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endpush