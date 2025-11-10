<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Walk In - Powerlug</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Powerlug" name="description" />
    <meta content="Powerlug" name="author" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Sidebar styles */
        .vertical-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            z-index: 1001;
            background: #ffffff;
            border-right: 1px solid #e9ecef;
            padding-top: 0;
        }

        /* Fix body and layout alignment */
        body {
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Main content alignment with sidebar */
        #layout-wrapper {
            margin-left: 250px;
            min-height: 100vh;
            width: calc(100% - 250px);
        }

        /* Ensure page-content fits properly */
        .page-content {
            padding: 30px !important;
            margin: 0 !important;
            width: 100%;
        }

        /* Responsive sidebar */
        @media (max-width: 992px) {
            .vertical-menu {
                display: none;
            }
            #layout-wrapper {
                margin-left: 0;
            }
        }

        /* Form styling */
        .section-title {
            background-color: #f8f9fa;
            padding: 12px 15px;
            border-left: 4px solid #556ee6;
            margin-bottom: 20px;
            font-weight: 600;
            color: #495057;
            border-radius: 0 4px 4px 0;
        }

        /* Card adjustments */
        .card {
            border: none;
            box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
            border-radius: 8px;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Form improvements */
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #495057;
        }
        
        .form-control, .form-select {
            border-radius: 4px;
            padding: 8px 12px;
            border: 1px solid #ced4da;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #556ee6;
            box-shadow: 0 0 0 0.15rem rgba(85, 110, 230, 0.25);
        }
        
        /* Table improvements */
        .table-bordered {
            border: 1px solid #e9ecef;
        }
        
        .table-bordered td {
            padding: 12px;
            vertical-align: middle;
        }
        
        .table-bordered tr:last-child {
            background-color: #f8f9fa;
        }
        
        /* Button improvements */
        .btn {
            border-radius: 4px;
            padding: 8px 20px;
            font-weight: 500;
        }
        
        .btn-primary {
            background-color: #556ee6;
            border-color: #556ee6;
        }
        
        .btn-primary:hover {
            background-color: #485ec4;
            border-color: #485ec4;
        }
        
        /* Layout improvements */
        .page-title-box {
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 20px;
        }
        
        .mb-3 {
            margin-bottom: 1rem !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #layout-wrapper {
                padding: 15px;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .section-title {
                font-size: 1rem;
                padding: 10px 12px;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
        }
        
        /* Number input alignment */
        .text-end input {
            text-align: right;
        }
        
        /* Container and form width adjustments */
        .form-container {
            width: 100%;
            max-width: 100%;
            padding: 0 30px;
        }
        
        .container-fluid {
            max-width: none;
            width: calc(100% - 40px);
        }
        
        .auto-width-field {
            width: 100%;
        }
        
        /* Table width adjustment */
        .table-responsive {
            max-width: 800px;
            margin: 0 auto;
        }
        
        @media (min-width: 992px) {
            .auto-width-field {
                min-width: 250px;
            }
            .container-fluid {
                padding: 0 40px;
            }
        }
    </style>
</head>
<body>
@include('components.sidebar')
<!-- Begin page -->
<div id="layout-wrapper">
    <div class="page-content">
        <div class="container-fluid form-container">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Walk In</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('walk-in.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Walk in Section -->
                                <div class="section-title">Walk in: (Details to be collected)</div>

                                <div class="row mb-3">
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">Insured</label>
                                        <input type="text" name="insured_name" class="form-control auto-width-field" placeholder="Enter insured name" required>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">Unit</label>
                                        <input type="text" name="unit" class="form-control auto-width-field" placeholder="Enter unit" required>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">Plate Number</label>
                                        <input type="text" name="plate_number" class="form-control auto-width-field" placeholder="Enter plate number" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" name="contact_number" class="form-control auto-width-field" placeholder="Enter contact number" required>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control auto-width-field" placeholder="Enter email" required>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <label class="form-label">Payment Type</label>
                                        <select name="payment_type" class="form-select auto-width-field" required>
                                            <option value="">Select payment type</option>
                                            <option value="down_payment">Down Payment</option>
                                            <option value="full_payment">Full Payment</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control" placeholder="Enter address" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">File Upload</label>
                                        <input type="file" name="file_upload" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label">Estimate Amount:</label>
                                        <div class="table-responsive mt-2">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>PARTS</strong></td>
                                                        <td><input type="number" name="parts_amount" id="parts" class="form-control text-end" placeholder="0" min="0" step="0.01" oninput="calculateTotals()" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>LABOR COST</strong></td>
                                                        <td><input type="number" name="labor_cost" id="laborCost" class="form-control text-end" placeholder="0" min="0" step="0.01" oninput="calculateTotals()" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>MATERIALS</strong></td>
                                                        <td><input type="number" name="materials_cost" id="materials" class="form-control text-end" placeholder="0" min="0" step="0.01" oninput="calculateTotals()" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>VAT 12%</strong></td>
                                                        <td class="text-end" id="vat">0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>TOTAL AMOUNT DUE</strong></td>
                                                        <td class="text-end" id="totalAmount"><strong>0.00</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <input type="hidden" name="vat_amount" id="vatInput">
                                            <input type="hidden" name="total_amount" id="totalAmountInput">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="reset" class="btn btn-secondary me-2">Reset</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
        document.getElementById('totalAmount').innerHTML = '<strong>' + total.toFixed(2) + '</strong>';
        
        // Update hidden inputs
        document.getElementById('vatInput').value = vat.toFixed(2);
        document.getElementById('totalAmountInput').value = total.toFixed(2);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotals();
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>