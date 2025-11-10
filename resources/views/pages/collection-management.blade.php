<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collection Management - Powerlug</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-content {
            margin-left: 250px; /* Adjust based on your sidebar width */
            padding: 20px;
            transition: all 0.3s;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
        .page-content {
            padding: 20px 0;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 10px;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid #e3e6f0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: 40px;
            border-top: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Collection Management</h4>
                        <a href="{{ route('collections.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-1"></i> View Collection Records
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

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Please fix the following errors:
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('collections.index') }}">
                                @csrf

                                <!-- Collection Information -->
                                <div class="section-title">Billing And Collection</div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Client Name <span class="text-danger">*</span></label>
                                        <select class="form-select @error('client_id') is-invalid @enderror" name="client_id" required>
                                            <option value="">Select Client</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                    {{ $client->name }} - {{ $client->plate_number ?? 'No Plate' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Policy Number</label>
                                        <select class="form-select @error('policy_id') is-invalid @enderror" name="policy_id" id="policySelect">
                                            <option value="">Select Policy (Optional)</option>
                                            <!-- Policies will be loaded via JavaScript based on client selection -->
                                        </select>
                                        @error('policy_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Service Invoice Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" 
                                               name="invoice_number" value="{{ old('invoice_number') }}" 
                                               placeholder="Enter service invoice number" required>
                                        @error('invoice_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Billing Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('billing_status') is-invalid @enderror" name="billing_status" required>
                                            <option value="">Select status</option>
                                            <option value="billed" {{ old('billing_status') == 'billed' ? 'selected' : '' }}>Billed</option>
                                            <option value="pending" {{ old('billing_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="overdue" {{ old('billing_status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                        </select>
                                        @error('billing_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Amount Due (₱)</label>
                                        <input type="number" class="form-control @error('amount_due') is-invalid @enderror" 
                                               name="amount_due" value="{{ old('amount_due') }}" 
                                               placeholder="Enter amount due" min="0" step="0.01">
                                        @error('amount_due')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Collection Amount (₱) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('collection_amount') is-invalid @enderror" 
                                               name="collection_amount" value="{{ old('collection_amount') }}" 
                                               placeholder="Amount collected (reminder if not yet collected)" min="0" step="0.01" required>
                                        @error('collection_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Status of Collection/Check <span class="text-danger">*</span></label>
                                        <select class="form-select @error('collection_status') is-invalid @enderror" name="collection_status" required>
                                            <option value="">Select status</option>
                                            <option value="deposited" {{ old('collection_status') == 'deposited' ? 'selected' : '' }}>Deposited to Bank</option>
                                            <option value="pending" {{ old('collection_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="cleared" {{ old('collection_status') == 'cleared' ? 'selected' : '' }}>Check Cleared</option>
                                            <option value="bounced" {{ old('collection_status') == 'bounced' ? 'selected' : '' }}>Check Bounced</option>
                                            <option value="cash" {{ old('collection_status') == 'cash' ? 'selected' : '' }}>Cash Collected</option>
                                        </select>
                                        @error('collection_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                                        <select class="form-select @error('payment_method') is-invalid @enderror" name="payment_method" required>
                                            <option value="">Select payment method</option>
                                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                                        </select>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Collection Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('collection_date') is-invalid @enderror" 
                                               name="collection_date" value="{{ old('collection_date', date('Y-m-d')) }}" required>
                                        @error('collection_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Bank</label>
                                        <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                               name="bank_name" value="{{ old('bank_name') }}" 
                                               placeholder="Bank (BDO, BPI, etc.)">
                                        @error('bank_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Check Number</label>
                                        <input type="text" class="form-control @error('check_number') is-invalid @enderror" 
                                               name="check_number" value="{{ old('check_number') }}" 
                                               placeholder="Enter check number (if applicable)">
                                        @error('check_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Reference Number</label>
                                        <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                                               name="reference_number" value="{{ old('reference_number') }}" 
                                               placeholder="Enter reference number">
                                        @error('reference_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label class="form-label">Remarks / Notes</label>
                                        <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                                  name="remarks" rows="3" 
                                                  placeholder="Enter any additional remarks or notes">{{ old('remarks') }}</textarea>
                                        @error('remarks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="reset" class="btn btn-secondary me-2">
                                        <i class="fas fa-undo me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Submit Collection
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer mt-4">
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clientSelect = document.querySelector('select[name="client_id"]');
            const policySelect = document.getElementById('policySelect');

            // Load policies when client is selected
            clientSelect.addEventListener('change', function() {
                const clientId = this.value;
                
                if (clientId) {
                    // Show loading state
                    policySelect.innerHTML = '<option value="">Loading policies...</option>';
                    
                    // Fetch policies for the selected client
                    fetch(`/api/clients/${clientId}/policies`)
                        .then(response => response.json())
                        .then(data => {
                            policySelect.innerHTML = '<option value="">Select Policy (Optional)</option>';
                            
                            data.forEach(policy => {
                                const option = document.createElement('option');
                                option.value = policy.id;
                                option.textContent = `${policy.policy_number} - ${policy.insurance_provider} (${policy.status})`;
                                policySelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching policies:', error);
                            policySelect.innerHTML = '<option value="">Error loading policies</option>';
                        });
                } else {
                    policySelect.innerHTML = '<option value="">Select Policy (Optional)</option>';
                }
            });

            // Auto-generate invoice number if empty
            const invoiceInput = document.querySelector('input[name="invoice_number"]');
            if (!invoiceInput.value) {
                const timestamp = new Date().getTime();
                invoiceInput.value = `INV-${timestamp}`;
            }

            // Show/hide bank and check fields based on payment method
            const paymentMethodSelect = document.querySelector('select[name="payment_method"]');
            const bankNameInput = document.querySelector('input[name="bank_name"]');
            const checkNumberInput = document.querySelector('input[name="check_number"]');

            function togglePaymentFields() {
                const paymentMethod = paymentMethodSelect.value;
                
                if (paymentMethod === 'check') {
                    bankNameInput.closest('.col-md-6').style.display = 'block';
                    checkNumberInput.closest('.col-md-6').style.display = 'block';
                    bankNameInput.required = true;
                    checkNumberInput.required = true;
                } else if (paymentMethod === 'bank_transfer') {
                    bankNameInput.closest('.col-md-6').style.display = 'block';
                    checkNumberInput.closest('.col-md-6').style.display = 'none';
                    bankNameInput.required = true;
                    checkNumberInput.required = false;
                    checkNumberInput.value = '';
                } else {
                    bankNameInput.closest('.col-md-6').style.display = 'none';
                    checkNumberInput.closest('.col-md-6').style.display = 'none';
                    bankNameInput.required = false;
                    checkNumberInput.required = false;
                    bankNameInput.value = '';
                    checkNumberInput.value = '';
                }
            }

            paymentMethodSelect.addEventListener('change', togglePaymentFields);
            togglePaymentFields(); // Initialize on page load

            // Initialize Feather Icons
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
</body>
</html>