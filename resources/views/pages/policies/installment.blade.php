<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Installment - {{ $policy->policy_number }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Page Header */
        .page-header {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            background: #fff;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: #fff !important;
            border-bottom: 2px solid #007bff;
            padding: 1.25rem;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-header h5, .card-header h6 {
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
            font-size: 1.1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Sidebar compatibility styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }

        /* Badge Styling */
        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
        }

        /* Payment Summary */
        .policy-summary {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-item strong {
            color: #495057;
            font-size: 0.9rem;
        }

        .summary-item .value {
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }

        /* Form Controls */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.6rem 0.75rem;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        }

        /* Button Styling */
        .btn {
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
        }

        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: #007bff;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,123,255,0.3);
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-info {
            background: #17a2b8;
        }

        .btn-info:hover {
            background: #138496;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-outline-primary {
            border: 2px solid #007bff;
            color: #007bff;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: #007bff;
            color: #fff;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }

        /* List Group */
        .list-group-item {
            border: none;
            border-bottom: 1px solid #f0f0f0;
            padding: 1rem;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        /* Installment Row Card */
        .installment-row {
            border: 1px solid #e9ecef !important;
        }

        .installment-row .card-header {
            background: #f8f9fa !important;
            border-bottom: 1px solid #e9ecef;
        }

        /* Info Text */
        .text-muted {
            color: #6c757d !important;
        }

        /* Quick Info Card */
        .card-body p {
            margin-bottom: 0.75rem;
            color: #495057;
        }

        .card-body p strong {
            color: #2c3e50;
        }

        hr {
            margin: 1rem 0;
            border-top: 2px solid #e9ecef;
        }
    </style>
</head>
<body>
    @include('components.sidebar')
    <div class="main-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="page-title">Policy Installment</h2>
                    <div>
                        <a href="{{ route('policies.listInstallments', $policy->id) }}" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-list me-1"></i>View All Installments
                        </a>
                        <a href="{{ route('policies.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Policies
                        </a>
                    </div>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Policy Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Policy Number:</strong> {{ $policy->policy_number }}</p>
                                    <p><strong>Status:</strong> 
                                        @switch($policy->status)
                                            @case('active')
                                                <span class="badge bg-success">Active</span>
                                                @break
                                            @case('inactive')
                                                <span class="badge bg-secondary">Inactive</span>
                                                @break
                                            @case('expired')
                                                <span class="badge bg-warning">Expired</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Client Name:</strong> 
                                        @if($policy->client)
                                            {{ $policy->client->firstName ?? '' }} {{ $policy->client->lastName ?? '' }}
                                        @else
                                            {{ $policy->client_name ?? 'N/A' }}
                                        @endif
                                    </p>
                                    <p><strong>Provider:</strong> {{ $policy->insuranceProvider->name ?? $policy->insurance_provider ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Payment Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="policy-summary">
                                <div class="summary-item">
                                    <strong>Coverage Amount:</strong>
                                    <span class="value">₱ {{ number_format($policy->coverage_amount ?? 0, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>Premium:</strong>
                                    <span class="value">₱ {{ number_format($policy->premium ?? 0, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>VAT (12%):</strong>
                                    <span class="value">₱ {{ number_format($policy->vat ?? 0, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>Documentary Stamp Tax:</strong>
                                    <span class="value">₱ {{ number_format($policy->documentary_stamp_tax ?? 0, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>Local Gov Tax:</strong>
                                    <span class="value">₱ {{ number_format($policy->local_gov_tax ?? 0, 2) }}</span>
                                </div>
                                <hr>
                                <div class="summary-item">
                                    <strong>Total Amount Due:</strong>
                                    <span class="value text-primary">₱ {{ number_format($policy->amount_due ?? 0, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>Paid Amount:</strong>
                                    <span class="value text-success">₱ {{ number_format($policy->paid_amount ?? 0, 2) }}</span>
                                </div>
                                <div class="summary-item">
                                    <strong>Outstanding Balance:</strong>
                                    <span class="value text-danger">₱ {{ number_format(($policy->amount_due ?? 0) - ($policy->paid_amount ?? 0), 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5>Record Installment Payment</h5>
                            <button class="btn btn-primary btn-sm" id="toggleInstallmentForm" onclick="toggleInstallmentForm()">
                                <i class="fas fa-plus me-1"></i>Add Installment
                            </button>
                        </div>
                        <div class="card-body" id="installmentFormContainer" style="display: none;">
                            <form method="POST" action="{{ route('policies.storeInstallment', $policy->id) }}" class="needs-validation" id="installmentForm">
                                @csrf
                                
                                <div id="installmentRows">
                                    <!-- First installment row will be added here -->
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addInstallmentRow()">
                                        <i class="fas fa-plus me-1"></i>Add Another Installment
                                    </button>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check me-1"></i>Save All Payments
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="toggleInstallmentForm()">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Installment History</h5>
                        </div>
                        <div class="card-body">
                            @if(isset($installments) && $installments->count() > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach($installments as $inst)
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div>
                                                <div class="fw-bold">₱ {{ number_format($inst->amount, 2) }}</div>
                                                <div class="small text-muted">{{ $inst->payment_method }} • {{ optional($inst->payment_date)->format('M d, Y') }}</div>
                                                @if($inst->reference_number)
                                                    <div class="small">Ref: {{ $inst->reference_number }}</div>
                                                @endif
                                                @if($inst->remarks)
                                                    <div class="small text-muted">{{ $inst->remarks }}</div>
                                                @endif
                                            </div>
                                            <div class="text-muted small">{{ optional($inst->created_at)->diffForHumans() }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center text-muted py-4">No installments recorded yet.</div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Quick Info</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Payment Terms:</strong> {{ $policy->payment_terms ?? 'N/A' }}</p>
                            <p><strong>Billing Status:</strong> 
                                @if($policy->billing_status)
                                    <span class="badge bg-info">{{ ucfirst($policy->billing_status) }}</span>
                                @else
                                    <span class="text-muted">Not Set</span>
                                @endif
                            </p>
                            <p><strong>Start Date:</strong> {{ optional($policy->start_date)->format('M d, Y') ?? 'N/A' }}</p>
                            <p><strong>End Date:</strong> {{ optional($policy->end_date)->format('M d, Y') ?? 'N/A' }}</p>
                            <hr>
                            <p class="small text-muted mb-0"><i class="fas fa-info-circle me-1"></i>This page allows you to record installment payments for this policy. The outstanding balance will be automatically calculated.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let installmentRowCount = 0;

        function toggleInstallmentForm() {
            const formContainer = document.getElementById('installmentFormContainer');
            const toggleButton = document.getElementById('toggleInstallmentForm');
            
            if (formContainer.style.display === 'none') {
                formContainer.style.display = 'block';
                toggleButton.innerHTML = '<i class="fas fa-minus me-1"></i>Hide Form';
                toggleButton.classList.remove('btn-primary');
                toggleButton.classList.add('btn-secondary');
                
                // Add first row if none exist
                if (installmentRowCount === 0) {
                    addInstallmentRow();
                }
            } else {
                formContainer.style.display = 'none';
                toggleButton.innerHTML = '<i class="fas fa-plus me-1"></i>Add Installment';
                toggleButton.classList.remove('btn-secondary');
                toggleButton.classList.add('btn-primary');
            }
        }

        function addInstallmentRow() {
            const container = document.getElementById('installmentRows');
            const rowIndex = installmentRowCount;
            
            const rowHtml = `
                <div class="card installment-row" id="row-${rowIndex}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6>Installment #${rowIndex + 1}</h6>
                        ${rowIndex > 0 ? `<button type="button" class="btn btn-danger btn-sm" onclick="removeInstallmentRow(${rowIndex})"><i class="fas fa-trash me-1"></i>Remove</button>` : ''}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="installment_amount_${rowIndex}" class="form-label">Installment Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" 
                                           id="installment_amount_${rowIndex}" name="installments[${rowIndex}][amount]" 
                                           step="0.01" min="0" placeholder="Enter amount" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_date_${rowIndex}" class="form-label">Payment Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" 
                                           id="payment_date_${rowIndex}" name="installments[${rowIndex}][date]" 
                                           value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method_${rowIndex}" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                    <select class="form-select" id="payment_method_${rowIndex}" name="installments[${rowIndex}][method]" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Check">Check</option>
                                        <option value="Transfer">Bank Transfer</option>
                                        <option value="Online">Online Payment</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reference_number_${rowIndex}" class="form-label">Reference Number</label>
                                    <input type="text" class="form-control" 
                                           id="reference_number_${rowIndex}" name="installments[${rowIndex}][reference]" 
                                           placeholder="Check #, Transfer Ref #, etc.">
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="remarks_${rowIndex}" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks_${rowIndex}" name="installments[${rowIndex}][remarks]" 
                                      rows="2" placeholder="Additional notes"></textarea>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', rowHtml);
            installmentRowCount++;
        }

        function removeInstallmentRow(rowIndex) {
            const row = document.getElementById(`row-${rowIndex}`);
            if (row) {
                row.remove();
            }
        }
    </script>
</body>
</html>
