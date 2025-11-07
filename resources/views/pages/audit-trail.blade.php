@extends('layouts.app')

@section('title', 'Audit Trail - Powerlug')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Audit Trail</h4>
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

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">{{ $stats['total_activities'] }}</h4>
                                <p class="mb-0">Total Activities</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-history fa-2x"></i>
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
                                <h4 class="mb-0">{{ $stats['users_count'] }}</h4>
                                <p class="mb-0">Active Users</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-users fa-2x"></i>
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
                                <h4 class="mb-0">{{ $stats['today_activities'] }}</h4>
                                <p class="mb-0">Today's Activities</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-day fa-2x"></i>
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
                                <h4 class="mb-0">{{ $stats['modules_count'] }}</h4>
                                <p class="mb-0">Modules Tracked</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-cubes fa-2x"></i>
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
                        <div class="section-title">System Activity Log</div>

                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">User Filter</label>
                                <select id="userFilter" class="form-select">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Action Type</label>
                                <select id="actionFilter" class="form-select">
                                    <option value="">All Actions</option>
                                    <option value="created">Created</option>
                                    <option value="updated">Updated</option>
                                    <option value="deleted">Deleted</option>
                                    <option value="viewed">Viewed</option>
                                    <option value="login">Login</option>
                                    <option value="logout">Logout</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Module</label>
                                <select id="moduleFilter" class="form-select">
                                    <option value="">All Modules</option>
                                    <option value="clients">Clients</option>
                                    <option value="policies">Policies</option>
                                    <option value="claims">Claims</option>
                                    <option value="providers">Providers</option>
                                    <option value="collections">Collections</option>
                                    <option value="users">Users</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date Range</label>
                                <input type="date" id="dateFilter" class="form-control">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="auditTable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Module</th>
                                        <th>Description</th>
                                        <th>IP Address</th>
                                        <th>Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activities as $activity)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ $activity->user->avatar_url ?? asset('assets/images/users/avatar-default.png') }}" 
                                                             alt="{{ $activity->user->name }}" 
                                                             class="rounded-circle avatar-xs">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <strong>{{ $activity->user->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $activity->user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $activity->getActionColor() }}">
                                                    {{ ucfirst($activity->action) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ ucfirst($activity->module) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="activity-description" data-bs-toggle="tooltip" title="{{ $activity->description }}">
                                                    {{ Str::limit($activity->description, 50) }}
                                                </span>
                                                @if($activity->old_values || $activity->new_values)
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Data changes recorded
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <code>{{ $activity->ip_address }}</code>
                                            </td>
                                            <td>
                                                {{ $activity->created_at->format('M d, Y') }}<br>
                                                <small class="text-muted">{{ $activity->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" 
                                                            class="btn btn-info view-activity" 
                                                            data-activity-id="{{ $activity->id }}"
                                                            data-bs-toggle="tooltip" 
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @can('delete_audit_logs')
                                                    <button type="button" 
                                                            class="btn btn-danger delete-activity" 
                                                            data-activity-id="{{ $activity->id }}"
                                                            data-activity-description="{{ $activity->description }}"
                                                            data-bs-toggle="tooltip" 
                                                            title="Delete Log">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-history fa-2x mb-3"></i>
                                                    <p>No audit trail activities found.</p>
                                                    <p class="small">Activities will appear here as users interact with the system.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($activities->hasPages())
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Showing {{ $activities->firstItem() }} to {{ $activities->lastItem() }} of {{ $activities->total() }} entries
                                        </div>
                                        <nav>
                                            {{ $activities->links() }}
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
        var table = $('#auditTable').DataTable({
            responsive: true,
            order: [[5, 'desc']], // Sort by date column descending
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search activities...",
                paginate: {
                    previous: "<i class='fas fa-chevron-left'></i>",
                    next: "<i class='fas fa-chevron-right'></i>"
                }
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            columnDefs: [
                { orderable: false, targets: [6] } // Disable sorting for actions column
            ]
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // View activity details
        $('.view-activity').on('click', function() {
            const activityId = $(this).data('activity-id');
            
            // Show loading state
            $('#activityDetailsContent').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading activity details...</p>
                </div>
            `);
            
            // Load activity details via AJAX
            $.ajax({
                url: '/audit/' + activityId + '/details',
                type: 'GET',
                success: function(response) {
                    $('#activityDetailsContent').html(response);
                },
                error: function() {
                    $('#activityDetailsContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Failed to load activity details. Please try again.
                        </div>
                    `);
                }
            });
            
            $('#activityDetailsModal').modal('show');
        });

        // Delete activity functionality
        $('.delete-activity').on('click', function() {
            const activityId = $(this).data('activity-id');
            const activityDescription = $(this).data('activity-description');
            
            $('#activityDescriptionToDelete').text(activityDescription);
            $('#deleteActivityForm').attr('action', '/audit/' + activityId);
            $('#deleteActivityModal').modal('show');
        });

        // Filter functionality
        $('#userFilter').on('change', function() {
            table.columns(0).search(this.value).draw();
        });

        $('#actionFilter').on('change', function() {
            table.columns(1).search(this.value).draw();
        });

        $('#moduleFilter').on('change', function() {
            table.columns(2).search(this.value).draw();
        });

        $('#dateFilter').on('change', function() {
            table.columns(5).search(this.value).draw();
        });

        // Export to Excel functionality
        window.exportToExcel = function() {
            // Get current table data
            const table = $('#auditTable').DataTable();
            const data = table.rows({ search: 'applied' }).data();
            
            // Create CSV content
            let csvContent = "User,Action,Module,Description,IP Address,Date & Time\n";
            
            data.each(function(value, index) {
                const row = [
                    value[0].replace(/<[^>]*>/g, '').trim(),  // User (remove HTML tags)
                    value[1].replace(/<[^>]*>/g, '').trim(),  // Action (remove HTML tags)
                    value[2].replace(/<[^>]*>/g, '').trim(),  // Module (remove HTML tags)
                    value[3].replace(/<[^>]*>/g, '').trim(),  // Description (remove HTML tags)
                    value[4].replace(/<[^>]*>/g, '').trim(),  // IP Address (remove HTML tags)
                    value[5].replace(/<[^>]*>/g, '').trim()   // Date & Time (remove HTML tags)
                ];
                csvContent += row.map(field => `"${field}"`).join(',') + '\n';
            });
            
            // Create and download file
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `audit_trail_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        };

        // Clear audit logs functionality
        window.clearAuditLogs = function() {
            if (confirm('Are you sure you want to clear all audit logs? This action cannot be undone.')) {
                // Show loading state
                Swal.fire({
                    title: 'Clearing Logs',
                    text: 'Please wait while we clear the audit logs...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send AJAX request to clear logs
                $.ajax({
                    url: '/audit/clear',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to clear audit logs.',
                        });
                    }
                });
            }
        };

        // Ensure feather icons are initialized
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endpush