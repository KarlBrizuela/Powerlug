<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Commission - Powerlug</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 250px;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .page-content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }
        
        .page-content {
            padding: 20px;
            min-height: calc(100vh - 70px);
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
        }
        
        /* Fixed table styles */
        .table-container {
            position: relative;
            max-height: 600px;
            overflow: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }
        
        .table-fixed-header {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .table-fixed-header thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 20;
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .page-content-wrapper {
                margin-left: 0;
            }
            
            body {
                padding-top: 60px; /* Account for mobile header */
            }
            
            .table-container {
                max-height: 500px;
            }
        }
        
        @media (max-width: 767.98px) {
            .table-container {
                max-height: 400px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <!-- @include('components.sidebar') -->
    <!-- For demo purposes, adding a placeholder sidebar -->
    <div class="sidebar bg-dark text-white" style="width: var(--sidebar-width); min-height: 100vh; position: fixed; left: 0; top: 0;">
        <div class="p-3">
            <h5 class="text-center">Powerlug</h5>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a href="#" class="nav-link text-white">Dashboard</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Commission</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Policies</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white">Reports</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Page Content -->
    <div class="page-content-wrapper">
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

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="section-title">Commission Summary</div>

                                <div class="table-container">
                                    <table id="commissionsTable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead class="table-light table-fixed-header">
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
                                            <!-- Sample data for demonstration -->
                                        
                                          
                                            <tr>
                                                <td>Standard Insurance</td>
                                                <td>POL-001236</td>
                                                <td>Robert Johnson</td>
                                                <td>6 Months</td>
                                                <td>$800.00</td>
                                                <td>$650.00</td>
                                                <td>$325.00</td>
                                                <td>$325.00</td>
                                                <td>$0.00</td>
                                                <td>2023-11-05</td>
                                                <td>$97.50</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-commission" data-commission-id="3">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Malayan Insurance</td>
                                                <td>POL-001237</td>
                                                <td>Sarah Williams</td>
                                                <td>36 Months</td>
                                                <td>$4,200.00</td>
                                                <td>$3,500.00</td>
                                                <td>$1,166.67</td>
                                                <td>$1,166.67</td>
                                                <td>$1,166.66</td>
                                                <td>2023-08-30</td>
                                                <td>$525.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-commission" data-commission-id="4">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>FPG Insurance Corporation</td>
                                                <td>POL-001238</td>
                                                <td>Michael Brown</td>
                                                <td>12 Months</td>
                                                <td>$1,500.00</td>
                                                <td>$1,250.00</td>
                                                <td>$625.00</td>
                                                <td>$625.00</td>
                                                <td>$0.00</td>
                                                <td>2023-10-28</td>
                                                <td>$187.50</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-commission" data-commission-id="5">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cocogen Insurance</td>
                                                <td>POL-001239</td>
                                                <td>Lisa Anderson</td>
                                                <td>18 Months</td>
                                                <td>$2,100.00</td>
                                                <td>$1,800.00</td>
                                                <td>$600.00</td>
                                                <td>$600.00</td>
                                                <td>$600.00</td>
                                                <td>2023-09-15</td>
                                                <td>$270.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-commission" data-commission-id="6">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Standard Insurance</td>
                                                <td>POL-001240</td>
                                                <td>David Miller</td>
                                                <td>24 Months</td>
                                                <td>$3,000.00</td>
                                                <td>$2,500.00</td>
                                                <td>$833.33</td>
                                                <td>$833.33</td>
                                                <td>$833.34</td>
                                                <td>2023-11-10</td>
                                                <td>$375.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-commission" data-commission-id="7">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mlayan Insurance</td>
                                                <td>POL-001241</td>
                                                <td>Emily Davis</td>
                                                <td>12 Months</td>
                                                <td>$950.00</td>
                                                <td>$800.00</td>
                                                <td>$400.00</td>
                                                <td>$400.00</td>
                                                <td>$0.00</td>
                                                <td>2023-10-05</td>
                                                <td>$120.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-commission" data-commission-id="8">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>FPG Insurance Corporation</td>
                                                <td>POL-001242</td>
                                                <td>James Wilson</td>
                                                <td>36 Months</td>
                                                <td>$5,000.00</td>
                                                <td>$4,200.00</td>
                                                <td>$1,400.00</td>
                                                <td>$1,400.00</td>
                                                <td>$1,400.00</td>
                                                <td>2023-08-15</td>
                                                <td>$630.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-commission" data-commission-id="9">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Standard Insurance</td>
                                                <td>POL-001243</td>
                                                <td>Amanda Taylor</td>
                                                <td>6 Months</td>
                                                <td>$700.00</td>
                                                <td>$600.00</td>
                                                <td>$300.00</td>
                                                <td>$300.00</td>
                                                <td>$0.00</td>
                                                <td>2023-11-20</td>
                                                <td>$90.00</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-commission" data-commission-id="10">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#commissionsTable').DataTable({
                responsive: true,
                order: [[10, 'desc']],
                language: {
                    emptyTable: "No commission records found.",
                    search: "_INPUT_",
                    searchPlaceholder: "Search commissions...",
                    lengthMenu: "Show _MENU_ entries",
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>"
                    }
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
            });

            // View commission details
            $(document).on('click', '.view-commission', function() {
                const commissionId = $(this).data('commission-id');
                
                // For demo purposes, showing static content
                $('#commissionDetailsContent').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Policy Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Insurance Provider:</strong></td>
                                    <td>ABC Insurance</td>
                                </tr>
                                <tr>
                                    <td><strong>Policy Number:</strong></td>
                                    <td>POL-00123${commissionId}</td>
                                </tr>
                                <tr>
                                    <td><strong>Insured:</strong></td>
                                    <td>John Smith</td>
                                </tr>
                                <tr>
                                    <td><strong>Term:</strong></td>
                                    <td>12 Months</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Commission Details</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Gross Premium:</strong></td>
                                    <td>$1,200.00</td>
                                </tr>
                                <tr>
                                    <td><strong>Net Premium:</strong></td>
                                    <td>$1,000.00</td>
                                </tr>
                                <tr>
                                    <td><strong>Commission Rate:</strong></td>
                                    <td>15%</td>
                                </tr>
                                <tr>
                                    <td><strong>Commission Amount:</strong></td>
                                    <td>$150.00</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Payment Schedule</h6>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Period</th>
                                        <th>Amount</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>30 Days</td>
                                        <td>$400.00</td>
                                        <td>2023-10-15</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td>60 Days</td>
                                        <td>$300.00</td>
                                        <td>2023-11-15</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>90 Days</td>
                                        <td>$300.00</td>
                                        <td>2023-12-15</td>
                                        <td><span class="badge bg-secondary">Upcoming</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                `);
                
                $('#commissionDetailsModal').modal('show');
            });

            // Export to Excel functionality
            window.exportToExcel = function() {
                alert('Export functionality would be implemented when there is data to export.');
            };

            // Generate commission report
            window.generateCommissionReport = function() {
                alert('Report generation functionality would be implemented when there is data.');
            };
        });
    </script>
</body>
</html>