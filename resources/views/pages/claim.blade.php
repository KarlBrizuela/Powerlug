<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Claim Filing - Powerlug</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Powerlug" name="description" />
    <meta content="Powerlug" name="author" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        .sidebar-wrapper {
            min-height: 100vh;
            margin-left: 0;
            transition: margin 0.25s ease-out;
        }
        
        .page-content-wrapper {
            min-width: 0;
            width: 100%;
            padding: 20px;
        }
        
        @media (min-width: 768px) {
            .sidebar-wrapper {
                margin-left: 0;
            }
            
            .page-content-wrapper {
                margin-left: 250px;
                padding: 30px;
            }
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .border-primary-left {
            border-left: 4px solid #4e73df !important;
        }
        
        .table th {
            font-weight: 600;
            color: #4e73df;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="sidebar-wrapper">
            @include('components.sidebar')
        </div>

        <!-- Page content -->
        <div id="page-content-wrapper" class="page-content-wrapper">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="mb-3 mb-md-0">
                            <h4 class="mb-1 text-primary">Claim Form</h4>
                            <p class="text-muted mb-0">Powerlug Claim Filing System</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('claims.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-list-ul me-1"></i> View Claims
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 p-md-5">
                            <form method="POST" action="{{ route('claims.store') }}" enctype="multipart/form-data">
                                @csrf
                                <!-- Claim Section -->
                                <div class="bg-light p-3 rounded mb-4 border-primary-left">
                                    <h6 class="mb-0 text-dark">Insured Claim:</h6>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Date of Claim</label>
                                        <input type="date" name="date_of_claim" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Client</label>
                                        <select name="client" class="form-select">
                                            <option value="">Select client</option>
                                            @if(isset($clients) && $clients->count())
                                                @foreach($clients as $c)
                                                    <option value="{{ $c->client_name }}">{{ $c->client_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Claim Number</label>
                                        <input type="text" name="claim_number" class="form-control" placeholder="Enter claim number">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">LOA Amount</label>
                                        <input type="text" name="loa_amount" class="form-control" placeholder="Enter LOA amount">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Participation Amount</label>
                                        <input type="text" name="participation_amount" class="form-control" placeholder="Enter Participation amount">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Deductible</label>
                                        <input type="text" name="deductible" class="form-control" placeholder="Enter Deductible">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">File Upload</label>
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Estimate Amount:</label>
                                        <div class="table-responsive mt-2">
                                            <table class="table table-bordered table-hover mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-semibold">PARTS</td>
                                                        <td class="w-25">
                                                            <input type="number" id="parts" name="parts" class="form-control text-end" placeholder="0" min="0" step="0.01" oninput="calculateTotals()">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold">LABOR COST</td>
                                                        <td>
                                                            <input type="number" id="laborCost" name="laborCost" class="form-control text-end" placeholder="0" min="0" step="0.01" oninput="calculateTotals()">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold">MATERIALS</td>
                                                        <td>
                                                            <input type="number" id="materials" name="materials" class="form-control text-end" placeholder="0" min="0" step="0.01" oninput="calculateTotals()">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-semibold">VAT 12%</td>
                                                        <td class="text-end fw-semibold" id="vat">0.00</td>
                                                    </tr>
                                                    <tr class="table-primary">
                                                        <td class="fw-bold">TOTAL AMOUNT DUE</td>
                                                        <td class="text-end fw-bold fs-5" id="totalAmount">0.00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 pt-3 border-top">
                                    <button type="reset" class="btn btn-secondary order-2 order-sm-1">
                                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary order-1 order-sm-2">
                                        <i class="bi bi-send-check me-1"></i> Submit Claim
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-5 pt-4 border-top">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <p class="mb-0 text-muted">
                                &copy; <script>document.write(new Date().getFullYear())</script> Powerlug.
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end text-muted">
                                Design & Develop by <a href="#!" class="text-decoration-none">Intracode</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Calculate VAT and Total Amount
        function calculateTotals() {
            var parts = parseFloat(document.getElementById('parts').value) || 0;
            var laborCost = parseFloat(document.getElementById('laborCost').value) || 0;
            var materials = parseFloat(document.getElementById('materials').value) || 0;
            
            var subtotal = parts + laborCost + materials;
            var vat = subtotal * 0.12;
            var total = subtotal + vat;
            
            document.getElementById('vat').textContent = vat.toFixed(2);
            document.getElementById('totalAmount').textContent = total.toFixed(2);
        }

        // Initialize totals on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotals();
        });
    </script>
</body>
</html>