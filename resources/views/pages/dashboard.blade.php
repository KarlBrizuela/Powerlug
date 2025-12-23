<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard - Powerlug</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Powerlug" name="description" />
    <meta content="Powerlug" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">
    @include('components.sidebar')
    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- Main Content -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Page Title -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 fw-bold">Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    @if (!auth()->user()->isAdmin())
                    <div class="row mt-4">
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100 hover-card" style="transition: all 0.3s ease;">
                                <div class="card-body text-center p-4">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                        <i class="fas fa-users fa-2x text-primary"></i>
                                    </div>
                                    <h5 class="card-title text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.9rem; letter-spacing: 0.5px;">Total Clients</h5>
                                    <h2 class="fw-bold text-primary mb-0" style="font-size: 2.5rem;">{{ number_format($totalClients ?? 0) }}</h2>
                                    <p class="text-muted small mb-0 mt-2">
                                        <i class="fas fa-arrow-up text-success me-1"></i>
                                        <span class="text-success">12%</span> from last month
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="/collections" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-card" style="transition: all 0.3s ease;">
                                    <div class="card-body text-center p-4">
                                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                            <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                                        </div>
                                        <h5 class="card-title text-muted text-uppercase fw-semibold mb-2" style="font-size: 0.9rem; letter-spacing: 0.5px;">Collection Count</h5>
                                        <h2 class="fw-bold text-success mb-0" style="font-size: 2.5rem;">4</h2>
                                        <p class="text-muted small mb-0 mt-2">
                                            <i class=""></i>
                                            Click to view all
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                       
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100 hover-card" style="cursor: pointer; transition: all 0.3s ease; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="card-body text-center text-white p-4">
                                    <div class="rounded-circle bg-white bg-opacity-25 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                        <i class="fas fa-tasks fa-2x text-white"></i>
                                    </div>
                                    <h5 class="card-title text-uppercase fw-semibold mb-2" style="font-size: 0.9rem; letter-spacing: 0.5px; opacity: 0.95;">Total Policies</h5>
                                    <h2 class="fw-bold mb-0" style="font-size: 2.5rem;">{{ $totalPolicies }}</h2>
                                    <p class="small mb-0 mt-2" style="opacity: 0.9;">
                                        <i class="fas fa-file-contract me-1"></i>
                                        Active policies
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .hover-card {
                            transform: translateY(0);
                        }
                        .hover-card:hover {
                            transform: translateY(-5px);
                            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
                        }
                    </style>
                    @endif

                    <!-- Tables Section -->
                    <div class="row mt-4">
                        <div class="col-xl-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="card-title fw-bold mb-1">
                                                <i class="fas fa-shield-alt text-warning me-2"></i>
                                                Insurance Expiration Reminder
                                            </h5>
                                            <p class="text-muted small mb-0">Upcoming policy renewals</p>
                                        </div>
                                        <a href="{{ route('expiration.reminders') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="fas fa-list me-1"></i>View All
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr class="border-bottom">
                                                    <th class="border-0 text-uppercase text-muted small fw-semibold">Name</th>
                                                    <th class="border-0 text-uppercase text-muted small fw-semibold">Due Date</th>
                                                    <th class="border-0 text-uppercase text-muted small fw-semibold">Contact No.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($expiringPolicies as $policy)
                                                <tr class="align-middle">
                                                    <td>
                                                        <a href="#" class="text-decoration-none d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#insuranceModal" data-policy-id="{{ $policy['id'] }}">
                                                            <div class="avatar-sm rounded-circle {{ $policy['avatar_class'] }} d-flex align-items-center justify-content-center me-2">
                                                                <span class="{{ $policy['avatar_text_class'] }} fw-semibold">{{ $policy['initials'] }}</span>
                                                            </div>
                                                            <span class="fw-medium text-dark">{{ $policy['client_name'] }}</span>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $policy['badge_class'] }}">
                                                            <i class="far fa-calendar-alt me-1"></i>{{ $policy['due_date'] }}
                                                        </span>
                                                    </td>
                                                    <td class="text-muted">{{ $policy['client_phone'] }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted py-4">
                                                        <i class="fas fa-info-circle me-2"></i>No upcoming policy expirations
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-transparent border-0 pt-4 pb-0">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="card-title fw-bold mb-1">
                                                <i class="fas fa-money-check-alt text-success me-2"></i>
                                                Payment Reminders
                                            </h5>
                                            <p class="text-muted small mb-0">Outstanding payments due</p>
                                        </div>
                                        <a href="{{ route('payment.reminders') }}" class="btn btn-sm btn-outline-success rounded-pill">
                                            <i class="fas fa-list me-1"></i>View All
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr class="border-bottom">
                                                    <th class="border-0 text-uppercase text-muted small fw-semibold">Name</th>
                                                    <th class="border-0 text-uppercase text-muted small fw-semibold">Service</th>
                                                    <th class="border-0 text-uppercase text-muted small fw-semibold">Due Date</th>
                                                    <th class="border-0 text-uppercase text-muted small fw-semibold">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($paymentReminders as $reminder)
                                                <tr class="align-middle payment-reminder-row" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#paymentReminderModal" 
                                                    data-reminder='@json($reminder)'>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm rounded-circle {{ $reminder['avatar_class'] }} d-flex align-items-center justify-content-center me-2">
                                                                <span class="fw-semibold {{ $reminder['avatar_text_class'] }}">{{ $reminder['initials'] }}</span>
                                                            </div>
                                                            <span class="fw-medium">{{ $reminder['client_name'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $reminder['service_name'] }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $reminder['badge_class'] }}">
                                                            <i class="far fa-calendar-alt me-1"></i>{{ $reminder['due_date'] }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">{{ $reminder['amount'] }}</span>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">
                                                        <i class="fas fa-inbox me-2"></i>No payment reminders
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .avatar-sm {
                            width: 40px;
                            height: 40px;
                            font-size: 0.85rem;
                        }
                        
                        .table-responsive {
                            overflow-x: visible !important;
                            overflow-y: visible !important;
                        }
                        
                        .table tbody tr {
                            transition: all 0.2s ease;
                        }
                        
                        .table tbody tr:hover {
                            background-color: rgba(0, 0, 0, 0.02);
                        }
                        
                        .badge {
                            padding: 0.4rem 0.7rem;
                            font-weight: 500;
                            font-size: 0.75rem;
                        }
                    </style>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer mt-auto py-3 bg-white border-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <span id="currentYear"></span> © Powerlug.
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
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Insurance Details Modal -->
    <div class="modal fade" id="insuranceModal" tabindex="-1" aria-labelledby="insuranceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem;">
                    <div class="w-100 d-flex align-items-center justify-content-between">
                        <h3 class="mb-0 fw-bold text-dark" id="clientName">John Doe</h3>
                        <span id="insuranceStatus" class="badge bg-white text-dark px-4 py-2 shadow-sm ms-3" style="font-size: 0.9rem; white-space: nowrap;">Upcoming</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background-color: #fafbfc;">
                    <!-- Contact Information Section -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-address-card text-primary"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-0" style="font-size: 1rem;">Contact Information</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Contact Number</label>
                                    <p id="contactNumber" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">091234567891</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Email Address</label>
                                    <p id="emailAddress" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">johndoe@example.com</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Address</label>
                                    <p id="clientAddress" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">123 Main Street, Quezon City</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Insurance Details Section -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-shield-alt text-warning"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-0" style="font-size: 1rem;">Insurance Details</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Insurance Provider</label>
                                    <p id="insuranceProvider" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">Standard Insurance</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Policy Number</label>
                                    <p id="policyNumber" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">POL-2024-001</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Issue Date</label>
                                    <p id="issueDate" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">2024-01-15</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Due Date</label>
                                    <p id="dueDate" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">2024-02-15</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 border-0 shadow-sm" style="background: linear-gradient(135deg, #d4f4dd 0%, #e8f5e9 100%); transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Coverage Amount</label>
                                    <p id="coverageAmount" class="mb-0 fw-bold text-success" style="font-size: 1.3rem;">₱500,000.00</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 border-0 shadow-sm" style="background: linear-gradient(135deg, #d4f4dd 0%, #e8f5e9 100%); transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Amount Due</label>
                                    <p id="amountDue" class="mb-0 fw-bold text-success" style="font-size: 1.3rem;">₱8,500.00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Details Section -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-car text-info"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-0" style="font-size: 1rem;">Vehicle Details</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Plate No.</label>
                                    <p id="plateNumber" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">ABC 123</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Model Year</label>
                                    <p id="modelYear" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">2022</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Color</label>
                                    <p id="vehicleColor" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">Red</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Freebie Section -->
                    <div class="mb-2">
                        <div class="rounded-3 p-4 border-0 shadow-sm d-flex align-items-center" style="background: linear-gradient(135deg, #fff9e6 0%, #fffbf0 100%);">
                            <div class="bg-warning bg-opacity-25 rounded-circle p-3 me-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-gift fa-2x text-warning"></i>
                            </div>
                            <div>
                                <label class="text-muted small mb-1 text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Freebie Included</label>
                                <p id="freebie" class="mb-0 fw-bold text-dark" style="font-size: 1.1rem;">Car Emergency Kit</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-white p-4">
                    <button type="button" class="btn btn-light border rounded-pill px-4 py-2" data-bs-dismiss="modal" style="font-weight: 500;">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm" style="font-weight: 500;">
                        <i class="fas fa-phone me-2"></i>Contact Client
                    </button>
                    <button type="button" id="sendReminderBtn" class="btn btn-success rounded-pill px-4 py-2 shadow-sm" style="font-weight: 500;">
                        <i class="fas fa-envelope me-2"></i>Send Reminder
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Reminder Details Modal -->
    <div class="modal fade" id="paymentReminderModal" tabindex="-1" aria-labelledby="paymentReminderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 bg-gradient" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 2rem;">
                    <div class="w-100 d-flex align-items-center justify-content-between">
                        <h3 class="mb-0 fw-bold text-dark" id="paymentClientName">Client Name</h3>
                        <span id="paymentStatus" class="badge bg-white text-dark px-4 py-2 shadow-sm ms-3" style="font-size: 0.9rem; white-space: nowrap;">Payment Due</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background-color: #fafbfc;">
                    <!-- Client Information Section -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user text-success"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-0" style="font-size: 1rem;">Client Information</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Client Name</label>
                                    <p id="paymentClientNameDetail" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">N/A</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Phone Number</label>
                                    <p id="paymentClientPhone" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">N/A</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Email Address</label>
                                    <p id="paymentClientEmail" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">N/A</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details Section -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-receipt text-info"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-0" style="font-size: 1rem;">Payment Details</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Policy Number</label>
                                    <p id="paymentPolicyNumber" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">N/A</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Service</label>
                                    <p id="paymentServiceName" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">N/A</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 border-0 shadow-sm" style="background: linear-gradient(135deg, #d4f4dd 0%, #e8f5e9 100%); transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Service Amount</label>
                                    <p id="paymentServiceAmount" class="mb-0 fw-bold text-success" style="font-size: 1.2rem;">₱0.00</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Due Date</label>
                                    <p id="paymentDueDate" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">N/A</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Payment Status</label>
                                    <p id="paymentStatusBadge" class="mb-0">
                                        <span class="badge bg-danger" style="font-size: 0.85rem;">Unpaid</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Policy Amount Due</label>
                                    <p id="paymentAmountDue" class="mb-0 fw-semibold text-danger" style="font-size: 1rem;">₱0.00</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Policy Paid Amount</label>
                                    <p id="paymentPaidAmount" class="mb-0 fw-semibold text-success" style="font-size: 1rem;">₱0.00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Details Section -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-car text-danger"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-0" style="font-size: 1rem;">Vehicle Details</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Plate No.</label>
                                    <p id="paymentPlateNumber" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">N/A</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Model Year</label>
                                    <p id="paymentModelYear" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">N/A</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card p-3 rounded-3 bg-white border" style="transition: all 0.2s;">
                                    <label class="text-muted small mb-2 text-uppercase" style="font-weight: 600; font-size: 0.7rem; letter-spacing: 0.5px;">Color</label>
                                    <p id="paymentVehicleColor" class="mb-0 fw-semibold text-dark" style="font-size: 1rem;">N/A</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attachments Section -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-2" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-paperclip text-secondary"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-0" style="font-size: 1rem;">Attachments</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="border-2 border-dashed rounded-3 p-4 bg-light" id="dropZone" style="cursor: pointer; transition: all 0.2s; border-color: #dee2e6;">
                                    <input type="file" id="paymentAttachmentInput" multiple accept=".jpg,.jpeg,.png,.gif,.webp" style="display: none;">
                                    <div class="text-center">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3 d-block" style="opacity: 0.6;"></i>
                                        <p class="text-muted mb-2">
                                            <span id="attachmentText">Drag and drop files here or <strong style="color: #0d6efd; cursor: pointer;">click to browse</strong></span>
                                        </p>
                                        <small class="text-muted d-block">Supported: JPG, JPEG, PNG, GIF, WebP (Max 4+ files, 5MB each)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="attachmentsList" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="text-muted small mb-0 text-uppercase fw-bold">Selected Files:</label>
                                        <button type="button" id="clearAttachments" class="btn btn-sm btn-link text-danger p-0" style="font-size: 0.85rem;">Clear All</button>
                                    </div>
                                    <div id="attachmentsPreview" class="d-flex flex-wrap gap-2"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="uploadedAttachmentsList" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="text-muted small mb-0 text-uppercase fw-bold">Uploaded Files:</label>
                                    </div>
                                    <div id="uploadedAttachmentsContainer" class="d-flex flex-wrap gap-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-white p-4">
                    <button type="button" class="btn btn-light border rounded-pill px-4 py-2" data-bs-dismiss="modal" style="font-weight: 500;">
                        Close
                    </button>
                    <button type="button" id="uploadAttachmentsBtn" class="btn btn-warning rounded-pill px-4 py-2 shadow-sm" style="font-weight: 500;">
                        <i class="fas fa-upload me-2"></i>Upload Attachments
                    </button>
                    <a href="#" id="viewPolicyLink" class="btn btn-info rounded-pill px-4 py-2 shadow-sm" style="font-weight: 500; color: white;">
                        <i class="fas fa-eye me-2"></i>View Full Policy
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Composition Modal -->
    <div class="modal fade" id="emailCompositionModal" tabindex="-1" aria-labelledby="emailCompositionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem;">
                    <h5 class="modal-title fw-bold text-white" id="emailCompositionModalLabel">
                        <i class="fas fa-envelope me-2"></i>Compose Reminder Email
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background-color: #fafbfc;">
                    <form id="emailCompositionForm">
                        <!-- Client Info Display -->
                        <div class="mb-4">
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>To:</strong> <span id="emailRecipient">N/A</span>
                                <br>
                                <small class="text-muted">Client: <span id="emailClientName">N/A</span></small>
                            </div>
                        </div>

                        <!-- Subject Field -->
                        <div class="mb-4">
                            <label for="emailSubject" class="form-label fw-semibold">Email Subject</label>
                            <input type="text" class="form-control form-control-lg" id="emailSubject" 
                                   placeholder="Enter email subject" required>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-lightbulb me-1"></i>Make it clear and professional
                            </small>
                        </div>

                        <!-- Email Body Field -->
                        <div class="mb-4">
                            <label for="emailBody" class="form-label fw-semibold">Email Message</label>
                            <textarea class="form-control" id="emailBody" rows="12" 
                                      placeholder="Enter email message" required 
                                      style="font-family: monospace; resize: vertical;"></textarea>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-pencil-alt me-1"></i>Edit the message as needed. You can use HTML for formatting.
                            </small>
                        </div>

                        <!-- Preview Button -->
                        <div class="mb-4">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="previewEmailBtn">
                                <i class="fas fa-eye me-2"></i>Preview Email
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 bg-white p-4">
                    <button type="button" class="btn btn-light border rounded-pill px-4 py-2" data-bs-dismiss="modal" style="font-weight: 500;">
                        Cancel
                    </button>
                    <button type="button" id="sendCustomEmailBtn" class="btn btn-success rounded-pill px-4 py-2 shadow-sm" style="font-weight: 500;">
                        <i class="fas fa-paper-plane me-2"></i>Send Email
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Preview Modal -->
    <div class="modal fade" id="emailPreviewModal" tabindex="-1" aria-labelledby="emailPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-bottom bg-light">
                    <h5 class="modal-title fw-bold" id="emailPreviewModalLabel">
                        <i class="fas fa-envelope-open me-2"></i>Email Preview
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="mb-3 pb-3 border-bottom">
                                <small class="text-muted text-uppercase">From:</small>
                                <p class="mb-0">noreply@powerlug.com</p>
                            </div>
                            <div class="mb-3 pb-3 border-bottom">
                                <small class="text-muted text-uppercase">To:</small>
                                <p class="mb-0" id="previewEmailRecipient">N/A</p>
                            </div>
                            <div class="mb-3 pb-3 border-bottom">
                                <small class="text-muted text-uppercase">Subject:</small>
                                <p class="mb-0 fw-bold" id="previewEmailSubject">N/A</p>
                            </div>
                            <div class="mt-4">
                                <small class="text-muted text-uppercase d-block mb-3">Message:</small>
                                <div id="previewEmailBody" style="background-color: white; padding: 20px; border-radius: 5px; border: 1px solid #dee2e6; min-height: 300px; line-height: 1.6;">
                                    <!-- Email body will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-white p-4">
                    <button type="button" class="btn btn-light border rounded-pill px-4 py-2" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        }

        .payment-reminder-row {
            transition: all 0.3s ease;
        }

        .payment-reminder-row:hover {
            background-color: #f8f9fa;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
    </style>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script>
        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();

        // Policy data from backend
        const policyData = {
            @foreach($expiringPolicies as $policy)
            {{ $policy['id'] }}: {
                name: "{{ $policy['client_name'] }}",
                status: "{{ $policy['status'] }}",
                contactNumber: "{{ $policy['client_phone'] }}",
                emailAddress: "{{ $policy['client_email'] }}",
                insuranceProvider: "{{ $policy['insurance_provider'] }}",
                policyNumber: "{{ $policy['policy_number'] }}",
                dueDate: "{{ $policy['date_end'] }}",
                coverageAmount: "{{ $policy['coverage_amount'] }}",
                clientAddress: "{{ $policy['client_address'] }}",
                plateNumber: "{{ $policy['plate_number'] }}",
                modelYear: "{{ $policy['model_year'] }}",
                vehicleColor: "{{ $policy['color'] }}",
                amountDue: "{{ $policy['amount_due'] }}",
                issueDate: "{{ $policy['date_start'] }}",
                freebie: "{{ $policy['freebie'] }}"
            },
            @endforeach
        };

        // Variable to store the current policy ID for attachment uploads
        let currentPolicyId = null;

        // Handle modal display when a name is clicked
        $(document).ready(function() {
            $('a[data-bs-target="#insuranceModal"]').click(function() {
                const policyId = $(this).data('policy-id');
                const policy = policyData[policyId];
                
                // Store policy ID for later use (like sending reminders)
                currentPolicyId = policyId;
                
                if (policy) {
                    $('#clientName').text(policy.name);
                    $('#contactNumber').text(policy.contactNumber);
                    $('#emailAddress').text(policy.emailAddress);
                    $('#insuranceProvider').text(policy.insuranceProvider);
                    $('#policyNumber').text(policy.policyNumber);
                    $('#dueDate').text(policy.dueDate);
                    $('#coverageAmount').text(policy.coverageAmount);
                    $('#clientAddress').text(policy.clientAddress);
                    $('#plateNumber').text(policy.plateNumber);
                    $('#modelYear').text(policy.modelYear);
                    $('#vehicleColor').text(policy.vehicleColor);
                    $('#amountDue').text(policy.amountDue);
                    $('#issueDate').text(policy.issueDate);
                    $('#freebie').text(policy.freebie);
                    
                    const statusBadge = $('#insuranceStatus');
                    statusBadge.text(policy.status);
                    
                    // Update badge color based on status
                    statusBadge.removeClass('bg-white bg-warning bg-danger bg-success bg-info text-dark text-white');
                    
                    if (policy.status === 'Overdue') {
                        statusBadge.addClass('bg-danger text-white');
                    } else if (policy.status === 'Critical') {
                        statusBadge.addClass('bg-danger text-white');
                    } else if (policy.status === 'Upcoming') {
                        statusBadge.addClass('bg-white text-dark');
                    } else {
                        statusBadge.addClass('bg-white text-dark');
                    }
                }
            });

            // Handle Send Reminder button click - show composition modal
            $('#sendReminderBtn').on('click', function() {
                if (!currentPolicyId) {
                    alert('Policy ID not found. Please close and reopen the modal.');
                    return;
                }

                const policy = policyData[currentPolicyId];
                if (!policy) return;

                // Populate the composition modal
                $('#emailRecipient').text(policy.emailAddress);
                $('#emailClientName').text(policy.name);
                
                // Generate default email content
                const defaultSubject = 'Insurance Policy Renewal Reminder - ' + policy.policyNumber;
                const defaultBody = `Dear ${policy.name},

We hope this message finds you well. This is a friendly reminder that your insurance policy is due for renewal soon.

POLICY DETAILS:
Policy Number: ${policy.policyNumber}
Insurance Provider: ${policy.insuranceProvider}
Renewal Due Date: ${policy.dueDate}
Coverage Amount: ₱${parseFloat(policy.coverageAmount).toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2})}
Vehicle Plate Number: ${policy.plateNumber}
Vehicle Model Year: ${policy.modelYear}
Vehicle Color: ${policy.vehicleColor}

Please ensure that your policy is renewed before the due date to avoid any coverage gaps. If you have any questions or need assistance with the renewal process, please don't hesitate to contact us.

Thank you for your business!

Best regards,
Powerlug Team`;

                $('#emailSubject').val(defaultSubject);
                $('#emailBody').val(defaultBody);

                // Close insurance modal and open composition modal
                bootstrap.Modal.getInstance(document.getElementById('insuranceModal')).hide();
                new bootstrap.Modal(document.getElementById('emailCompositionModal')).show();
            });

            // Handle Preview Email button
            $('#previewEmailBtn').on('click', function() {
                const subject = $('#emailSubject').val();
                const body = $('#emailBody').val();
                const recipient = $('#emailRecipient').text();

                if (!subject || !body) {
                    alert('Please fill in both subject and message.');
                    return;
                }

                // Populate preview modal
                $('#previewEmailSubject').text(subject);
                $('#previewEmailRecipient').text(recipient);
                
                // Display body as HTML (with line breaks converted to <br>)
                const bodyHtml = body.replace(/\n/g, '<br>').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                $('#previewEmailBody').html(bodyHtml);

                // Show preview modal
                bootstrap.Modal.getInstance(document.getElementById('emailCompositionModal')).hide();
                new bootstrap.Modal(document.getElementById('emailPreviewModal')).show();
            });

            // Handle Send Custom Email button
            $('#sendCustomEmailBtn').on('click', function() {
                const subject = $('#emailSubject').val();
                const body = $('#emailBody').val();

                if (!subject || !body) {
                    alert('Please fill in both subject and message.');
                    return;
                }

                // Show loading state
                const btn = $(this);
                const originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...');

                // Send AJAX request to backend with custom content
                $.ajax({
                    url: '/api/send-insurance-reminder',
                    type: 'POST',
                    data: {
                        policy_id: currentPolicyId,
                        subject: subject,
                        body: body
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        
                        if (response.success) {
                            // Close all modals properly
                            const emailCompositionModal = bootstrap.Modal.getInstance(document.getElementById('emailCompositionModal'));
                            if (emailCompositionModal) {
                                emailCompositionModal.hide();
                            }
                            
                            // Reset the form
                            $('#emailCompositionForm')[0].reset();
                            
                            // Show success message with more details
                            const successMsg = response.message + '\n\n✅ Check storage/logs/email_reminders_' + new Date().toISOString().split('T')[0] + '.log to view the email details.';
                            alert(successMsg);
                            
                            // Remove modal backdrops that might be stuck
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(originalHtml);
                        
                        let errorMessage = 'Error sending reminder email.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        // Remove modal backdrops that might be stuck
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        
                        alert(errorMessage);
                    },
                    complete: function() {
                        // Final cleanup to ensure page is responsive
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                    }
                });
            });

            // Pending tasks data
            const pendingTasksData = {
                insurancePolicies: 8,
                walkIns: 7
            };

            // Update pending tasks modal when opened
            $('#pendingTasksModal').on('show.bs.modal', function () {
                $('#insurancePolicyCount').text(pendingTasksData.insurancePolicies);
                $('#walkInCount').text(pendingTasksData.walkIns);
                $('#totalTasksCount').text(pendingTasksData.insurancePolicies + pendingTasksData.walkIns);
            });

            // Payment Reminder Modal Handler
            $('#paymentReminderModal').on('show.bs.modal', function (e) {
                const triggerButton = $(e.relatedTarget); // Button that triggered the modal
                const reminderData = triggerButton.data('reminder'); // Extract info from data-reminder attribute
                
                // Store the policy ID for attachment uploads
                if (reminderData) {
                    currentPolicyId = reminderData.id;
                }
                
                if (reminderData) {
                    // Populate client information
                    $('#paymentClientName').text(reminderData.client_name);
                    $('#paymentClientNameDetail').text(reminderData.client_name);
                    $('#paymentClientPhone').text(reminderData.client_phone);
                    $('#paymentClientEmail').text(reminderData.client_email);
                    
                    // Populate payment details
                    $('#paymentPolicyNumber').text(reminderData.policy_number);
                    $('#paymentServiceName').text(reminderData.service_name);
                    $('#paymentServiceAmount').text(reminderData.service_amount);
                    $('#paymentAmountDue').text(reminderData.amount_due);
                    $('#paymentPaidAmount').text(reminderData.paid_amount);
                    $('#paymentDueDate').text(reminderData.due_date);
                    
                    // Populate vehicle details
                    $('#paymentPlateNumber').text(reminderData.plate_number);
                    $('#paymentModelYear').text(reminderData.model_year);
                    $('#paymentVehicleColor').text(reminderData.color);
                    
                    // Update payment status badge
                    const statusBadgeHtml = reminderData.is_service_paid ? 
                        '<span class="badge bg-success" style="font-size: 0.85rem;"><i class="fas fa-check me-1"></i>Paid</span>' :
                        '<span class="badge bg-danger" style="font-size: 0.85rem;"><i class="fas fa-clock me-1"></i>Unpaid</span>';
                    $('#paymentStatusBadge').html(statusBadgeHtml);
                    
                    // Update status badge
                    const statusBadge = $('#paymentStatus');
                    statusBadge.text(reminderData.service_name);
                    
                    // Update View Full Policy link
                    $('#viewPolicyLink').attr('href', '/policies/' + reminderData.id);
                }
                
                // Reset attachments when modal opens
                $('#paymentAttachmentInput').val('');
                $('#attachmentsList').hide();
                $('#attachmentsPreview').empty();
                
                // Load uploaded attachments
                loadUploadedAttachments(currentPolicyId);
            });
            
            // Function to load and display uploaded attachments
            function loadUploadedAttachments(policyId) {
                // Fetch policy data to get attachments
                $.ajax({
                    url: '/api/policies/' + policyId + '/payment-attachments',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        const uploadedAttachmentsList = $('#uploadedAttachmentsList');
                        const uploadedAttachmentsContainer = $('#uploadedAttachmentsContainer');
                        
                        // Get attachments from response
                        const attachments = response.attachments || [];
                        
                        uploadedAttachmentsContainer.empty();
                        
                        if (attachments.length > 0) {
                            uploadedAttachmentsList.show();
                            
                            attachments.forEach((attachment, index) => {
                                const fileIcon = getFileIcon(attachment.mime_type || '');
                                const filename = attachment.name || 'Unknown File';
                                const filePath = attachment.file_path;
                                const imageUrl = '/' + filePath;
                                
                                const attachmentElement = $(`
                                    <div class="position-relative" style="flex: 0 0 calc(50% - 4px); min-width: 150px;">
                                        <div class="rounded-2 border bg-light overflow-hidden" style="height: 150px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s;">
                                            <img src="${imageUrl}" alt="${filename}" style="max-width: 100%; max-height: 100%; object-fit: cover; width: 100%; height: 100%;" class="img-thumbnail-preview" data-image-url="${imageUrl}" data-filename="${filename}">
                                        </div>
                                        <small class="d-block text-center text-muted mt-2 fw-semibold" style="font-size: 0.75rem; word-break: break-word;">${truncateFilename(filename, 15)}</small>
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0 position-absolute top-0 end-0 m-1 delete-uploaded-file" data-index="${index}" data-policy-id="${policyId}" style="font-size: 0.8rem; background: rgba(255,255,255,0.9); border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                `);
                                
                                uploadedAttachmentsContainer.append(attachmentElement);
                            });
                            
                            // Add click handler to view full image (remove old handlers first to prevent duplicates)
                            uploadedAttachmentsContainer.off('click', '.img-thumbnail-preview');
                            uploadedAttachmentsContainer.on('click', '.img-thumbnail-preview', function(e) {
                                e.stopPropagation();
                                const imageUrl = $(this).data('image-url');
                                const filename = $(this).data('filename');
                                
                                const modal = $(`
                                    <div class="modal fade" tabindex="-1" aria-hidden="true" style="--bs-modal-bg: #000; --bs-modal-border-color: #000;">
                                        <div class="modal-dialog modal-fullscreen">
                                            <div class="modal-content border-0" style="background-color: #1a1a1a;">
                                                <div class="modal-header border-bottom border-secondary bg-dark">
                                                    <h6 class="modal-title fw-semibold text-white">${filename}</h6>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-0 bg-dark d-flex align-items-center justify-content-center" style="height: calc(100vh - 60px);">
                                                    <img src="${imageUrl}" alt="${filename}" style="max-width: 95%; max-height: 95%; object-fit: contain;" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);
                                
                                // Prevent clicks inside modal from bubbling to parent handlers
                                modal.on('click', function(e) {
                                    e.stopPropagation();
                                });
                                
                                modal.appendTo('body');
                                const bsModal = new bootstrap.Modal(modal[0]);
                                bsModal.show();
                                
                                modal.on('hidden.bs.modal', function() {
                                    $(this).remove();
                                });
                            });
                        } else {
                            uploadedAttachmentsList.hide();
                        }
                    },
                    error: function() {
                        // Silently fail - don't show error for now
                        $('#uploadedAttachmentsList').hide();
                    }
                });
            }

            // File Attachment Handling
            const dropZone = $('#dropZone');
            const fileInput = $('#paymentAttachmentInput');
            const attachmentsList = $('#attachmentsList');
            const attachmentsPreview = $('#attachmentsPreview');
            let isProcessingFiles = false;

            // Click to browse - prevent recursion by stopping propagation on file input
            fileInput.on('click', function(e) {
                e.stopPropagation();
            });

            dropZone.click(function(e) {
                // Only trigger file input click if the click was directly on the dropzone, not on file input
                if (e.target === this || e.target.closest('#dropZone') === this) {
                    fileInput.click();
                }
            });

            // Drag and drop
            dropZone.on('dragover dragenter', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.css('border-color', '#0d6efd').css('background-color', '#f0f6ff');
            });

            dropZone.on('dragleave', function(e) {
                e.preventDefault();
                dropZone.css('border-color', '#dee2e6').css('background-color', '');
            });

            dropZone.on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.css('border-color', '#dee2e6').css('background-color', '');
                
                const files = e.originalEvent.dataTransfer.files;
                fileInput[0].files = files;
                displayFiles(files);
            });

            // File input change
            fileInput.on('change', function() {
                displayFiles(this.files);
            });

            // Display files function
            function displayFiles(files) {
                if (files.length === 0) {
                    attachmentsList.hide();
                    attachmentsPreview.empty();
                    return;
                }

                attachmentsList.show();
                attachmentsPreview.empty();

                Array.from(files).forEach((file, index) => {
                    const fileSize = (file.size / 1024).toFixed(2); // Convert to KB
                    const fileIcon = getFileIcon(file.type);
                    
                    const fileElement = $(`
                        <div class="p-2 rounded-2 bg-white border" style="flex: 0 0 calc(50% - 4px); min-width: 150px;">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="d-flex align-items-start flex-grow-1 me-2">
                                    <i class="fas ${fileIcon} text-primary me-2" style="margin-top: 2px; font-size: 1.1rem;"></i>
                                    <div style="min-width: 0;">
                                        <small class="d-block fw-semibold text-dark" style="word-break: break-word; font-size: 0.8rem;">${truncateFilename(file.name, 20)}</small>
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">${fileSize} KB</small>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-1 remove-file" data-index="${index}" style="font-size: 0.9rem;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    `);

                    attachmentsPreview.append(fileElement);
                });
            }

            // Get file icon based on MIME type
            function getFileIcon(mimeType) {
                if (mimeType.includes('pdf')) return 'fa-file-pdf';
                if (mimeType.includes('word') || mimeType.includes('document')) return 'fa-file-word';
                if (mimeType.includes('spreadsheet') || mimeType.includes('excel')) return 'fa-file-excel';
                if (mimeType.includes('image')) return 'fa-file-image';
                if (mimeType.includes('text')) return 'fa-file-alt';
                if (mimeType.includes('zip') || mimeType.includes('compressed')) return 'fa-file-archive';
                return 'fa-file';
            }

            // Truncate long filenames
            function truncateFilename(filename, maxLength) {
                // Handle undefined or null filename
                if (!filename) return 'Unknown File';
                
                filename = String(filename); // Ensure it's a string
                
                if (filename.length <= maxLength) return filename;
                const extension = filename.substring(filename.lastIndexOf('.'));
                const nameWithoutExt = filename.substring(0, filename.lastIndexOf('.'));
                return nameWithoutExt.substring(0, maxLength - extension.length - 3) + '...' + extension;
            }

            // Clear all attachments
            $('#clearAttachments').on('click', function() {
                fileInput.val('');
                attachmentsList.hide();
                attachmentsPreview.empty();
            });

            // Remove individual file using event delegation
            attachmentsPreview.on('click', '.remove-file', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Prevent multiple simultaneous file operations
                if (isProcessingFiles) return;
                isProcessingFiles = true;
                
                const index = $(this).data('index');
                
                // Use setTimeout to break the call stack
                setTimeout(() => {
                    try {
                        const dt = new DataTransfer();
                        const input = fileInput[0];
                        
                        Array.from(input.files).forEach((file, i) => {
                            if (i !== index) {
                                dt.items.add(file);
                            }
                        });
                        
                        input.files = dt.files;
                        displayFiles(input.files);
                    } finally {
                        isProcessingFiles = false;
                    }
                }, 0);
            });

            // Upload attachments button handler
            $('#uploadAttachmentsBtn').on('click', function() {
                const files = fileInput[0].files;
                
                if (files.length === 0) {
                    alert('Please select at least one file to upload.');
                    return;
                }

                if (!currentPolicyId) {
                    alert('Policy ID not found. Please close and reopen the modal.');
                    return;
                }

                // Create FormData and append files
                const formData = new FormData();
                formData.append('policy_id', currentPolicyId);

                Array.from(files).forEach((file) => {
                    formData.append('attachments[]', file);
                });

                // Show loading state
                const btn = $('#uploadAttachmentsBtn');
                const originalText = btn.html();
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Uploading...');

                // Submit files
                $.ajax({
                    url: '/policies/upload-payment-attachments',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalText);
                        
                        if (response.success) {
                            alert(response.message);
                            // Clear the file input and preview
                            fileInput.val('');
                            attachmentsList.hide();
                            attachmentsPreview.empty();
                            
                            // Reload uploaded attachments
                            loadUploadedAttachments(currentPolicyId);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(originalText);
                        
                        let errorMessage = 'Error uploading files.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            });
            
            // Delete uploaded attachment
            $(document).on('click', '.delete-uploaded-file', function() {
                const index = $(this).data('index');
                const policyId = $(this).data('policy-id');
                
                console.log('Delete button clicked:', {index, policyId, url: '/policies/' + policyId + '/payment-attachment/' + index});
                
                if (confirm('Are you sure you want to delete this attachment?')) {
                    $.ajax({
                        url: '/policies/' + policyId + '/payment-attachment/' + index,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Delete success:', response);
                            if (response.success) {
                                alert('Attachment deleted successfully.');
                                loadUploadedAttachments(policyId);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Delete error:', {status, error, responseText: xhr.responseText, statusCode: xhr.status});
                            alert('Error deleting attachment: ' + xhr.status + ' ' + error);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>