@extends('layouts.app')

@section('title', 'User Commission - Powerlug')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Commission</h4>
                    <div>
                        <button class="btn btn-success me-2" onclick="exportToExcel()">
                            <i class="fas fa-file-excel me-1"></i> Export to Excel
                        </button>
                        <button class="btn btn-primary" onclick="generateCommissionReport()">
                            <i class="fas fa-chart-bar me-1"></i> Generate Report
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

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">₱{{ number_format($stats['total_commission'], 2) }}</h4>
                                <p class="mb-0">Total Commission</p>
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
                                <h4 class="mb-0">{{ $stats['total_policies'] }}</h4>
                                <p class="mb-0">Total Policies</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-contract fa-2x"></i>
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
                                <h4 class="mb-0">{{ $stats['active_providers'] }}</h4>
                                <p class="mb-0">Active Providers</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-briefcase fa-2x"></i>
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
                                <h4 class="mb-0">₱{{ number_format($stats['pending_commission'], 2) }}</h4>
                                <p class="mb-0">Pending Commission</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Note -->
        <div class="summary-note">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Commission Summary:</strong> This report shows commission calculations based on policy sales and payment terms. 
            Negative commission values indicate adjustments or chargebacks.
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="section-title">Commission Summary</div>

                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Insurance Provider</label>
                                <select id="providerFilter" class="form-select">
                                    <option value="">All Providers</option>
                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->code }}">{{ $provider->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Payment Term</label>
                                <select id="termFilter" class="form-select">
                                    <option value="">All Terms</option>
                                    <option value="full_payment">Full Payment</option>
                                    <option value="installment">Installment</option>
                                    <option value="30_days">30 Days</option>
                                    <option value="60_days">60 Days</option>
                                    <option value="90_days">90 Days</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date Range</label>
                                <input type="month" id="dateFilter" class="form-control" value="{{ date('Y-m') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Commission Status</label>
                                <select id="statusFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="positive">Positive</option>
                                    <option value="negative">Negative</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="commissionsTable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead class="table-light">
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
                                    @forelse($commissions as $commission)
                                        <tr>
                                            <td>
                                                <strong>{{ $commission->provider->code }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $commission->provider->name }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $commission->policy_number }}</strong>
                                            </td>
                                            <td>
                                                {{ $commission->insured_name }}
                                                @if($commission->client)
                                                    <br>
                                                    <small class="text-muted">{{ $commission->client->contact_number }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $commission->getTermColor() }}">
                                                    {{ $commission->getFormattedTerm() }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <strong>₱{{ number_format($commission->gross_amount, 2) }}</strong>
                                            </td>
                                            <td class="text-end">
                                                <strong>₱{{ number_format($commission->net_amount, 2) }}</strong>
                                            </td>
                                            <td class="text-end">
                                                ₱{{ number_format($commission->days_30, 2) }}
                                            </td>
                                            <td class="text-end">
                                                ₱{{ number_format($commission->days_60, 2) }}
                                            </td>
                                            <td class="text-end">
                                                ₱{{ number_format($commission->days_90, 2) }}
                                            </td>
                                            <td>
                                                {{ $commission->payment_date->format('M-d-Y') }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $commission->payment_date->diffForHumans() }}
                                                </small>
                                            </td>
                                            <td class="text-end">
                                                <span class="fw-bold {{ $commission->commission_amount >= 0 ? 'text-success' : 'text-danger' }}">
                                                    ₱{{ number_format($commission->commission_amount, 2) }}
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $commission->commission_rate }}%
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" 
                                                            class="btn btn-info view-commission" 
                                                            data-commission-id="{{ $commission->id }}"
                                                            data-bs-toggle="tooltip" 
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-warning adjust-commission" 
                                                            data-commission-id="{{ $commission->id }}"
                                                            data-bs-toggle="tooltip" 
                                                            title="Adjust Commission">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @can('export_commissions')
                                                    <button type="button" 
                                                            class="btn btn-success export-commission" 
                                                            data-commission-id="{{ $commission->id }}"
                                                            data-bs-toggle="tooltip" 
                                                            title="Export Record">
                                                        <i class="fas fa-file-export"></i>
                                                    </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-chart-line fa-2x mb-3"></i>
                                                    <p>No commission records found.</p>
                                                    <p class="small">Commission data will appear here as policies are processed and payments are collected.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if($commissions->isNotEmpty())
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">TOTALS:</th>
                                        <th class="text-end">₱{{ number_format($commissions->sum('gross_amount'), 2) }}</th>
                                        <th class="text-end">₱{{ number_format($commissions->sum('net_amount'), 2) }}</th>
                                        <th class="text-end">₱{{ number_format($commissions->sum('days_30'), 2) }}</th>
                                        <th class="text-end">₱{{ number_format($commissions->sum('days_60'), 2) }}</th>
                                        <th class="text-end">₱{{ number_format($commissions->sum('days_90'), 2) }}</th>
                                        <th></th>
                                        <th class="text-end {{ $commissions->sum('commission_amount') >= 0 ? 'text-success' : 'text-danger' }}">
                                            ₱{{ number_format($commissions->sum('commission_amount'), 2) }}
                                        </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($commissions->hasPages())
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Showing {{ $commissions->firstItem() }} to {{ $commissions->lastItem() }} of {{ $commissions->total() }} entries
                                        </div>
                                        <nav>
                                            {{ $commissions->links() }}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Monitor Note -->
        <div class="monitor-note">
            <i class="fas fa-chart-line me-2"></i>
            <strong>Commission Monitoring:</strong> Regularly monitor commission calculations and ensure accurate reporting. 
            Negative commissions may require investigation and adjustment.
        </div>
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
                <!-- Details will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Adjust Commission Modal -->
<div class="modal fade" id="adjustCommissionModal" tabindex="-1" aria-labelledby="adjustCommissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustCommissionModalLabel">Adjust Commission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="adjustCommissionContent">
                <!-- Adjustment form will be loaded via AJAX -->
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
        var table = $('#commissionsTable').DataTable({
            responsive: true,
            order: [[10, 'desc']], // Sort by commission amount descending
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search commissions...",
                paginate: {
                    previous: "<i class='fas fa-chevron-left'></i>",
                    next: "<i class='fas fa-chevron-right'></i>"
                }
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            columnDefs: [
                { orderable: false, targets: [11] } // Disable sorting for actions column
            ],
            footerCallback: function (row, data, start, end, display) {
                // Footer calculations are handled server-side
            }
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // View commission details
        $('.view-commission').on('click', function() {
            const commissionId = $(this).data('commission-id');
            
            // Show loading state
            $('#commissionDetailsContent').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading commission details...</p>
                </div>
            `);
            
            // Load commission details via AJAX
            $.ajax({
                url: '/commissions/' + commissionId + '/details',
                type: 'GET',
                success: function(response) {
                    $('#commissionDetailsContent').html(response);
                },
                error: function() {
                    $('#commissionDetailsContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Failed to load commission details. Please try again.
                        </div>
                    `);
                }
            });
            
            $('#commissionDetailsModal').modal('show');
        });

        // Adjust commission
        $('.adjust-commission').on('click', function() {
            const commissionId = $(this).data('commission-id');
            
            // Show loading state
            $('#adjustCommissionContent').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading adjustment form...</p>
                </div>
            `);
            
            // Load adjustment form via AJAX
            $.ajax({
                url: '/commissions/' + commissionId + '/adjust',
                type: 'GET',
                success: function(response) {
                    $('#adjustCommissionContent').html(response);
                },
                error: function() {
                    $('#adjustCommissionContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Failed to load adjustment form. Please try again.
                        </div>
                    `);
                }
            });
            
            $('#adjustCommissionModal').modal('show');
        });

        // Filter functionality
        $('#providerFilter').on('change', function() {
            table.columns(0).search(this.value).draw();
        });

        $('#termFilter').on('change', function() {
            table.columns(3).search(this.value).draw();
        });

        $('#dateFilter').on('change', function() {
            // Filter by month
            const selectedDate = this.value;
            if (selectedDate) {
                table.column(9).search(selectedDate).draw();
            } else {
                table.column(9).search('').draw();
            }
        });

        $('#statusFilter').on('change', function() {
            const status = this.value;
            if (status === 'positive') {
                table.column(10).search('^[0-9]', true, false).draw(); // Positive numbers
            } else if (status === 'negative') {
                table.column(10).search('^-', true, false).draw(); // Negative numbers
            } else {
                table.column(10).search('').draw();
            }
        });

        // Export to Excel functionality
        window.exportToExcel = function() {
            // Get current table data
            const table = $('#commissionsTable').DataTable();
            const data = table.rows({ search: 'applied' }).data();
            
            // Create CSV content
            let csvContent = "Insurance Provider,Policy Number,Insured,Term,Gross Amount,Net Amount,30 Days,60 Days,90 Days,Payment Date,Commission\n";
            
            data.each(function(value, index) {
                const row = [
                    value[0].replace(/<[^>]*>/g, '').trim(),  // Provider (remove HTML tags)
                    value[1].replace(/<[^>]*>/g, '').trim(),  // Policy Number (remove HTML tags)
                    value[2].replace(/<[^>]*>/g, '').trim(),  // Insured (remove HTML tags)
                    value[3].replace(/<[^>]*>/g, '').trim(),  // Term (remove HTML tags)
                    value[4].replace(/[^0-9.]/g, ''),         // Gross Amount (extract numbers)
                    value[5].replace(/[^0-9.]/g, ''),         // Net Amount (extract numbers)
                    value[6].replace(/[^0-9.]/g, ''),         // 30 Days (extract numbers)
                    value[7].replace(/[^0-9.]/g, ''),         // 60 Days (extract numbers)
                    value[8].replace(/[^0-9.]/g, ''),         // 90 Days (extract numbers)
                    value[9].replace(/<[^>]*>/g, '').trim(),  // Payment Date (remove HTML tags)
                    value[10].replace(/[^0-9.-]/g, '')        // Commission (extract numbers)
                ];
                csvContent += row.map(field => `"${field}"`).join(',') + '\n';
            });
            
            // Create and download file
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `commissions_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };

        // Generate commission report
        window.generateCommissionReport = function() {
            // Show loading state
            Swal.fire({
                title: 'Generating Report',
                text: 'Please wait while we generate the commission report...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Get filter values
            const filters = {
                provider: $('#providerFilter').val(),
                term: $('#termFilter').val(),
                date: $('#dateFilter').val(),
                status: $('#statusFilter').val()
            };

            // Send AJAX request to generate report
            $.ajax({
                url: '/commissions/generate-report',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    filters: filters
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Report Generated',
                        text: 'Commission report has been generated successfully!',
                        showCancelButton: true,
                        confirmButtonText: 'Download PDF',
                        cancelButtonText: 'Close'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Download the PDF
                            window.open(response.download_url, '_blank');
                        }
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Failed to generate commission report.',
                    });
                }
            });
        };

        // Ensure feather icons are initialized
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endpush