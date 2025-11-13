<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Commission - Powerlug</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 250px;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .page-content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }
        
        .page-content {
            padding: 20px;
            min-height: calc(100vh - 70px);
        }
        
        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #495057;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
        }
        
        .footer {
            background-color: transparent;
            border-top: 1px solid #e9ecef;
            padding: 20px 0;
            margin-top: 20px;
        }
        
        /* Fixed table styles */
        .table-container {
            position: relative;
            max-height: 600px;
            overflow: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }
        
        .table-fixed-header {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .table-fixed-header thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 20;
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .page-content-wrapper {
                margin-left: 0;
            }
            
            body {
                padding-top: 60px; /* Account for mobile header */
            }
            
            .table-container {
                max-height: 500px;
            }
        }
        
        @media (max-width: 767.98px) {
            .table-container {
                max-height: 400px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <!-- @include('components.sidebar') -->
    <!-- For demo purposes, adding a placeholder sidebar -->
    <div class="sidebar bg-dark text-white" style="width: var(--sidebar-width); min-height: 100vh; position: fixed; left: 0; top: 0;">
        <div class="p-3">
            <h5 class="text-center">Powerlug</h5>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a href="#" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Commission</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Policies</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Reports</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Page Content -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Commission</h4>
                            <div>
                                <a href="{{ route('commission.create') }}" class="btn btn-primary me-2">
                                    <i class="fas fa-plus me-1"></i> Add Commission
                                </a>
                                <button class="btn btn-success me-2" onclick="exportToExcel()">
                                    <i class="fas fa-file-excel me-1"></i> Export to Excel
                                </button>
                                <button class="btn btn-info" onclick="generateCommissionReport()">
                                    <i class="fas fa-chart-bar me-1"></i> Generate Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Filters Section -->
                                <div class="mb-4">
                                    <form method="GET" action="{{ route('commission.index') }}" id="filterForm">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Insurance Provider</label>
                                                <select name="insurance_provider_id" class="form-select">
                                                    <option value="">All Providers</option>
                                                    @foreach($insuranceProviders as $provider)
                                                        <option value="{{ $provider->id }}" {{ request('insurance_provider_id') == $provider->id ? 'selected' : '' }}>
                                                            {{ $provider->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Payment Status</label>
                                                <select name="payment_status" class="form-select">
                                                    <option value="">All Status</option>
                                                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Date From</label>
                                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Date To</label>
                                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">&nbsp;</label>
                                                <div class="d-flex gap-1">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-filter me-1"></i> Filter
                                                    </button>
                                                    @if(request()->hasAny(['insurance_provider_id', 'payment_status', 'date_from', 'date_to']))
                                                        <a href="{{ route('commission.index') }}" class="btn btn-outline-secondary">
                                                            <i class="fas fa-times"></i> Clear
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="section-title">Commission Summary</div>

                                <div class="table-container">
                                    <table id="commissionsTable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead class="table-light table-fixed-header">
                                            <tr>
                                                <th>INSURANCE PROVIDER</th>
                                                <th>POLICY NUMBER</th>
                                                <th>INSURED</th>
                                                <th>TERM</th>
                                                <th>GROSS</th>
                                                <th>NET</th>
                                                <th>30 DAYS</th>
                                                <th>60 DAYS</th>
                                                <th>90 DAYS</th>
                                                <th>Last Date of PDC & Installment / Current Date of Full Payment</th>
                                                <th>COMMISSION</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($commissions) && $commissions->count() > 0)
                                                @foreach($commissions as $commission)
                                                    <tr>
                                                        <td>{{ $commission->insuranceProvider->name ?? 'N/A' }}</td>
                                                        <td>{{ $commission->policy_number }}</td>
                                                        <td>{{ $commission->insured }}</td>
                                                        <td>{{ $commission->term }}</td>
                                                        <td>₱{{ number_format($commission->gross_premium, 2) }}</td>
                                                        <td>₱{{ number_format($commission->net_premium, 2) }}</td>
                                                        <td>₱{{ number_format($commission->days_30, 2) }}</td>
                                                        <td>₱{{ number_format($commission->days_60, 2) }}</td>
                                                        <td>₱{{ number_format($commission->days_90, 2) }}</td>
                                                        <td>{{ $commission->last_pdc_date ? $commission->last_pdc_date->format('Y-m-d') : 'N/A' }}</td>
                                                        <td>₱{{ number_format($commission->commission_amount, 2) }}</td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <button class="btn btn-sm btn-outline-primary view-commission" data-commission-id="{{ $commission->id }}" title="View Details">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <a href="{{ route('commission.edit', $commission->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <button class="btn btn-sm btn-outline-danger delete-commission" data-commission-id="{{ $commission->id }}" data-commission-number="{{ $commission->policy_number }}" title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="12" class="text-center py-4">
                                                        <div class="text-muted">
                                                            <i class="fas fa-dollar-sign fa-2x mb-3"></i>
                                                            <p>No commission records found.</p>
                                                            @if(request()->hasAny(['insurance_provider_id', 'payment_status', 'date_from', 'date_to']))
                                                                <p class="small">Try adjusting your filters or <a href="{{ route('commission.index') }}">clear filters</a>.</p>
                                                            @else
                                                                <p class="small">
                                                                    <a href="{{ route('commission.create') }}" class="btn btn-sm btn-primary">
                                                                        <i class="fas fa-plus me-1"></i> Add your first commission
                                                                    </a>
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                @if(isset($commissions) && $commissions->hasPages())
                                    <div class="mt-3">
                                        {{ $commissions->links() }}
                                    </div>
                                @endif
                            </div>
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

    <!-- Commission Details Modal -->
    <div class="modal fade" id="commissionDetailsModal" tabindex="-1" aria-labelledby="commissionDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commissionDetailsModalLabel">Commission Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="commissionDetailsContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading commission details...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteCommissionModal" tabindex="-1" aria-labelledby="deleteCommissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCommissionModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this commission record?</p>
                    <p><strong>Policy Number: <span id="commissionNumberToDelete"></span></strong></p>
                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteCommissionForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Commission</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Show success message if present
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // View commission details
            $(document).on('click', '.view-commission', function() {
                const commissionId = $(this).data('commission-id');
                
                $('#commissionDetailsModal').modal('show');

                // Fetch details via AJAX
                $.get('/commission/' + commissionId + '/details')
                    .done(function(data) {
                        $('#commissionDetailsContent').html(`
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Policy Information</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Insurance Provider:</strong></td>
                                            <td>${data.insurance_provider?.name || 'N/A'}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Policy Number:</strong></td>
                                            <td>${data.policy_number}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Insured:</strong></td>
                                            <td>${data.insured}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Term:</strong></td>
                                            <td>${data.term}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Status:</strong></td>
                                            <td><span class="badge bg-${data.payment_status === 'paid' ? 'success' : data.payment_status === 'partial' ? 'warning' : 'secondary'}">${data.payment_status.toUpperCase()}</span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Commission Details</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Gross Premium:</strong></td>
                                            <td>₱${parseFloat(data.gross_premium).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Net Premium:</strong></td>
                                            <td>₱${parseFloat(data.net_premium).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Commission Rate:</strong></td>
                                            <td>${data.commission_rate}%</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Commission Amount:</strong></td>
                                            <td class="text-success fw-bold">₱${parseFloat(data.commission_amount).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last PDC Date:</strong></td>
                                            <td>${data.last_pdc_date || 'N/A'}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6>Payment Schedule</h6>
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Period</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>30 Days</td>
                                                <td>₱${parseFloat(data.days_30).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                                            </tr>
                                            <tr>
                                                <td>60 Days</td>
                                                <td>₱${parseFloat(data.days_60).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                                            </tr>
                                            <tr>
                                                <td>90 Days</td>
                                                <td>₱${parseFloat(data.days_90).toLocaleString('en-PH', {minimumFractionDigits: 2})}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            ${data.remarks ? `
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6>Remarks</h6>
                                    <p class="text-muted">${data.remarks}</p>
                                </div>
                            </div>
                            ` : ''}
                        `);
                    })
                    .fail(function() {
                        $('#commissionDetailsContent').html('<div class="alert alert-danger">Failed to load commission details.</div>');
                    });
            });

            // Delete commission
            $(document).on('click', '.delete-commission', function() {
                const commissionId = $(this).data('commission-id');
                const commissionNumber = $(this).data('commission-number');
                
                $('#commissionNumberToDelete').text(commissionNumber);
                $('#deleteCommissionForm').attr('action', '/commission/' + commissionId);
                $('#deleteCommissionModal').modal('show');
            });

            // Export to Excel functionality
            window.exportToExcel = function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Export to Excel',
                    text: 'This feature will export commission data to Excel.',
                    showCancelButton: true,
                    confirmButtonText: 'Export',
                    confirmButtonColor: '#28a745'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Implementation for Excel export
                        Swal.fire('Coming Soon', 'Export functionality will be implemented', 'info');
                    }
                });
            };

            // Generate commission report
            window.generateCommissionReport = function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Generate Report',
                    text: 'This feature will generate a commission report.',
                    showCancelButton: true,
                    confirmButtonText: 'Generate',
                    confirmButtonColor: '#17a2b8'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Implementation for report generation
                        Swal.fire('Coming Soon', 'Report generation functionality will be implemented', 'info');
                    }
                });
            };
        });
    </script>
</body>
</html>