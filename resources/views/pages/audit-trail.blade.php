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

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="section-title">System Activity Log</div>

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
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-history fa-2x mb-3"></i>
                                                    <p>No audit trail activities found.</p>
                                                    <p class="small">Activities will appear here as users interact with the system.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
            // Initialize DataTable with empty data
            var table = $('#auditTable').DataTable({
                responsive: true,
                data: [], // Empty data
                columns: [
                    { data: 'user', title: 'User' },
                    { data: 'action', title: 'Action' },
                    { data: 'module', title: 'Module' },
                    { data: 'description', title: 'Description' },
                    { data: 'ip_address', title: 'IP Address' },
                    { data: 'date_time', title: 'Date & Time' },
                    { data: 'actions', title: 'Actions', orderable: false }
                ],
                order: [[5, 'desc']], // Sort by date column descending
                language: {
                    emptyTable: "No audit trail activities found.",
                    search: "_INPUT_",
                    searchPlaceholder: "Search activities...",
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>"
                    }
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // View activity details
            $(document).on('click', '.view-activity', function() {
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
                
                $('#activityDetailsModal').modal('show');
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
                alert('Export functionality would be implemented when there is data to export.');
            };

            // Clear audit logs functionality
            window.clearAuditLogs = function() {
                if (confirm('Are you sure you want to clear all audit logs? This action cannot be undone.')) {
                    Swal.fire({
                        title: 'Clearing Logs',
                        text: 'Please wait while we clear the audit logs...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'All audit logs have been cleared successfully.',
                        });
                    }, 1500);
                }
            };
        });
    </script>
</body>
</html>