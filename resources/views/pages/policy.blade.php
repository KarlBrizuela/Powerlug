<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Form - Powerlug</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
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
        
        /* Freebie date picker styles */
        .freebie-date-container {
            display: flex;
            gap: 10px;
            align-items: end;
        }
        
        .freebie-select {
            flex: 1;
        }

        /* Services input wrapper styles */
        .services-input-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            background-color: #fff;
            min-height: 42px;
            align-items: center;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .services-input-wrapper:focus-within {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .services-dropdown {
            border: none !important;
            padding: 0 !important;
            flex: 1;
            min-width: 150px;
            background: transparent !important;
            outline: none;
            font-family: inherit;
        }

        .services-dropdown:focus {
            outline: none;
            box-shadow: none;
        }

        .services-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background-color: #0d6efd;
            color: white;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .services-badge .btn-remove {
            background: none;
            border: none;
            color: white;
            padding: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            font-size: 14px;
            line-height: 1;
        }

        .services-badge .btn-remove:hover {
            opacity: 0.8;
        }
        
        .date-picker-container {
            flex: 1;
        }

        /* Service payment due styles */
        .service-with-due {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 8px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 8px;
            width: 100%;
        }

        .service-info {
            flex: 1;
        }

        .service-badge-small {
            display: inline-block;
            padding: 4px 8px;
            background-color: #0d6efd;
            color: white;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .service-due-date-input {
            flex: 0 0 auto;
            width: 150px;
        }

        .service-remove-btn {
            flex: 0 0 auto;
            background: #dc3545;
            border: none;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.2s;
        }

        .service-remove-btn:hover {
            background: #bb2d3b;
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Client Form</h2>
                        <a href="{{ route('policies.index') }}" class="btn btn-primary">
                            <i class="fas fa-list"></i> Policy List
                        </a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                           

                            @if ($errors->has('details'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Validation Error:</strong> {{ $errors->first('details') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('policies.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Primary Information Section -->
                                <div class="section-container mb-4">
                                    <div class="section-title">Primary Information</div>
                                    <div class="section-content">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Client Name</label>
                                                <select class="form-select @error('client_id') is-invalid @enderror" id="clientSelect" name="client_id">
                                                    <option value="">Select or type to search client...</option>
                                                    @if(isset($clients))
                                                        @foreach($clients as $client)
                                                            <option value="{{ $client->id }}" 
                                                                data-email="{{ $client->email }}" 
                                                                data-phone="{{ $client->phone }}" 
                                                                data-address="{{ $client->address }}"
                                                                data-make-model="{{ $client->make_model ?? '' }}"
                                                                data-plate-number="{{ $client->plate_no ?? '' }}"
                                                                data-model-year="{{ $client->model_year ?? '' }}"
                                                                data-color="{{ $client->color ?? '' }}"
                                                                data-old-plate="{{ $client->plate_no }}"
                                                                {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                                {{ $client->firstName }} {{ $client->middleName }} {{ $client->lastName }} @if($client->plate_no)({{ $client->plate_no }})@endif
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <input type="hidden" name="client_name" id="clientNameHidden" value="{{ old('client_name') }}">
                                                @error('client_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @error('client_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="clientAddress"
                                                    name="address" value="{{ old('address') }}">
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="clientEmail"
                                                    name="email" value="{{ old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Contact Number</label>
                                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="clientPhone"
                                                    name="contact_number" value="{{ old('contact_number') }}">
                                                @error('contact_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                              <label class="form-label">Make Model</label>
                              <input type="text" class="form-control @error('make_model') is-invalid @enderror" id="makeModelPolicy"
                                  name="make_model" value="{{ old('make_model') }}">
                                                @error('make_model')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                              <label class="form-label">Plate No.</label>
                              <select class="form-select @error('plate_number') is-invalid @enderror" id="plateNumberSelectPolicy" name="plate_number">
                                  <option value="">Select vehicle...</option>
                              </select>
                              <small class="form-text text-muted">Or enter manually:</small>
                              <input type="text" class="form-control @error('plate_number') is-invalid @enderror" id="plateNumberInputPolicy"
                                  placeholder="Enter plate number manually" style="display: none;">
                                                @error('plate_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                              <label class="form-label">Model Year</label>
                              <input type="text" class="form-control @error('model_year') is-invalid @enderror" id="modelYearPolicy"
                                  name="model_year" value="{{ old('model_year') }}">
                                                @error('model_year')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                              <label class="form-label">Color</label>
                              <input type="text" class="form-control @error('color') is-invalid @enderror" id="colorPolicy"
                                  name="color" value="{{ old('color') }}">
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
                                            </div>

                                            <!-- Policy Details (Default) -->
                                            <div id="policyDetails" class="details-content active">
                                                <div class="row mb-2">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Insurance Provider</label>
                                <select class="form-select @error('insurance_provider_id') is-invalid @enderror" 
                                    id="insuranceProvider" name="insurance_provider_id">
                                                                <option value="">Select insurance provider</option>
                                                                @foreach($insuranceProviders as $provider)
                                                                    <option value="{{ $provider->id }}" data-code="{{ $provider->code }}" data-banks='@json($provider->banks)' {{ old('insurance_provider_id') == $provider->id ? 'selected' : '' }}>
                                                                        {{ $provider->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('insurance_provider_id')
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
                                                    <div class="col-md-3">
                                                        <label class="form-label">File Upload</label>
                                                        <input type="file" class="form-control @error('policy_file') is-invalid @enderror" 
                                                               name="policy_file">
                                                        @error('policy_file')
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
                                                        <div class="freebie-date-container">
                                                            <div class="freebie-select">
                                                                <select class="form-select @error('freebie') is-invalid @enderror" name="freebie" id="freebieSelect">
                                                                    <option value="">Select freebie</option>
                                                                    @if(isset($freebies) && $freebies->count())
                                                                        @foreach($freebies as $f)
                                                                            <option value="{{ $f->name }}" {{ old('freebie') == $f->name ? 'selected' : '' }}>{{ $f->name }}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach(['Undercoat', 'Buffing'] as $freebie)
                                                                            <option value="{{ $freebie }}" {{ old('freebie') == $freebie ? 'selected' : '' }}>{{ $freebie }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                @error('freebie')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="date-picker-container">
                                                                <label class="form-label">Date Availed</label>
                                                                <input type="date" class="form-control @error('freebie_date') is-invalid @enderror" 
                                                                       name="freebie_date" id="freebieDate" value="{{ old('freebie_date') }}">
                                                                @error('freebie_date')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
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
                                                    <div class="premium-row">
                                                        <span>Services Subtotal</span>
                                                        <input type="text" class="form-control form-control-sm" 
                                                               style="width: 150px;" id="servicesSubtotalCreate" value="0.00" readonly>
                                                    </div>
                                                    <div class="premium-row total-row">
                                                        <span>AMOUNT DUE</span>
                                                        <input type="text" class="form-control form-control-sm fw-bold @error('amount_due') is-invalid @enderror" 
                                                               style="width: 150px;" name="amount_due" value="{{ old('amount_due') }}" placeholder="PHP" readonly>
                                                        @error('amount_due')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
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
                                        <!-- Additional Information -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
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
                                            <div class="col-md-4">
                                                <label class="form-label">Paid Amount</label>
                                                <input type="text" class="form-control @error('paid_amount') is-invalid @enderror" 
                                                       name="paid_amount" id="paidAmount" value="{{ old('paid_amount') }}" placeholder="Enter paid amount">
                                                @error('paid_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Proof of Payment</label>
                                                <input type="file" class="form-control @error('proof_of_payment') is-invalid @enderror" 
                                                       name="proof_of_payment" accept=".pdf,.jpg,.jpeg,.png,.gif,.doc,.docx" 
                                                       placeholder="Upload proof">
                                                @error('proof_of_payment')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Balance (Remaining Amount)</label>
                                                <input type="text" class="form-control" id="balanceAmount" readonly 
                                                       value="0.00" style="background-color: #e9ecef; font-weight: bold;">
                                                <small class="text-muted">This is calculated automatically (Amount Due - Paid Amount)</small>
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
                                                    
                                                    <!-- Manual bank input when provider has no banks or user selects Other -->
                                                    <input type="text" id="bankOther" name="bank_transfer_other" 
                                                           class="form-control mt-2 @error('bank_transfer_other') is-invalid @enderror" 
                                                           style="display:none;" placeholder="Enter bank name">
                                                    @error('bank_transfer_other')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                           

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
            const insuranceProvider = document.getElementById('insuranceProvider');
            const paymentMethod = document.getElementById('paymentMethod');
            const bankTransferFields = document.getElementById('bankTransferFields');
            const bankTransfer = document.getElementById('bankTransfer');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const pageContent = document.getElementById('pageContent');
            const freebieSelect = document.getElementById('freebieSelect');
            const freebieDate = document.getElementById('freebieDate');
            const additionalFreebieSelect = document.getElementById('additionalFreebieSelect');
            const additionalFreebieDate = document.getElementById('additionalFreebieDate');

            console.log('DOM loaded - initializing functionality');

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

            // Show manual bank input when "Other" selected
            if (bankTransfer) {
                bankTransfer.addEventListener('change', function() {
                    const bankOther = document.getElementById('bankOther');
                    if (!bankOther) return;
                    if (this.value === 'OTHER') {
                        bankOther.style.display = 'block';
                    } else {
                        bankOther.style.display = 'none';
                        bankOther.value = '';
                    }
                });
            }

            // Update bank options when insurance provider changes
            if (insuranceProvider) {
                insuranceProvider.addEventListener('change', function() {
                    // provider value is the id; read data-code for mapping
                    const selectedCode = this.selectedOptions && this.selectedOptions[0] ? this.selectedOptions[0].dataset.code : this.value;
                    console.log('Insurance provider changed to code:', selectedCode);
                    if (paymentMethod && paymentMethod.value === 'Transfer') {
                        updateBankOptions();
                    }
                });
            }

            // Set current date as default for freebie date fields when a freebie is selected
            if (freebieSelect) {
                freebieSelect.addEventListener('change', function() {
                    if (this.value && !freebieDate.value) {
                        freebieDate.value = new Date().toISOString().split('T')[0];
                    }
                });
            }

            if (additionalFreebieSelect) {
                additionalFreebieSelect.addEventListener('change', function() {
                    if (this.value && !additionalFreebieDate.value) {
                        additionalFreebieDate.value = new Date().toISOString().split('T')[0];
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
                const selectedOption = insuranceProvider && insuranceProvider.selectedOptions && insuranceProvider.selectedOptions[0] ? insuranceProvider.selectedOptions[0] : null;
                const providerId = insuranceProvider ? insuranceProvider.value : null;
                const providerName = selectedOption ? selectedOption.textContent.trim() : '';

                // Prefer provider-specific banks provided in data-banks attribute
                let banks = [];
                const dataBanks = selectedOption ? selectedOption.dataset.banks : null;
                if (dataBanks) {
                    try {
                        const parsed = JSON.parse(dataBanks);
                        if (Array.isArray(parsed)) {
                            banks = parsed;
                        }
                    } catch (e) {
                        banks = (dataBanks || '').toString().split(/[\r\n,]+/).map(s => s.trim()).filter(Boolean);
                    }
                }

                if (banks.length === 0) {
                    const providerCode = (selectedOption ? selectedOption.dataset.code : '') || providerName || providerId;
                    banks = bankOptions[providerCode] || [];
                }

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

                    // If no banks available for the provider, offer "Other" so user can enter manually
                    if (banks.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'No banks available for this provider';
                        bankTransfer.appendChild(option);

                        const otherOption = document.createElement('option');
                        otherOption.value = 'OTHER';
                        otherOption.textContent = 'Other (specify)';
                        bankTransfer.appendChild(otherOption);

                        bankTransfer.disabled = false;
                    } else {
                        bankTransfer.disabled = false;
                    }

                    console.log('Bank options updated. Available banks:', banks);
                }
            }

            // Initialize the form state
            updateBankOptions();

            // Services selection functionality
            const serviceDropdown = document.getElementById('serviceDropdown');
            const servicesInputGroup = document.getElementById('servicesInputGroup');
            let selectedServices = [];

            // Load existing services from page load (badges may be server-rendered in edit)
            document.querySelectorAll('#servicesInputGroup .services-badge').forEach(badge => {
                const service = badge.dataset.service;
                const price = parseFloat(badge.dataset.price) || 0;
                const dueDate = badge.dataset.dueDate || '';
                if (service) {
                    selectedServices.push({ name: service, price: price, paymentDue: dueDate });
                }
            });

            // Add service when dropdown selection changes
            serviceDropdown.addEventListener('change', function() {
                const selectedValue = this.value;
                const opt = this.selectedOptions && this.selectedOptions[0] ? this.selectedOptions[0] : null;
                const price = opt && opt.dataset && opt.dataset.price ? parseFloat(opt.dataset.price) || 0 : 0;
                if (selectedValue && !selectedServices.some(s => s.name === selectedValue)) {
                    // Prompt user for payment due date
                    const dueDate = prompt(`When is the payment due for "${selectedValue}"? (Enter date as YYYY-MM-DD or leave blank)`);
                    selectedServices.push({ name: selectedValue, price: price, paymentDue: dueDate || '' });
                    renderServices();
                    this.value = ''; // Reset dropdown
                }
            });

            // Render the selected services as badges inside the input group
            function renderServices() {
                const dropdown = document.getElementById('serviceDropdown');
                
                // Clear existing service elements (both badges and new format)
                const existingBadges = servicesInputGroup.querySelectorAll('.services-badge, .service-with-due');
                existingBadges.forEach(badge => badge.remove());
                
                // Always keep dropdown visible
                dropdown.style.display = 'block';
                
                // Hide/show placeholder text based on selections
                const placeholderOption = dropdown.querySelector('option[value=""]');
                if (selectedServices.length > 0) {
                    placeholderOption.style.display = 'none';
                } else {
                    placeholderOption.style.display = 'block';
                }
                
                // Add new service elements before the dropdown (show name, price, and due date)
                selectedServices.forEach(svc => {
                    const serviceContainer = document.createElement('div');
                    serviceContainer.className = 'service-with-due';
                    serviceContainer.dataset.service = svc.name;
                    serviceContainer.dataset.price = svc.price || 0;
                    serviceContainer.dataset.dueDate = svc.paymentDue || '';
                    
                    serviceContainer.innerHTML = `
                        <div class="service-info">
                            <span class="service-badge-small">${svc.name} - ₱ ${Number(svc.price || 0).toFixed(2)}</span>
                        </div>
                        <div class="service-due-date-input">
                            <input type="date" class="form-control form-control-sm service-due-date" 
                                   value="${svc.paymentDue || ''}" 
                                   placeholder="Payment due date">
                        </div>
                        <button type="button" class="service-remove-btn" aria-label="Remove ${svc.name}">Remove</button>
                    `;
                    servicesInputGroup.insertBefore(serviceContainer, dropdown);

                    // Add event listener to update payment due when date changes
                    const dateInput = serviceContainer.querySelector('.service-due-date');
                    dateInput.addEventListener('change', function() {
                        const serviceIndex = selectedServices.findIndex(x => x.name === svc.name);
                        if (serviceIndex !== -1) {
                            selectedServices[serviceIndex].paymentDue = this.value;
                        }
                    });

                    // Add remove handler
                    serviceContainer.querySelector('.service-remove-btn').addEventListener('click', function(e) {
                        e.preventDefault();
                        selectedServices = selectedServices.filter(x => x.name !== svc.name);
                        renderServices();
                    });
                });

                // Create hidden inputs for form submission
                const container = document.createElement('div');
                container.id = 'servicesContainer';
                selectedServices.forEach((svc, index) => {
                    const serviceInput = document.createElement('input');
                    serviceInput.type = 'hidden';
                    serviceInput.name = 'services[]';
                    serviceInput.value = svc.name;
                    container.appendChild(serviceInput);

                    const dueInput = document.createElement('input');
                    dueInput.type = 'hidden';
                    dueInput.name = 'service_payment_dues[]';
                    dueInput.value = svc.paymentDue || '';
                    container.appendChild(dueInput);
                });
                
                // Log services data for debugging
                console.log('Selected Services:', selectedServices);
                console.log('Service Payment Dues Inputs:', Array.from(container.querySelectorAll('input[name="service_payment_dues[]"]')).map(el => el.value));
                
                // Replace old container if exists, otherwise add it
                const oldContainer = document.getElementById('servicesContainer');
                if (oldContainer) {
                    oldContainer.replaceWith(container);
                } else {
                    servicesInputGroup.parentElement.appendChild(container);
                }
                // Keep global reference updated so amount calculation can read latest services
                window.selectedServices = selectedServices;
                
                // Update services subtotal directly
                const servicesTotal = selectedServices.reduce((sum, s) => sum + (parseFloat(s.price) || 0), 0);
                const servicesSubtotalEl = document.getElementById('servicesSubtotalCreate');
                if (servicesSubtotalEl) {
                    servicesSubtotalEl.value = servicesTotal.toFixed(2);
                }
                
                // Force direct calculation of amount due without relying on jQuery
                const premium = parseFloat(document.querySelector('input[name="premium"]')?.value) || 0;
                const vat = parseFloat(document.querySelector('input[name="vat"]')?.value) || 0;
                const docStampTax = parseFloat(document.querySelector('input[name="documentary_stamp_tax"]')?.value) || 0;
                const localGovTax = parseFloat(document.querySelector('input[name="local_gov_tax"]')?.value) || 0;
                const totalAmountDue = premium + vat + docStampTax + localGovTax + servicesTotal;
                const amountDueInput = document.querySelector('input[name="amount_due"]');
                if (amountDueInput) {
                    amountDueInput.value = totalAmountDue.toFixed(2);
                }
                
                // Recalculate balance
                const paidAmountEl = document.getElementById('paidAmount');
                if (paidAmountEl) {
                    const paidAmount = parseFloat(paidAmountEl.value) || 0;
                    const balance = totalAmountDue - paidAmount;
                    const balanceEl = document.getElementById('balanceAmount');
                    if (balanceEl) {
                        balanceEl.value = balance.toFixed(2);
                        if (balance <= 0) {
                            balanceEl.style.color = '#198754';
                            balanceEl.style.fontWeight = 'bold';
                        } else {
                            balanceEl.style.color = '#dc3545';
                            balanceEl.style.fontWeight = 'bold';
                        }
                    }
                }
                
                if (typeof calculateAmountDue === 'function') {
                    calculateAmountDue();
                }
            }

            // Initial render if there are old services
            if (selectedServices.length > 0) {
                // Delay initial render until jQuery ready to ensure calculateAmountDue is available
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', renderServices);
                } else {
                    setTimeout(renderServices, 100);
                }
            }

            // Trigger initial calculation on page load
            if (typeof calculateAmountDue === 'function') {
                calculateAmountDue();
            }
        });
    </script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for services
            $('#services').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select services',
                allowClear: true,
                closeOnSelect: false
            });

            // Initialize Select2 for client dropdown
            $('#clientSelect').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select or type to search client...',
                allowClear: true
            });

            // Handle client selection change
            $('#clientSelect').on('change', function() {
                const selectedOption = $(this).find(':selected');
                const clientId = $(this).val();
                
                if (clientId) {
                    // Get client data from option attributes
                    const email = selectedOption.data('email') || '';
                    const phone = selectedOption.data('phone') || '';
                    const address = selectedOption.data('address') || '';
                    const makeModel = selectedOption.data('make-model') || '';
                    const plateNumber = selectedOption.data('plate-number') || '';
                    const modelYear = selectedOption.data('model-year') || '';
                    const color = selectedOption.data('color') || '';
                    const clientName = selectedOption.text().trim();
                    
                    // Fill the form fields
                    $('#clientEmail').val(email);
                    $('#clientPhone').val(phone);
                    $('#clientAddress').val(address);
                    $('#clientNameHidden').val(clientName);
                    $('#makeModelPolicy').val(makeModel);
                    $('#modelYearPolicy').val(modelYear);
                    $('#colorPolicy').val(color);
                    
                    // Load vehicles for this client via AJAX
                    $.ajax({
                        url: '/api/clients/' + clientId + '/vehicles',
                        type: 'GET',
                        dataType: 'json',
                        success: function(vehicles) {
                            const plateSelect = $('#plateNumberSelectPolicy');
                            const oldPlate = selectedOption.data('old-plate') || '';
                            plateSelect.empty();
                            plateSelect.append('<option value="">Select vehicle...</option>');
                            
                            if (vehicles.length > 0) {
                                vehicles.forEach(function(vehicle, index) {
                                    let displayText = vehicle.plate_number + ' - ' + vehicle.make_model;
                                    
                                    // Add "Primary" label for the old plate number
                                    if (vehicle.plate_number === oldPlate) {
                                        displayText += ' (Primary)';
                                    }
                                    
                                    plateSelect.append(
                                        `<option value="${vehicle.plate_number}" 
                                            data-make-model="${vehicle.make_model}" 
                                            data-model-year="${vehicle.model_year}" 
                                            data-color="${vehicle.color}">
                                            ${displayText}
                                        </option>`
                                    );
                                });
                                
                                // Auto-select first vehicle and trigger change
                                plateSelect.val(vehicles[0].plate_number).change();
                            }
                            
                            // Show vehicle dropdown if vehicles exist, hide manual input
                            if (vehicles.length > 0) {
                                plateSelect.show();
                                $('#plateNumberInputPolicy').hide().removeAttr('name');
                            } else {
                                plateSelect.hide();
                                $('#plateNumberInputPolicy').show().attr('name', 'plate_number');
                                $('#plateNumberInputPolicy').val(plateNumber || '');
                            }
                        },
                        error: function() {
                            // Fallback to manual input if AJAX fails
                            $('#plateNumberSelectPolicy').hide();
                            $('#plateNumberInputPolicy').show().attr('name', 'plate_number');
                            $('#plateNumberInputPolicy').val(plateNumber || '');
                        }
                    });
                } else {
                    // Clear fields if no client selected
                    $('#clientEmail').val('');
                    $('#clientPhone').val('');
                    $('#clientAddress').val('');
                    $('#clientNameHidden').val('');
                    $('#makeModelPolicy').val('');
                    $('#plateNumberSelectPolicy').empty().append('<option value="">Select vehicle...</option>');
                    $('#plateNumberInputPolicy').hide().val('');
                    $('#modelYearPolicy').val('');
                    $('#colorPolicy').val('');
                }
            });

            // Handle vehicle selection change
            $('#plateNumberSelectPolicy').on('change', function() {
                const selectedOption = $(this).find(':selected');
                const makeModel = selectedOption.data('make-model') || '';
                const modelYear = selectedOption.data('model-year') || '';
                const color = selectedOption.data('color') || '';
                
                // Auto-fill vehicle details
                $('#makeModelPolicy').val(makeModel);
                $('#modelYearPolicy').val(modelYear);
                $('#colorPolicy').val(color);
            });

            // Trigger change on page load if a client is already selected (for edit mode)
            if ($('#clientSelect').val()) {
                $('#clientSelect').trigger('change');
            }

            // Auto-calculate Amount Due
            function calculateAmountDue() {
                const premium = parseFloat($('input[name="premium"]').val()) || 0;
                const vat = parseFloat($('input[name="vat"]').val()) || 0;
                const docStampTax = parseFloat($('input[name="documentary_stamp_tax"]').val()) || 0;
                const localGovTax = parseFloat($('input[name="local_gov_tax"]').val()) || 0;

                // Sum selected services prices (if any)
                const services = window.selectedServices || [];
                const servicesTotal = services.reduce((sum, s) => sum + (parseFloat(s.price) || 0), 0);

                // Update services subtotal field
                $('#servicesSubtotalCreate').val(servicesTotal.toFixed(2));

                const amountDue = premium + vat + docStampTax + localGovTax + servicesTotal;
                $('input[name="amount_due"]').val(amountDue.toFixed(2));
                
                // Also update balance when amount due changes
                calculateBalance();
            }

            // Calculate Balance (Amount Due - Paid Amount)
            function calculateBalance() {
                const amountDue = parseFloat($('input[name="amount_due"]').val()) || 0;
                const paidAmount = parseFloat($('#paidAmount').val()) || 0;
                
                const balance = amountDue - paidAmount;
                $('#balanceAmount').val(balance.toFixed(2));
                
                // Change color based on balance
                if (balance <= 0) {
                    $('#balanceAmount').css({'color': '#198754', 'font-weight': 'bold'}); // Green for paid
                } else {
                    $('#balanceAmount').css({'color': '#dc3545', 'font-weight': 'bold'}); // Red for unpaid
                }
            }

            // Attach event listeners to premium fields
            $('input[name="premium"], input[name="vat"], input[name="documentary_stamp_tax"], input[name="local_gov_tax"]').on('input', function() {
                calculateAmountDue();
            });

            // Attach event listener to paid amount
            $('#paidAmount').on('input', function() {
                calculateBalance();
            });

            // Also recalculate balance when amount due changes manually
            $('input[name="amount_due"]').on('input', function() {
                calculateBalance();
            });

            // Payment Terms - Calculate installment amounts
            $('select[name="payment_terms"]').on('change', function() {
                const amountDue = parseFloat($('input[name="amount_due"]').val()) || 0;
                const paidAmountInput = $('#paidAmount');
                let divisor = 1;

                // Determine divisor based on payment terms
                if (this.value === '30 days') {
                    divisor = 2;
                } else if (this.value === '60 days') {
                    divisor = 3;
                } else if (this.value === '90 days') {
                    divisor = 4;
                }

                // Calculate paid amount
                const calculatedPaidAmount = amountDue / divisor;
                paidAmountInput.val(calculatedPaidAmount.toFixed(2));

                // Trigger balance calculation
                calculateBalance();
            });

            // Calculate on page load if values exist
            calculateAmountDue();
            calculateBalance();
        });
    </script>
</body>
</html>