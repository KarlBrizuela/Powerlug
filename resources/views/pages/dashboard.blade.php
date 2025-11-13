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
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="text-primary mb-3">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                    <h5 class="card-title text-muted">Total Customers</h5>
                                    <h2 class="fw-bold text-primary">1,234</h2>
                                    
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-0 bg-primary text-white shadow-sm h-100" data-bs-toggle="modal" data-bs-target="#pendingTasksModal" style="cursor: pointer;">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-tasks fa-2x"></i>
                                    </div>
                                    <h5 class="card-title mb-3">Pending Tasks</h5>
                                    <h2 class="fw-bold">15</h2>
                                    <p>Click to view details</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tables Section -->
                    <div class="row mt-4">
                        <div class="col-xl-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title fw-bold mb-0">Insurance Expiration Reminder</h5>
                                        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Due Date</th>
                                                    <th>Contact No.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><a href="#" class="text-primary text-decoration-none fw-medium" data-bs-toggle="modal" data-bs-target="#insuranceModal" data-id="1">John Doe</a></td>
                                                    <td>2024-02-15</td>
                                                    <td>091234567891</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="#" class="text-primary text-decoration-none fw-medium" data-bs-toggle="modal" data-bs-target="#insuranceModal" data-id="2">Michael Johnson</a></td>
                                                    <td>2024-02-10</td>
                                                    <td>091234567891</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="#" class="text-primary text-decoration-none fw-medium" data-bs-toggle="modal" data-bs-target="#insuranceModal" data-id="3">Robert Brown</a></td>
                                                    <td>2024-02-18</td>
                                                    <td>091234567891</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="#" class="text-primary text-decoration-none fw-medium" data-bs-toggle="modal" data-bs-target="#insuranceModal" data-id="4">Emily Davis</a></td>
                                                    <td>2024-02-22</td>
                                                    <td>091234567891</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="#" class="text-primary text-decoration-none fw-medium" data-bs-toggle="modal" data-bs-target="#insuranceModal" data-id="5">David Wilson</a></td>
                                                    <td>2024-02-28</td>
                                                    <td>091234567891</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title fw-bold mb-0">Payment Reminders</h5>
                                        <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Due Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Jane Smith</td>
                                                    <td>2024-02-20</td>
                                                    <td>₱8,900.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Sarah Williams</td>
                                                    <td>2024-02-25</td>
                                                    <td>₱6,750.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Christopher Lee</td>
                                                    <td>2024-02-12</td>
                                                    <td>₱12,300.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Amanda Taylor</td>
                                                    <td>2024-02-16</td>
                                                    <td>₱9,500.00</td>
                                                </tr>
                                                <tr>
                                                    <td>James Martinez</td>
                                                    <td>2024-02-24</td>
                                                    <td>₱7,200.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="insuranceModalLabel">Insurance Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-12 text-center mb-4">
                            <h4 id="clientName">John Doe</h4>
                            <span id="insuranceStatus" class="badge bg-info">Upcoming</span>
                        </div>
                        
                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Contact Number</p>
                                    <p id="contactNumber" class="text-muted">091234567891</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Email Address</p>
                                    <p id="emailAddress" class="text-muted">johndoe@example.com</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Insurance Provider</p>
                                    <p id="insuranceProvider" class="text-muted">Standard insurance</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Policy Number</p>
                                    <p id="policyNumber" class="text-muted">POL-2024-001</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Due Date</p>
                                    <p id="dueDate" class="text-muted">2024-02-15</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Coverage Amount</p>
                                    <p id="coverageAmount" class="text-muted">₱500,000.00</p>
                                </div>
                            </div>
                            
                            <!-- NEW FIELDS ADDED HERE -->
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Address</p>
                                    <p id="clientAddress" class="text-muted">123 Main Street, Quezon City</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Plate No.</p>
                                    <p id="plateNumber" class="text-muted">ABC 123</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Model Year</p>
                                    <p id="modelYear" class="text-muted">2022</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Color</p>
                                    <p id="vehicleColor" class="text-muted">Red</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Amount Due</p>
                                    <p id="amountDue" class="text-muted">₱8,500.00</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="fw-semibold text-dark">Issue Date</p>
                                    <p id="issueDate" class="text-muted">2024-01-15</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <p class="fw-semibold text-dark">Freebie</p>
                                    <p id="freebie" class="text-muted">Car Emergency Kit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-phone me-1"></i> Contact Client
                    </button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-envelope me-1"></i> Send Reminder
                    </button>
                </div>
            </div>
        </div>
    </div>

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
        const insuranceData = {
            1: {
                name: "John Doe",
                status: "Upcoming",
                contactNumber: "091234567891",
                emailAddress: "johndoe@example.com",
                insuranceProvider: "Standard Insurance",
                policyNumber: "POL-2024-001",
                dueDate: "2024-02-15",
                coverageAmount: "₱500,000.00",
                clientAddress: "123 Main Street, Quezon City, Metro Manila",
                plateNumber: "ABC 123",
                modelYear: "2022",
                vehicleColor: "Red",
                amountDue: "₱8,500.00",
                issueDate: "2024-01-15",
                freebie: "Car Emergency Kit"
            },
            2: {
                name: "Michael Johnson",
                status: "Overdue",
                contactNumber: "091234567892",
                emailAddress: "michaelj@example.com",
                insuranceProvider: "Malayan Insurance Corporation",
                policyNumber: "POL-2024-002",
                dueDate: "2024-02-10",
                coverageAmount: "₱750,000.00",
                clientAddress: "456 Oak Avenue, Makati City, Metro Manila",
                plateNumber: "XYZ 789",
                modelYear: "2021",
                vehicleColor: "Blue",
                amountDue: "₱7,200.00",
                issueDate: "2024-01-10",
                freebie: "GPS Tracker"
            },
            3: {
                name: "Robert Brown",
                status: "Upcoming",
                contactNumber: "091234567893",
                emailAddress: "robertb@example.com",
                insuranceProvider: "Cocogen Insurance",
                policyNumber: "POL-2024-003",
                dueDate: "2024-02-18",
                coverageAmount: "₱2,000,000.00",
                clientAddress: "789 Pine Road, Taguig City, Metro Manila",
                plateNumber: "LMN 456",
                modelYear: "2023",
                vehicleColor: "White",
                amountDue: "₱9,800.00",
                issueDate: "2024-01-18",
                freebie: "Car Cover"
            },
            4: {
                name: "Emily Davis",
                status: "Upcoming",
                contactNumber: "091234567894",
                emailAddress: "emilyd@example.com",
                insuranceProvider: "FPG Insurance Corporation",
                policyNumber: "POL-2024-004",
                dueDate: "2024-02-22",
                coverageAmount: "₱1,500,000.00",
                clientAddress: "321 Elm Street, Mandaluyong City, Metro Manila",
                plateNumber: "JKL 012",
                modelYear: "2020",
                vehicleColor: "Black",
                amountDue: "₱6,500.00",
                issueDate: "2024-01-22",
                freebie: "First Aid Kit"
            },
            5: {
                name: "David Wilson",
                status: "Pending",
                contactNumber: "091234567895",
                emailAddress: "davidw@example.com",
                insuranceProvider: "Standard Insurance",
                policyNumber: "POL-2024-005",
                dueDate: "2024-02-28",
                coverageAmount: "₱250,000.00",
                clientAddress: "654 Cedar Lane, Pasig City, Metro Manila",
                plateNumber: "QRS 345",
                modelYear: "2022",
                vehicleColor: "Silver",
                amountDue: "₱10,200.00",
                issueDate: "2024-01-28",
                freebie: "Dash Cam"
            }
        };

        // Handle modal display when a name is clicked
        $(document).ready(function() {
            $('a[data-bs-target="#insuranceModal"]').click(function() {
                const clientId = $(this).data('id');
                const client = insuranceData[clientId];
                
                if (client) {
                    $('#clientName').text(client.name);
                    $('#contactNumber').text(client.contactNumber);
                    $('#emailAddress').text(client.emailAddress);
                    $('#insuranceProvider').text(client.insuranceProvider);
                    $('#policyNumber').text(client.policyNumber);
                    $('#dueDate').text(client.dueDate);
                    $('#coverageAmount').text(client.coverageAmount);
                    $('#clientAddress').text(client.clientAddress);
                    $('#plateNumber').text(client.plateNumber);
                    $('#modelYear').text(client.modelYear);
                    $('#vehicleColor').text(client.vehicleColor);
                    $('#amountDue').text(client.amountDue);
                    $('#issueDate').text(client.issueDate);
                    $('#freebie').text(client.freebie);
                    
                    const statusBadge = $('#insuranceStatus');
                    statusBadge.text(client.status);
                    
                    // Update badge color based on status
                    statusBadge.removeClass('bg-info bg-warning bg-danger');
                    if (client.status === 'Pending') {
                        statusBadge.addClass('bg-warning');
                    } else if (client.status === 'Upcoming') {
                        statusBadge.addClass('bg-info');
                    } else if (client.status === 'Overdue') {
                        statusBadge.addClass('bg-danger');
                    }
                    
                    $('#insuranceModalLabel').text(`Insurance Details - ${client.name}`);
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