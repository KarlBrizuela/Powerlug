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
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        .page-content {
            padding: 20px 0;
            margin-left: 250px; /* Adjust based on your sidebar width */
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
            margin-left: 250px; /* Adjust based on your sidebar width */
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
                                <table id="auditTable" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead class="table-light">
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
                                                        <a href="{{ route('audit-trail.show', $audit->id) }}" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-outline-danger delete-activity" data-activity-id="{{ $audit->id }}" data-activity-description="{{ $audit->description }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
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
                                    <div class="mt-3">
                                        {{ $audits->links() }}
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
        });
    </script>
</body>
</html>