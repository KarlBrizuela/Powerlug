<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard - Powerlug</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Powerlug" name="description" />
    <meta content="Powerlug" name="author" />
    
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
                            <div class="card border-0 shadow-sm h-100 hover-card" data-bs-toggle="modal" data-bs-target="#pendingTasksModal" style="cursor: pointer; transition: all 0.3s ease; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="card-body text-center text-white p-4">
                                    <div class="rounded-circle bg-white bg-opacity-25 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                        <i class="fas fa-tasks fa-2x text-white"></i>
                                    </div>
                                    <h5 class="card-title text-uppercase fw-semibold mb-2" style="font-size: 0.9rem; letter-spacing: 0.5px; opacity: 0.95;">Pending Tasks</h5>
                                    <h2 class="fw-bold mb-0" style="font-size: 2.5rem;">15</h2>
                                    <p class="small mb-0 mt-2" style="opacity: 0.9;">
                                        <i class="fas fa-clock me-1"></i>
                                        Click to view details
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
                                        <a href="#" class="btn btn-sm btn-outline-success rounded-pill">
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
                                                    <th class="border-0 text-uppercase text-muted small fw-semibold">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="align-middle">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                                                <span class="text-primary fw-semibold">JS</span>
                                                            </div>
                                                            <span class="fw-medium">Jane Smith</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">
                                                            <i class="far fa-calendar-alt me-1"></i>2024-02-20
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">₱8,900.00</span>
                                                    </td>
                                                </tr>
                                                <tr class="align-middle">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                                                <span class="text-info fw-semibold">SW</span>
                                                            </div>
                                                            <span class="fw-medium">Sarah Williams</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info bg-opacity-10 text-info border border-info">
                                                            <i class="far fa-calendar-alt me-1"></i>2024-02-25
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">₱6,750.00</span>
                                                    </td>
                                                </tr>
                                                <tr class="align-middle">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                                                <span class="text-danger fw-semibold">CL</span>
                                                            </div>
                                                            <span class="fw-medium">Christopher Lee</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">
                                                            <i class="far fa-calendar-alt me-1"></i>2024-02-12
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">₱12,300.00</span>
                                                    </td>
                                                </tr>
                                                <tr class="align-middle">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                                                <span class="text-success fw-semibold">AT</span>
                                                            </div>
                                                            <span class="fw-medium">Amanda Taylor</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">
                                                            <i class="far fa-calendar-alt me-1"></i>2024-02-16
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">₱9,500.00</span>
                                                    </td>
                                                </tr>
                                                <tr class="align-middle">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                                                <span class="text-secondary fw-semibold">JM</span>
                                                            </div>
                                                            <span class="fw-medium">James Martinez</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info bg-opacity-10 text-info border border-info">
                                                            <i class="far fa-calendar-alt me-1"></i>2024-02-24
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">₱7,200.00</span>
                                                    </td>
                                                </tr>
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
                    <button type="button" class="btn btn-success rounded-pill px-4 py-2 shadow-sm" style="font-weight: 500;">
                        <i class="fas fa-envelope me-2"></i>Send Reminder
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
    </style>

    <!-- Pending Tasks Modal -->
    <div class="modal fade" id="pendingTasksModal" tabindex="-1" aria-labelledby="pendingTasksModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="pendingTasksModalLabel">Pending Tasks Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-md-6 mb-4">
                            <div class="p-3 border rounded bg-light">
                                <i class="fas fa-file-contract fa-3x text-primary mb-3"></i>
                                <h4>Insurance Policies</h4>
                                <h2 class="text-primary fw-bold" id="insurancePolicyCount">8</h2>
                                <p class="text-muted">Pending for review</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="p-3 border rounded bg-light">
                                <i class="fas fa-walking fa-3x text-success mb-3"></i>
                                <h4>Walk-ins</h4>
                                <h2 class="text-success fw-bold" id="walkInCount">7</h2>
                                <p class="text-muted">Waiting for processing</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Total Pending Tasks:</strong> <span id="totalTasksCount">15</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-list me-1"></i> View All Tasks
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script>
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

        // Handle modal display when a name is clicked
        $(document).ready(function() {
            $('a[data-bs-target="#insuranceModal"]').click(function() {
                const policyId = $(this).data('policy-id');
                const policy = policyData[policyId];
                
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
        });
    </script>
</body>
</html>