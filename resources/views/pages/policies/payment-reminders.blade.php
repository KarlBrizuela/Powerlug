<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment Reminders</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .main-content {
            margin-left: 280px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }

        .page-header {
            background: white;
            color: #333;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background: white;
            color: #333;
            border-bottom: 2px solid #dee2e6;
        }

        .table thead th {
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .badge {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 50px;
        }

        .btn-action {
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .btn-group .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.8rem;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
            color: #6c757d;
            transition: all 0.2s ease;
        }

        .btn-group .btn:hover {
            background-color: #e2e6ea;
            border-color: #adb5bd;
        }

        .btn-group .btn.active {
            font-weight: 600;
        }

        .btn-group .btn[data-action="mark-unpaid"].active {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .btn-group .btn[data-action="mark-paid"].active {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }

        .payment-status-badge {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 50px;
            display: inline-block;
        }

        .payment-status-badge.bg-unpaid {
            background-color: #dc3545;
            color: white;
        }

        .payment-status-badge.bg-paid {
            background-color: #28a745;
            color: white;
        }        .contact-item i {
            width: 18px;
            margin-right: 0.5rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('components.sidebar')
        
        <!-- Main content -->
        <main class="main-content flex-grow-1">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-2">
                                <i class="fas fa-money-check-alt me-2"></i>
                                Payment Reminders
                            </h2>
                            <p class="mb-0 opacity-75">Manage outstanding payments and service payment dues</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Table Card -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Service</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allPaymentReminders as $reminder)
                                    <tr>
                                        <td>
                                            <strong>{{ $reminder['client_name'] }}</strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $reminder['service_name'] }}</small>
                                        </td>
                                        <td>
                                            @if($reminder['due_date'] !== 'N/A')
                                                <i class="far fa-calendar-alt me-2 text-muted"></i>
                                                {{ $reminder['due_date'] }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $reminder['amount'] }}</strong>
                                        </td>
                                        <td>
                                            <i class="fas fa-phone me-2 text-muted"></i>
                                            {{ $reminder['client_phone'] }}
                                        </td>
                                        <td>
                                            <i class="fas fa-envelope me-2 text-muted"></i>
                                            <small>{{ $reminder['client_email'] }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="badge {{ $reminder['status_class'] }} text-white">
                                                    {{ $reminder['status'] }}
                                                </span>
                                                <small class="text-muted">
                                                    <i class="far fa-clock me-1"></i>{{ $reminder['days_text'] }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge payment-status-badge" id="payment-status-{{ $reminder['id'] }}-{{ $reminder['service_name'] }}"
                                                  data-paid-status="{{ $reminder['paid_status'] }}">
                                                <i class="fas fa-circle me-1"></i><span class="status-text">{{ ucfirst($reminder['paid_status']) }}</span>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Payment Status">
                                                <button type="button" class="btn btn-sm payment-toggle-btn" 
                                                        data-reminder-id="{{ $reminder['id'] }}" 
                                                        data-service="{{ $reminder['service_name'] }}"
                                                        data-action="mark-unpaid"
                                                        data-service-index="{{ $reminder['service_index'] }}"
                                                        title="Mark as Unpaid">
                                                    <i class="fas fa-times me-1"></i>Unpaid
                                                </button>
                                                <button type="button" class="btn btn-sm payment-toggle-btn" 
                                                        data-reminder-id="{{ $reminder['id'] }}" 
                                                        data-service="{{ $reminder['service_name'] }}"
                                                        data-action="mark-paid"
                                                        data-service-index="{{ $reminder['service_index'] }}"
                                                        title="Mark as Paid">
                                                    <i class="fas fa-check me-1"></i>Paid
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No payment reminders found</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize button states and badge styles
            initializeButtonStates();
            initializeBadgeStyles();

            // Handle payment toggle buttons
            $('.payment-toggle-btn').click(function() {
                const policyId = $(this).data('reminder-id');
                const serviceName = $(this).data('service');
                const action = $(this).data('action');
                const serviceIndex = $(this).data('service-index');
                const $btn = $(this);
                const $btnGroup = $btn.closest('.btn-group');

                let confirmMsg = action === 'mark-paid' ? 
                    'Mark ' + serviceName + ' as paid?' : 
                    'Mark ' + serviceName + ' as unpaid?';

                if (confirm(confirmMsg)) {
                    $.ajax({
                        url: '{{ route("api.mark-payment-paid") }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            policy_id: policyId,
                            service_name: serviceName,
                            action: action,
                            service_index: serviceIndex
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update button states
                                $btnGroup.find('.btn').removeClass('active');
                                if (action === 'mark-paid') {
                                    $btnGroup.find('[data-action="mark-paid"]').addClass('active');
                                } else {
                                    $btnGroup.find('[data-action="mark-unpaid"]').addClass('active');
                                }

                                // Update payment status badge
                                const statusBadgeId = 'payment-status-' + policyId + '-' + serviceName;
                                const $statusBadge = $('#' + statusBadgeId);
                                
                                $statusBadge.removeClass('bg-unpaid bg-paid');
                                if (action === 'mark-paid') {
                                    $statusBadge.addClass('bg-paid');
                                    $statusBadge.find('.status-text').text('Paid');
                                } else {
                                    $statusBadge.addClass('bg-unpaid');
                                    $statusBadge.find('.status-text').text('Unpaid');
                                }

                                // Show success message
                                const alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                    '<i class="fas fa-check-circle me-2"></i>' + response.message +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                                    '</div>';
                                $('.page-header').after(alertHtml);

                                // Reload page after 1.5 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function() {
                            alert('An error occurred. Please try again.');
                        }
                    });
                }
            });

            function initializeButtonStates() {
                $('.btn-group').each(function() {
                    const paidStatus = $(this).closest('tr').find('.payment-status-badge').data('paid-status');
                    $(this).find('.btn').removeClass('active');
                    
                    if (paidStatus === 'paid') {
                        $(this).find('[data-action="mark-paid"]').addClass('active');
                    } else {
                        $(this).find('[data-action="mark-unpaid"]').addClass('active');
                    }
                });
            }

            function initializeBadgeStyles() {
                $('.payment-status-badge').each(function() {
                    const paidStatus = $(this).data('paid-status');
                    $(this).removeClass('bg-unpaid bg-paid');
                    
                    if (paidStatus === 'paid') {
                        $(this).addClass('bg-paid');
                    } else {
                        $(this).addClass('bg-unpaid');
                    }
                });
            }
        });
    </script>
</body>
</html>
