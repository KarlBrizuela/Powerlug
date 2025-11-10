<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Form - Powerlug</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Main layout styles for sidebar integration */
        .page-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .page-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px; /* Adjust based on your sidebar width */
            transition: margin-left 0.3s ease;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        @media (max-width: 992px) {
            .page-content {
                margin-left: 0;
                padding: 15px;
            }
        }
        
        /* Your existing form styles */
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 1.5rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
        }
        
        .insurance-details-box {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            background-color: #f8f9fa;
        }
        
        .details-content {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        
        .details-content.active {
            display: block;
            opacity: 1;
        }
        
        .premium-summary {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            background-color: #f8f9fa;
        }
        
        .premium-summary .header {
            font-weight: 600;
            text-align: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .premium-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        
        .premium-row.total-row {
            font-weight: 600;
            margin-top: 0.5rem;
            padding-top: 0.5rem;
            border-top: 1px solid #dee2e6;
        }
        
        .bank-transfer-fields {
            display: none;
        }
        
        .bank-transfer-fields.show {
            display: block;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .form-type-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .footer {
            padding: 1.5rem 0;
            margin-top: 2rem;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        /* Mobile sidebar toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 1.2rem;
        }
        
        @media (max-width: 992px) {
            .sidebar-toggle {
                display: block;
            }
            
            body.sidebar-collapsed .page-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Toggle Button (Mobile) -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Your Sidebar Component -->
    <!-- @include('components.sidebar') -->

    <!-- Main Content -->
    <div class="page-content" id="pageContent">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('policies.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Primary Information Section -->
                                <div class="section-container mb-4">
                                    <div class="section-title">Primary Information</div>
                                    <div class="section-content">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Client Name</label>
                                                <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                                       name="client_name" value="{{ old('client_name') }}" required>
                                                @error('client_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                                       name="address" value="{{ old('address') }}" required>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       name="email" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Contact Number</label>
                                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                                                       name="contact_number" value="{{ old('contact_number') }}" required>
                                                @error('contact_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Make Model</label>
                                                <input type="text" class="form-control @error('make_model') is-invalid @enderror" 
                                                       name="make_model" value="{{ old('make_model') }}" required>
                                                @error('make_model')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Plate No.</label>
                                                <input type="text" class="form-control @error('plate_number') is-invalid @enderror" 
                                                       name="plate_number" value="{{ old('plate_number') }}" required>
                                                @error('plate_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Model Year</label>
                                                <input type="text" class="form-control @error('model_year') is-invalid @enderror" 
                                                       name="model_year" value="{{ old('model_year') }}" required>
                                                @error('model_year')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Color</label>
                                                <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                                       name="color" value="{{ old('color') }}" required>
                                                @error('color')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Other Information Section -->
                                <div class="section-container mb-4">
                                    <div class="section-title">Other Information</div>
                                    <div class="section-content">
                                        <div class="insurance-details-box">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="text-center fw-bold">Insurance Policy Details</div>
                                                <div class="form-type-buttons">
                                                    <button type="button" class="btn btn-primary" id="policyDetailsBtn">Policy Details</button>
                                                    <button type="button" class="btn btn-outline-primary" id="walkinDetailsBtn">Walk-in Details</button>
                                                </div>
                                            </div>

                                            <!-- Policy Details (Default) -->
                                            <div id="policyDetails" class="details-content active">
                                                <div class="row mb-2">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Insurance Provider</label>
                                                        <select class="form-select @error('insurance_provider') is-invalid @enderror" 
                                                                id="insuranceProvider" name="insurance_provider" required>
                                                            <option value="">Select insurance provider</option>
                                                            @foreach(['MERCANTILE', 'MALAYAN', 'FPG', 'FORTUNE_GEN', 'COCOGEN', 'COUNTRY_BANKER', 'STANDARD'] as $provider)
                                                                <option value="{{ $provider }}" {{ old('insurance_provider') == $provider ? 'selected' : '' }}>
                                                                    {{ $provider }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('insurance_provider')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Issue Date</label>
                                                        <input type="date" class="form-control @error('issue_date') is-invalid @enderror" 
                                                               name="issue_date" value="{{ old('issue_date') }}">
                                                        @error('issue_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Coverage Period From</label>
                                                        <input type="date" class="form-control @error('coverage_from') is-invalid @enderror" 
                                                               name="coverage_from" value="{{ old('coverage_from') }}">
                                                        @error('coverage_from')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Coverage Period To</label>
                                                        <input type="date" class="form-control @error('coverage_to') is-invalid @enderror" 
                                                               name="coverage_to" value="{{ old('coverage_to') }}">
                                                        @error('coverage_to')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Serial/Chassis No.</label>
                                                        <input type="text" class="form-control @error('chassis_number') is-invalid @enderror" 
                                                               name="chassis_number" value="{{ old('chassis_number', 'MPATK51V0PJ406822') }}" 
                                                               placeholder="MPATK51V0PJ406822">
                                                        @error('chassis_number')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Motor/Engine No.</label>
                                                        <input type="text" class="form-control @error('engine_number') is-invalid @enderror" 
                                                               name="engine_number" value="{{ old('engine_number', 'K15RT1422393') }}" 
                                                               placeholder="K15RT1422393">
                                                        @error('engine_number')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">MV File No.</label>
                                                        <input type="text" class="form-control @error('mv_file_number') is-invalid @enderror" 
                                                               name="mv_file_number" value="{{ old('mv_file_number', 'TBA') }}" 
                                                               placeholder="TBA">
                                                        @error('mv_file_number')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Mortgage</label>
                                                        <input type="text" class="form-control @error('mortgage') is-invalid @enderror" 
                                                               name="mortgage" value="{{ old('mortgage', 'BANK OF THE PHILIPPINE ISLANDS') }}" 
                                                               placeholder="BANK OF THE PHILIPPINE ISLANDS">
                                                        @error('mortgage')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Remarks</label>
                                                        <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                                                  name="remarks" rows="3" placeholder="Enter remarks">{{ old('remarks') }}</textarea>
                                                        @error('remarks')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Freebie</label>
                                                        <select class="form-select @error('freebie') is-invalid @enderror" name="freebie">
                                                            <option value="">Select freebie</option>
                                                            @foreach(['Undercoat', 'Buffing'] as $freebie)
                                                                <option value="{{ $freebie }}" {{ old('freebie') == $freebie ? 'selected' : '' }}>
                                                                    {{ $freebie }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('freebie')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Walk-in Details -->
                                            <div id="walkinDetails" class="details-content">
                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Date</label>
                                                        <input type="date" class="form-control @error('walkin_date') is-invalid @enderror" 
                                                               name="walkin_date" value="{{ old('walkin_date') }}">
                                                        @error('walkin_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">File Upload</label>
                                                        <input type="file" class="form-control @error('walkin_file') is-invalid @enderror" 
                                                               name="walkin_file">
                                                        @error('walkin_file')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Estimate Amount</label>
                                                        <input type="text" class="form-control @error('estimate_amount') is-invalid @enderror" 
                                                               name="estimate_amount" value="{{ old('estimate_amount') }}" 
                                                               placeholder="Enter estimate amount">
                                                        @error('estimate_amount')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Size</label>
                                                        <select class="form-select @error('size') is-invalid @enderror" name="size">
                                                            <option value="">Select size</option>
                                                            @foreach(['Small', 'Medium', 'Large', 'X-Large', 'XXL-Large'] as $size)
                                                                <option value="{{ $size }}" {{ old('size') == $size ? 'selected' : '' }}>
                                                                    {{ $size }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('size')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-md-12">
                                                        <label class="form-label">Services Availed</label>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="carwash" 
                                                                           name="services[]" value="Carwash" {{ in_array('Carwash', old('services', [])) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="carwash">Carwash</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="change-oil" 
                                                                           name="services[]" value="Change Oil" {{ in_array('Change Oil', old('services', [])) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="change-oil">Change Oil</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" id="tire-rotation" 
                                                                           name="services[]" value="Etc" {{ in_array('Etc', old('services', [])) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="tire-rotation">Etc</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Rate</label>
                                                        <input type="text" class="form-control @error('rate') is-invalid @enderror" 
                                                               name="rate" value="{{ old('rate') }}" placeholder="Enter rate">
                                                        @error('rate')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Payment</label>
                                                        <input type="text" class="form-control @error('walkin_payment') is-invalid @enderror" 
                                                               name="walkin_payment" value="{{ old('walkin_payment') }}" 
                                                               placeholder="Enter payment amount">
                                                        @error('walkin_payment')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Additional Information -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Payment Terms</label>
                                                <select class="form-select @error('payment_terms') is-invalid @enderror" name="payment_terms">
                                                    <option value="">Choose payment method</option>
                                                    @foreach(['Full payment', '30 days', '60 days', '90 days'] as $term)
                                                        <option value="{{ $term }}" {{ old('payment_terms') == $term ? 'selected' : '' }}>
                                                            {{ $term }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('payment_terms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Paid Amount</label>
                                                <input type="text" class="form-control @error('paid_amount') is-invalid @enderror" 
                                                       name="paid_amount" value="{{ old('paid_amount') }}" placeholder="Enter paid amount">
                                                @error('paid_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Payment Method</label>
                                                <select class="form-select @error('payment_method') is-invalid @enderror" 
                                                        id="paymentMethod" name="payment_method">
                                                    <option value="">Select method</option>
                                                    @foreach(['Cash', 'Transfer', 'PDC', 'Cancelled'] as $method)
                                                        <option value="{{ $method }}" {{ old('payment_method') == $method ? 'selected' : '' }}>
                                                            {{ $method }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('payment_method')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bank-transfer-fields" id="bankTransferFields">
                                                    <label class="form-label">Bank Transfer To</label>
                                                    <select class="form-select @error('bank_transfer') is-invalid @enderror" 
                                                            id="bankTransfer" name="bank_transfer">
                                                        <option value="">Select bank</option>
                                                    </select>
                                                    @error('bank_transfer')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Freebie</label>
                                                <select class="form-select @error('additional_freebie') is-invalid @enderror" name="additional_freebie">
                                                    <option value="">Select freebie</option>
                                                    @foreach(['Undercoat', 'Buffing'] as $freebie)
                                                        <option value="{{ $freebie }}" {{ old('additional_freebie') == $freebie ? 'selected' : '' }}>
                                                            {{ $freebie }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('additional_freebie')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Reference No.</label>
                                                <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                                                       name="reference_number" value="{{ old('reference_number') }}" 
                                                       placeholder="Enter reference number">
                                                @error('reference_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Summary of Premium and Other Charges Section -->
                                <div class="section-container mb-4">
                                    <div class="section-title">Summary of Premium and Other Charges</div>
                                    <div class="section-content">
                                        <div class="premium-summary">
                                            <div class="header">SUMMARY OF PREMIUM AND OTHER CHARGES</div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="premium-row">
                                                        <span>PREMIUM</span>
                                                        <input type="text" class="form-control form-control-sm @error('premium') is-invalid @enderror" 
                                                               style="width: 150px;" name="premium" value="{{ old('premium') }}" placeholder="PHP">
                                                        @error('premium')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="premium-row">
                                                        <span>Value Added Tax</span>
                                                        <input type="text" class="form-control form-control-sm @error('vat') is-invalid @enderror" 
                                                               style="width: 150px;" name="vat" value="{{ old('vat') }}" placeholder="PHP">
                                                        @error('vat')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="premium-row">
                                                        <span>Documentary Stamp Tax</span>
                                                        <input type="text" class="form-control form-control-sm @error('documentary_stamp_tax') is-invalid @enderror" 
                                                               style="width: 150px;" name="documentary_stamp_tax" value="{{ old('documentary_stamp_tax') }}" placeholder="PHP">
                                                        @error('documentary_stamp_tax')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="premium-row">
                                                        <span>Local Government tax</span>
                                                        <input type="text" class="form-control form-control-sm @error('local_gov_tax') is-invalid @enderror" 
                                                               style="width: 150px;" name="local_gov_tax" value="{{ old('local_gov_tax') }}" placeholder="PHP">
                                                        @error('local_gov_tax')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="premium-row total-row">
                                                        <span>AMOUNT DUE</span>
                                                        <input type="text" class="form-control form-control-sm fw-bold @error('amount_due') is-invalid @enderror" 
                                                               style="width: 150px;" name="amount_due" value="{{ old('amount_due') }}" placeholder="PHP">
                                                        @error('amount_due')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="premium-row">
                                                        <span>COC VP</span>
                                                        <input type="text" class="form-control form-control-sm @error('coc_vp') is-invalid @enderror" 
                                                               style="width: 150px;" name="coc_vp" value="{{ old('coc_vp', '0.00') }}" placeholder="PHP">
                                                        @error('coc_vp')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-12 mt-3">
                                                        <label class="form-label">Remarks</label>
                                                        <textarea class="form-control @error('premium_remarks') is-invalid @enderror" 
                                                                  name="premium_remarks" rows="3" placeholder="Enter remarks">{{ old('premium_remarks') }}</textarea>
                                                        @error('premium_remarks')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="reset" class="btn btn-secondary me-2">Reset</button>
                                    <button type="submit" class="btn btn-primary">Submit Policy</button>
                                </div>
                            </form>
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

    <script>
        // Bank transfer options based on insurance provider
        const bankOptions = {
            'MERCANTILE': ['BDO', 'Metrobank', 'BPI'],
            'MALAYAN': ['Bills payment'],
            'FPG': ['BDO'],
            'FORTUNE_GEN': ['BDO', 'Union Bank', 'BPI', 'GCash'],
            'COCOGEN': ['No specific banks'],
            'COUNTRY_BANKER': ['BPI', 'Union Bank'],
            'STANDARD': ['BDO']
        };

        // Details switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const policyDetailsBtn = document.getElementById('policyDetailsBtn');
            const walkinDetailsBtn = document.getElementById('walkinDetailsBtn');
            const policyDetails = document.getElementById('policyDetails');
            const walkinDetails = document.getElementById('walkinDetails');
            const insuranceProvider = document.getElementById('insuranceProvider');
            const paymentMethod = document.getElementById('paymentMethod');
            const bankTransferFields = document.getElementById('bankTransferFields');
            const bankTransfer = document.getElementById('bankTransfer');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const pageContent = document.getElementById('pageContent');

            console.log('DOM loaded - initializing functionality');

            // Initialize the details sections
            if (policyDetails && walkinDetails) {
                policyDetails.classList.add('active');
                walkinDetails.classList.remove('active');
            }

            // Show Policy Details
            if (policyDetailsBtn) {
                policyDetailsBtn.addEventListener('click', function() {
                    console.log('Policy Details button clicked');
                    if (policyDetails && walkinDetails) {
                        policyDetails.classList.add('active');
                        walkinDetails.classList.remove('active');
                        policyDetailsBtn.classList.remove('btn-outline-primary');
                        policyDetailsBtn.classList.add('btn-primary');
                        walkinDetailsBtn.classList.remove('btn-primary');
                        walkinDetailsBtn.classList.add('btn-outline-primary');
                    }
                });
            }

            // Show Walk-in Details
            if (walkinDetailsBtn) {
                walkinDetailsBtn.addEventListener('click', function() {
                    console.log('Walk-in Details button clicked');
                    if (policyDetails && walkinDetails) {
                        walkinDetails.classList.add('active');
                        policyDetails.classList.remove('active');
                        walkinDetailsBtn.classList.remove('btn-outline-primary');
                        walkinDetailsBtn.classList.add('btn-primary');
                        policyDetailsBtn.classList.remove('btn-primary');
                        policyDetailsBtn.classList.add('btn-outline-primary');
                    }
                });
            }

            // Show/hide bank transfer fields based on payment method
            if (paymentMethod) {
                paymentMethod.addEventListener('change', function() {
                    console.log('Payment method changed to:', this.value);
                    if (this.value === 'Transfer' && bankTransferFields) {
                        bankTransferFields.classList.add('show');
                        updateBankOptions();
                    } else if (bankTransferFields) {
                        bankTransferFields.classList.remove('show');
                    }
                });
            }

            // Update bank options when insurance provider changes
            if (insuranceProvider) {
                insuranceProvider.addEventListener('change', function() {
                    console.log('Insurance provider changed to:', this.value);
                    if (paymentMethod && paymentMethod.value === 'Transfer') {
                        updateBankOptions();
                    }
                });
            }

            // Mobile sidebar toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    document.body.classList.toggle('sidebar-collapsed');
                });
            }

            function updateBankOptions() {
                const provider = insuranceProvider.value;
                console.log('Updating bank options for provider:', provider);
                
                const banks = bankOptions[provider] || [];
                
                // Clear existing options
                if (bankTransfer) {
                    bankTransfer.innerHTML = '<option value="">Select bank</option>';
                    
                    // Add new options
                    banks.forEach(bank => {
                        const option = document.createElement('option');
                        option.value = bank;
                        option.textContent = bank;
                        bankTransfer.appendChild(option);
                    });
                    
                    // If no banks available for the provider
                    if (banks.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'No banks available for this provider';
                        bankTransfer.appendChild(option);
                        bankTransfer.disabled = true;
                    } else {
                        bankTransfer.disabled = false;
                    }
                    
                    console.log('Bank options updated. Available banks:', banks);
                }
            }

            // Initialize the form state
            updateBankOptions();
        });
    </script>
</body>
</html>