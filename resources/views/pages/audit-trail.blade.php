<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Trail - Powerlug</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        .page-content {
            padding: 20px 0;
            margin-left: 250px;
            background-color: #f8f9fa;
        }

        /* Fix for oversized feather icons */
        svg.feather,
        svg[data-feather] {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
        }
        
        /* Hide any stray SVG elements that are too large */
        body > svg {
            display: none !important;
        }
        
        .vertical-menu svg {
            width: 16px !important;
            height: 16px !important;
        }

        /* Pagination Styling */
        .pagination {
            margin: 0;
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            align-items: center;
        }
        
        .pagination .page-item {
            margin: 0;
        }
        
        .pagination .page-link {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.5rem 0.9rem;
            color: #495057;
            background: #fff;
            font-weight: 500;
            transition: all 0.2s;
            min-width: 40px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .pagination .page-link:hover:not(.disabled) {
            background: #f8f9fa;
            border-color: #007bff;
            color: #007bff;
        }
        
        .pagination .page-item.active .page-link {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
        }
        
        .pagination .page-item.disabled .page-link {
            background: #f8f9fa;
            color: #adb5bd;
            border-color: #e0e0e0;
            cursor: not-allowed;
        }
        
        .pagination .page-link:focus {
            box-shadow: none;
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

        /* Form Controls */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.6rem 0.75rem;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
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
            justify-content: center;
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
        .btn {
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
        }
        
        .btn-primary {
            background: #007bff;
        }
        
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,123,255,0.3);
        }
        
        .btn-success {
            background: #28a745;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        .btn-danger {
            background: #dc3545;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-outline-secondary {
            border: 2px solid #6c757d;
            color: #6c757d;
            background: transparent;
        }
        
        .btn-outline-secondary:hover {
            background: #6c757d;
            color: #fff;
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
        .footer {
            background-color: #fff;
            border-top: 1px solid #e9ecef;
            padding: 1.5rem;
            margin-top: 20px;
            margin-left: 250px;
        }

        @media (max-width: 768px) {
            .page-content,
            .footer {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    @include('components.sidebar')
    
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Audit Trail - System Activity Tracking</h4>
                        <div>
                            <button class="btn btn-success me-2" onclick="exportToExcel()">
                                <i class="fas fa-file-excel me-1"></i> Export to Excel
                            </button>
                            <button class="btn btn-danger" onclick="clearAuditLogs()">
                                <i class="fas fa-trash me-1"></i> Clear Logs
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
                                <form method="GET" action="{{ route('audit-trail.index') }}" id="filterForm">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Module/Table</label>
                                            <select name="module" class="form-select">
                                                <option value="">All Modules</option>
                                                @foreach($modules as $mod)
                                                    <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>
                                                        {{ $mod }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Action</label>
                                            <select name="action" class="form-select">
                                                <option value="">All Actions</option>
                                                @foreach($actions as $act)
                                                    <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>
                                                        {{ ucfirst($act) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">User</label>
                                            <select name="user_id" class="form-select">
                                                <option value="">All Users</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
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
                                        <div class="col-md-1">
                                            <label class="form-label">&nbsp;</label>
                                            <div class="d-flex gap-1">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @if(request()->hasAny(['module', 'action', 'user_id', 'date_from', 'date_to']))
                                        <div class="mt-2">
                                            <a href="{{ route('audit-trail.index') }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-times me-1"></i> Clear Filters
                                            </a>
                                        </div>
                                    @endif
                                </form>
                            </div>

                            <div class="section-title">
                                System Activity Log
                                @if(request()->hasAny(['module', 'action', 'user_id', 'date_from', 'date_to']))
                                    <span class="badge bg-primary">Filtered</span>
                                @endif
                            </div>

                            <div class="table-responsive">
                                <table id="auditTable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>Module</th>
                                            <th>Record ID</th>
                                            <th>Description</th>
                                            <th>IP Address</th>
                                            <th>Date & Time</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($audits) && $audits->count() > 0)
                                            @foreach($audits as $audit)
                                                <tr>
                                                    <td>{{ $audit->user->name ?? 'System' }}</td>
                                                    <td><span class="badge bg-{{ $audit->getActionColor() }}">{{ ucfirst($audit->action) }}</span></td>
                                                    <td><span class="badge bg-secondary">{{ $audit->module }}</span></td>
                                                    <td>{{ $audit->record_id ?? '-' }}</td>
                                                    <td>{{ $audit->description }}</td>
                                                    <td>{{ $audit->ip_address ?? '-' }}</td>
                                                    <td>{{ $audit->created_at->format('F d, Y h:i A') }}</td>
                                                    <td class="text-center">
                                                        <div class="action-buttons">
                                                            <a href="{{ route('audit-trail.show', $audit->id) }}" class="action-btn view-btn" data-bs-toggle="tooltip" title="View Details">
                                                                <i class="bi bi-eye-fill"></i>
                                                            </a>
                                                            <button class="action-btn delete-btn delete-activity" data-activity-id="{{ $audit->id }}" data-activity-description="{{ $audit->description }}" title="Delete">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-history fa-2x mb-3"></i>
                                                        <p>No audit trail activities found.</p>
                                                        @if(request()->hasAny(['module', 'action', 'user_id', 'date_from', 'date_to']))
                                                            <p class="small">Try adjusting your filters or <a href="{{ route('audit-trail.index') }}">clear filters</a>.</p>
                                                        @else
                                                            <p class="small">Activities will appear here as users interact with the system.</p>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                                @if(isset($audits) && $audits->hasPages())
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                                <div class="text-muted small">
                                                    Showing {{ $audits->firstItem() ?? 0 }} to {{ $audits->lastItem() ?? 0 }} of {{ $audits->total() ?? 0 }} entries
                                                </div>
                                                <nav aria-label="Page navigation">
                                                    <ul class="pagination pagination-sm mb-0">
                                                        @if ($audits->onFirstPage())
                                                            <li class="page-item disabled">
                                                                <span class="page-link">← Previous</span>
                                                            </li>
                                                        @else
                                                            <li class="page-item">
                                                                <a class="page-link" href="{{ $audits->previousPageUrl() }}">← Previous</a>
                                                            </li>
                                                        @endif

                                                        @foreach ($audits->getUrlRange(1, $audits->lastPage()) as $page => $url)
                                                            @if ($page == $audits->currentPage())
                                                                <li class="page-item active">
                                                                    <span class="page-link">{{ $page }}</span>
                                                                </li>
                                                            @else
                                                                <li class="page-item">
                                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach

                                                        @if ($audits->hasMorePages())
                                                            <li class="page-item">
                                                                <a class="page-link" href="{{ $audits->nextPageUrl() }}">Next →</a>
                                                            </li>
                                                        @else
                                                            <li class="page-item disabled">
                                                                <span class="page-link">Next →</span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row mt-3" style="display: none;">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Showing 0 to 0 of 0 entries
                                        </div>
                                        <nav>
                                            <!-- Pagination links would go here -->
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

    <!-- Activity Details Modal -->
    <div class="modal fade" id="activityDetailsModal" tabindex="-1" aria-labelledby="activityDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityDetailsModalLabel">Activity Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="activityDetailsContent">
                    <!-- Details will be loaded via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteActivityModal" tabindex="-1" aria-labelledby="deleteActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteActivityModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this activity log?</p>
                    <p><strong id="activityDescriptionToDelete"></strong></p>
                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteActivityForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Activity</button>
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
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Delete activity functionality
            $(document).on('click', '.delete-activity', function() {
                const activityId = $(this).data('activity-id');
                const activityDescription = $(this).data('activity-description');
                
                $('#activityDescriptionToDelete').text(activityDescription);
                $('#deleteActivityForm').attr('action', '/audit/' + activityId);
                $('#deleteActivityModal').modal('show');
            });

            // Export to Excel functionality
            window.exportToExcel = function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Export to Excel',
                    text: 'This feature will export the current filtered audit trail data to Excel.',
                    showCancelButton: true,
                    confirmButtonText: 'Export',
                    confirmButtonColor: '#28a745'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Implementation for Excel export would go here
                        Swal.fire('Success', 'Export functionality to be implemented', 'success');
                    }
                });
            };

            // Clear audit logs functionality
            window.clearAuditLogs = function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This will permanently delete all audit logs. This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, clear all logs',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form to clear logs
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("audit-trail.clear") }}';
                        
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        form.appendChild(csrf);
                        
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };

            // Fix any oversized SVG icons
            setTimeout(function() {
                document.querySelectorAll('svg').forEach(function(svg) {
                    // Remove any stray large SVGs not inside the sidebar
                    if (!svg.closest('.vertical-menu') && (svg.offsetWidth > 50 || svg.offsetHeight > 50)) {
                        svg.remove();
                    }
                    // Ensure all SVGs have proper size
                    svg.style.width = '16px';
                    svg.style.height = '16px';
                    svg.style.maxWidth = '16px';
                    svg.style.maxHeight = '16px';
                });
            }, 100);
        });
    </script>
</body>
</html>