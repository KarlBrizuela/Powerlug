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
                        <a href="{{ route('collections.index') }}" class="btn btn-outline-primary">
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
                            <form method="POST" action="{{ route('collections.store') }}">
                                @csrf

                                <!-- Collection Information -->
                                <div class="section-title">Billing And Collection</div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="client_id" class="form-label">Client Name <span class="text-danger">*</span></label>
                                            <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                                <option value="">Select Client</option>
                                                @foreach($clients as $client)
                                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                        {{ $client->lastName }}, {{ $client->firstName }} {{ $client->middleName }} ({{ $client->source ?? 'Unknown' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('client_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="policy_number" class="form-label">Policy Number</label>
                                            <input type="text" class="form-control @error('policy_number') is-invalid @enderror" 
                                                id="policy_number" name="policy_number" value="{{ old('policy_number') }}" 
                                                placeholder="Auto-filled from claim">
                                            @error('policy_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="invoice_number" class="form-label">Service Invoice Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" 
                                                id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" 
                                                placeholder="Enter invoice number" required>
                                            @error('invoice_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="claim_number" class="form-label">Claim Number</label>
                                            <input type="text" class="form-control @error('claim_number') is-invalid @enderror" 
                                                id="claim_number" name="claim_number" value="{{ old('claim_number') }}" 
                                                placeholder="Auto-filled from claim">
                                            @error('claim_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="billing_status" class="form-label">Billing Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('billing_status') is-invalid @enderror" 
                                                id="billing_status" name="billing_status" required>
                                                <option value="">Select Status</option>
                                                <option value="billed" {{ old('billing_status') == 'billed' ? 'selected' : '' }}>Billed</option>
                                                <option value="pending" {{ old('billing_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="overdue" {{ old('billing_status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                            </select>
                                            @error('billing_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="loa_amount" class="form-label">LOA Amount (₱)</label>
                                            <input type="number" class="form-control @error('loa_amount') is-invalid @enderror" 
                                                id="loa_amount" name="loa_amount" value="{{ old('loa_amount') }}" 
                                                placeholder="Auto-filled from claim" min="0" step="0.01">
                                            @error('loa_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="collection_amount" class="form-label">Collection Amount (₱) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('collection_amount') is-invalid @enderror" 
                                                id="collection_amount" name="collection_amount" value="{{ old('collection_amount') }}" 
                                                placeholder="Amount collected" min="0" step="0.01" required>
                                            @error('collection_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                            <select class="form-select @error('payment_method') is-invalid @enderror" 
                                                id="payment_method" name="payment_method" required>
                                                <option value="">Select Payment Method</option>
                                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                            </select>
                                            @error('payment_method')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="collection_status" class="form-label">Status of Collection <span class="text-danger">*</span></label>
                                            <select class="form-select @error('collection_status') is-invalid @enderror" 
                                                id="collection_status" name="collection_status" required>
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
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="collection_date" class="form-label">Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('collection_date') is-invalid @enderror" 
                                                id="collection_date" name="collection_date" value="{{ old('collection_date', date('Y-m-d')) }}" required>
                                            @error('collection_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="bank_name" class="form-label">Bank</label>
                                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                                id="bank_name" name="bank_name" value="{{ old('bank_name') }}" 
                                                placeholder="Bank (BDO, BPI, etc.)">
                                            @error('bank_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="loa" class="form-label">LOA (Authorization)</label>
                                            <input type="text" class="form-control @error('loa') is-invalid @enderror"
                                                id="loa" name="loa" value="{{ old('loa') }}" placeholder="LOA reference or notes">
                                            @error('loa')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
            const clientSelect = document.getElementById('client_id');
            
            // When client is selected, fetch claim data
            clientSelect.addEventListener('change', function() {
                const clientId = this.value;
                const clientText = this.options[this.selectedIndex].text;
                
                console.log('Client selected:', clientId, clientText);
                
                if (!clientId) {
                    // Clear fields if no client selected
                    document.getElementById('policy_number').value = '';
                    document.getElementById('loa_amount').value = '';
                    document.getElementById('claim_number').value = '';
                    return;
                }
                
                // Fetch claim data for the selected client
                const url = `/collections/client/${clientId}/claim-data`;
                console.log('Fetching from:', url);
                
                fetch(url)
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Claim data received:', data);
                        const policyNum = data.policy_number || '';
                        const claimNum = data.claim_number || '';
                        const loaAmount = data.loa_amount || '';
                        
                        console.log('Setting values - Policy:', policyNum, 'Claim:', claimNum, 'LOA:', loaAmount);
                        
                        document.getElementById('policy_number').value = policyNum;
                        document.getElementById('claim_number').value = claimNum;
                        document.getElementById('loa_amount').value = loaAmount;
                        
                        console.log('Fields updated');
                    })
                    .catch(error => {
                        console.error('Error fetching claim data:', error);
                        // Clear fields on error
                        document.getElementById('policy_number').value = '';
                        document.getElementById('loa_amount').value = '';
                        document.getElementById('claim_number').value = '';
                    });
            });
        });
    </script>
</body>
</html>