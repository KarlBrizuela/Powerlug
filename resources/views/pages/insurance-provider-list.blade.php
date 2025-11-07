@extends('layouts.app')

@section('title', 'Insurance Provider List - Powerlug')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Insurance Provider List</h4>
                    <a href="{{ route('providers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Add New Provider
                    </a>
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
                        <div class="section-title">Provider Records</div>

                        <!-- Search and Filter Section -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search providers...">
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
                            <table id="providersTable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>Insurance Provider Code</th>
                                        <th>Insurance Provider Name</th>
                                        <th>Contact Person</th>
                                        <th>Contact Phone</th>
                                        <th>Commission Rate</th>
                                        <th>Active Policies</th>
                                        <th>Active Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($providers as $provider)
                                        <tr>
                                            <td><strong>{{ $provider->code }}</strong></td>
                                            <td>{{ $provider->name }}</td>
                                            <td>{{ $provider->contact_person ?? 'N/A' }}</td>
                                            <td>{{ $provider->contact_phone ?? 'N/A' }}</td>
                                            <td>{{ $provider->formatted_commission_rate }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $provider->active_policies_count }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $provider->is_active ? 'success' : 'danger' }}">
                                                    {{ $provider->is_active ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('providers.show', $provider) }}" 
                                                       class="btn btn-info" 
                                                       data-bs-toggle="tooltip" 
                                                       title="View Provider Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('providers.edit', $provider) }}" 
                                                       class="btn btn-primary" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Edit Provider">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger delete-provider" 
                                                            data-provider-id="{{ $provider->id }}"
                                                            data-provider-name="{{ $provider->name }}"
                                                            data-bs-toggle="tooltip" 
                                                            title="Delete Provider">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-briefcase fa-2x mb-3"></i>
                                                    <p>No insurance providers found.</p>
                                                    <a href="{{ route('providers.create') }}" class="btn btn-primary">
                                                        Add Your First Provider
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($providers->hasPages())
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">
                                            Showing {{ $providers->firstItem() }} to {{ $providers->lastItem() }} of {{ $providers->total() }} entries
                                        </div>
                                        <nav>
                                            {{ $providers->links() }}
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
<div class="modal fade" id="deleteProviderModal" tabindex="-1" aria-labelledby="deleteProviderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProviderModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete provider: <strong id="providerNameToDelete"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone and may affect existing policies.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteProviderForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Provider</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Provider Details Modal -->
<div class="modal fade" id="providerDetailsModal" tabindex="-1" aria-labelledby="providerDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="providerDetailsModalLabel">Provider Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="providerDetailsContent">
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
        var table = $('#providersTable').DataTable({
            responsive: true,
            order: [[0, 'asc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search providers...",
                paginate: {
                    previous: "<i class='fas fa-chevron-left'></i>",
                    next: "<i class='fas fa-chevron-right'></i>"
                }
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            columnDefs: [
                { orderable: false, targets: [7] } // Disable sorting for actions column
            ]
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Delete provider functionality
        $('.delete-provider').on('click', function() {
            const providerId = $(this).data('provider-id');
            const providerName = $(this).data('provider-name');
            
            $('#providerNameToDelete').text(providerName);
            $('#deleteProviderForm').attr('action', '/providers/' + providerId);
            $('#deleteProviderModal').modal('show');
        });

        // Search functionality
        $('#searchButton').on('click', function() {
            table.search($('#searchInput').val()).draw();
        });

        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Status filter functionality
        $('#statusFilter').on('change', function() {
            const status = this.value;
            
            if (status === '') {
                table.columns(6).search('').draw();
            } else if (status === 'active') {
                table.columns(6).search('Yes').draw();
            } else if (status === 'inactive') {
                table.columns(6).search('No').draw();
            }
        });

        // Quick view functionality
        $('.view-provider').on('click', function() {
            const providerId = $(this).data('provider-id');
            
            // Show loading state
            $('#providerDetailsContent').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading provider details...</p>
                </div>
            `);
            
            // Load provider details via AJAX
            $.ajax({
                url: '/providers/' + providerId + '/quick-view',
                type: 'GET',
                success: function(response) {
                    $('#providerDetailsContent').html(response);
                },
                error: function() {
                    $('#providerDetailsContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Failed to load provider details. Please try again.
                        </div>
                    `);
                }
            });
            
            $('#providerDetailsModal').modal('show');
        });

        // Toggle provider status
        $('.toggle-status').on('click', function() {
            const providerId = $(this).data('provider-id');
            const currentStatus = $(this).data('status');
            const newStatus = currentStatus === '1' ? '0' : '1';
            
            $.ajax({
                url: '/providers/' + providerId + '/toggle-status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_active: newStatus
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Failed to update provider status. Please try again.');
                }
            });
        });

        // Ensure feather icons are initialized
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endpush