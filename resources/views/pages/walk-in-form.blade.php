<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walk-in Form - Powerlug</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Main layout styles for sidebar integration */
        .page-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .page-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .page-content {
                margin-left: 0;
                padding: 15px;
            }
        }

        /* Card styling */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        /* Section styles */
        .section-container {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #007bff;
            display: inline-block;
        }

        .section-content {
            padding: 1.5rem 0;
        }

        /* Form styling */
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Table styling */
        .table-bordered {
            border: 1px solid #e9ecef;
        }

        .table-bordered td {
            padding: 0.75rem;
            vertical-align: middle;
            border: 1px solid #e9ecef;
        }

        .table-bordered tr:last-child {
            background-color: #f8f9fa;
        }

        /* Button styling */
        .btn {
            border-radius: 0.375rem;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        /* Page header */
        .page-title-box {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }

        .page-title-box h3 {
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
        }

        /* Alert styling */
        .alert {
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }

        /* Number input styling */
        .text-end input {
            text-align: right;
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

        /* Services styling */
        .services-input-wrapper {
            margin-bottom: 1rem;
        }

        .services-dropdown {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.95rem;
        }

        .services-dropdown:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        #servicesContainer {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        #servicesContainer > div {
            background-color: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            font-size: 0.9rem;
        }

        #servicesContainer > div span {
            color: #0c5aa0;
            font-weight: 500;
        }

        #servicesContainer > div .btn-danger {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .page-content {
                padding: 10px;
            }

            .card-body {
                padding: 1.5rem 1rem;
            }

            .btn {
                padding: 0.4rem 1rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    @include('components.sidebar')
    
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h3>Walk-in Form</h3>
                    <a href="{{ route('walk-in.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list me-2"></i> Back to List
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading">Validation Error</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                                            <label class="form-label">Client Name <span class="text-danger">*</span></label>
                                            <select class="form-select @error('client_id') is-invalid @enderror" id="clientSelect" name="client_id" required>
                                                <option value="">Select or type to search client...</option>
                                                @if(isset($clients))
                                                    @foreach($clients as $client)
                                                        <option value="{{ $client->id }}" 
                                                            data-email="{{ $client->email }}" 
                                                            data-phone="{{ $client->phone }}" 
                                                            data-address="{{ $client->address }}"
                                                            data-make-model="{{ $client->make_model }}"
                                                            data-plate-no="{{ $client->plate_no }}"
                                                            data-model-year="{{ $client->model_year }}"
                                                            data-color="{{ $client->color }}"
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
                                            <input type="text" class="form-control @error('make_model') is-invalid @enderror" 
                                                id="clientMakeModel" name="make_model" value="{{ old('make_model') }}">
                                            @error('make_model')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Plate No.</label>
                                            <select class="form-select @error('plate_number') is-invalid @enderror" 
                                                id="plateNumberSelectWalkin" name="plate_number">
                                                <option value="">Select vehicle...</option>
                                            </select>
                                            <small class="form-text text-muted">Or enter manually:</small>
                                            <input type="text" class="form-control @error('plate_number') is-invalid @enderror" 
                                                id="clientPlateNumber" placeholder="Enter plate number manually" style="display: none;">
                                            @error('plate_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Model Year</label>
                                            <input type="text" class="form-control @error('model_year') is-invalid @enderror" 
                                                id="clientModelYear" name="model_year" value="{{ old('model_year') }}">
                                            @error('model_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Color</label>
                                            <input type="text" class="form-control @error('color') is-invalid @enderror"
                                                id="clientColor" name="color" value="{{ old('color') }}">
                                            @error('color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Walk-in Details Section -->
                            <div class="section-container mb-4">
                                <div class="section-title">Walk-in Details</div>
                                <div class="section-content">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('walkin_date') is-invalid @enderror" 
                                                   name="walkin_date" value="{{ old('walkin_date') }}" required>
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
                                            <div class="services-input-wrapper" id="servicesInputGroup">
                                                <select class="services-dropdown form-select" id="serviceDropdown">
                                                    <option value="">Select a service to add</option>
                                                    @if(isset($services) && $services->count())
                                                        @foreach($services as $s)
                                                            <option value="{{ $s->name }}" data-price="{{ number_format((float)$s->price, 2, '.', '') }}">{{ $s->name }} - ₱ {{ number_format((float)$s->price, 2) }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="Carwash" data-price="0.00">Carwash</option>
                                                        <option value="Change Oil" data-price="0.00">Change Oil</option>
                                                        <option value="Etc" data-price="0.00">Etc</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div id="servicesContainer"></div>
                                            @error('services')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Premium Summary Section -->
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
                                                    <span>Local Government Tax</span>
                                                    <input type="text" class="form-control form-control-sm @error('local_gov_tax') is-invalid @enderror" 
                                                           style="width: 150px;" name="local_gov_tax" value="{{ old('local_gov_tax') }}" placeholder="PHP">
                                                    @error('local_gov_tax')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="premium-row">
                                                    <span>Services Subtotal</span>
                                                    <input type="text" class="form-control form-control-sm" 
                                                           style="width: 150px;" id="servicesSubtotalWalkin" value="0.00" readonly>
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

                            <!-- Payment & Summary Section -->
                            <div class="section-container mb-4">
                                <div class="section-title">Payment Information</div>
                                <div class="section-content">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Payment Terms</label>
                                            <select class="form-select @error('payment_terms') is-invalid @enderror" name="payment_terms">
                                                <option value="">Choose payment method</option>
                                                @foreach(['Full payment','30 days','60 days','90 days'] as $term)
                                                    <option value="{{ $term }}" {{ old('payment_terms') == $term ? 'selected' : '' }}>{{ $term }}</option>
                                                @endforeach
                                            </select>
                                            @error('payment_terms')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Paid Amount</label>
                                            <input type="text" class="form-control @error('paid_amount') is-invalid @enderror" 
                                                   name="paid_amount" id="paidAmountWalkin" value="{{ old('paid_amount') }}" placeholder="Enter paid amount">
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
                                            <input type="text" class="form-control" id="balanceAmountWalkin" readonly 
                                                   value="0.00" style="background-color: #e9ecef; font-weight: bold;">
                                            <small class="text-muted">This is calculated automatically (Amount Due - Paid Amount)</small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Payment Method</label>
                                            <select class="form-select @error('payment_method') is-invalid @enderror" 
                                                    id="paymentMethodWalkin" name="payment_method">
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
                                            <div class="bank-transfer-fields" id="bankTransferFieldsWalkin">
                                                <label class="form-label">Bank Transfer To</label>
                                                <select class="form-select @error('bank_transfer') is-invalid @enderror" 
                                                        id="bankTransferWalkin" name="bank_transfer">
                                                    <option value="">Select bank</option>
                                                    <option value="OTHER">Other (specify)</option>
                                                </select>
                                                @error('bank_transfer')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                
                                                <!-- Manual bank input when user selects Other -->
                                                <input type="text" id="bankOtherWalkin" name="bank_transfer_other" 
                                                       class="form-control mt-2 @error('bank_transfer_other') is-invalid @enderror" 
                                                       style="display:none;" placeholder="Enter bank name">
                                                @error('bank_transfer_other')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
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

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Remarks</label>
                                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                                      name="remarks" rows="3">{{ old('remarks') }}</textarea>
                                            @error('remarks')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Proof of Payment</label>
                                            <input type="file" class="form-control @error('proof_of_payment') is-invalid @enderror" 
                                                   name="proof_of_payment" accept=".pdf,.jpg,.jpeg,.png,.gif,.doc,.docx" 
                                                   placeholder="Upload proof of payment (receipt, screenshot, etc.)">
                                            <small class="text-muted d-block mt-1">Accepted formats: PDF, JPG, PNG, GIF, DOC, DOCX (Max 5MB)</small>
                                            @error('proof_of_payment')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('walk-in.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-redo me-2"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Client selection - populate client data
        document.addEventListener('DOMContentLoaded', function() {
            const clientSelect = document.getElementById('clientSelect');
            const clientNameHidden = document.getElementById('clientNameHidden');
            const clientEmail = document.getElementById('clientEmail');
            const clientPhone = document.getElementById('clientPhone');
            const clientAddress = document.getElementById('clientAddress');
            const clientMakeModel = document.getElementById('clientMakeModel');
            const clientPlateNumber = document.getElementById('clientPlateNumber');
            const clientModelYear = document.getElementById('clientModelYear');
            const clientColor = document.getElementById('clientColor');
            const paymentMethodWalkin = document.getElementById('paymentMethodWalkin');
            const bankTransferFieldsWalkin = document.getElementById('bankTransferFieldsWalkin');
            const bankTransferWalkin = document.getElementById('bankTransferWalkin');
            const bankOtherWalkin = document.getElementById('bankOtherWalkin');

            // Show/hide bank transfer fields based on payment method
            if (paymentMethodWalkin) {
                paymentMethodWalkin.addEventListener('change', function() {
                    if (this.value === 'Transfer' && bankTransferFieldsWalkin) {
                        bankTransferFieldsWalkin.classList.add('show');
                    } else if (bankTransferFieldsWalkin) {
                        bankTransferFieldsWalkin.classList.remove('show');
                    }
                });

                // Check initial state on page load
                if (paymentMethodWalkin.value === 'Transfer' && bankTransferFieldsWalkin) {
                    bankTransferFieldsWalkin.classList.add('show');
                }
            }

            // Show manual bank input when "OTHER" selected
            if (bankTransferWalkin) {
                bankTransferWalkin.addEventListener('change', function() {
                    if (!bankOtherWalkin) return;
                    if (this.value === 'OTHER') {
                        bankOtherWalkin.style.display = 'block';
                    } else {
                        bankOtherWalkin.style.display = 'none';
                        bankOtherWalkin.value = '';
                    }
                });
            }

            if (clientSelect) {
                clientSelect.addEventListener('change', function() {
                    const option = this.options[this.selectedIndex];
                    const clientName = option.textContent.trim();
                    const clientId = this.value;
                    const oldPlate = option.dataset.plateNo || '';
                    
                    clientNameHidden.value = clientName;
                    clientEmail.value = option.dataset.email || '';
                    clientPhone.value = option.dataset.phone || '';
                    clientAddress.value = option.dataset.address || '';
                    clientMakeModel.value = option.dataset.makeModel || '';
                    clientModelYear.value = option.dataset.modelYear || '';
                    clientColor.value = option.dataset.color || '';
                    
                    // Load vehicles for this client
                    if (clientId) {
                        fetch('/api/clients/' + clientId + '/vehicles')
                            .then(response => response.json())
                            .then(vehicles => {
                                const plateSelect = document.getElementById('plateNumberSelectWalkin');
                                const plateInput = document.getElementById('clientPlateNumber');
                                
                                plateSelect.innerHTML = '<option value="">Select vehicle...</option>';
                                
                                if (vehicles.length > 0) {
                                    vehicles.forEach(function(vehicle) {
                                        const option = document.createElement('option');
                                        option.value = vehicle.plate_number;
                                        
                                        let displayText = vehicle.plate_number + ' - ' + vehicle.make_model;
                                        
                                        // Add "Primary" label for the old plate number
                                        if (vehicle.plate_number === oldPlate) {
                                            displayText += ' (Primary)';
                                        }
                                        
                                        option.textContent = displayText;
                                        option.dataset.makeModel = vehicle.make_model;
                                        option.dataset.modelYear = vehicle.model_year;
                                        option.dataset.color = vehicle.color;
                                        plateSelect.appendChild(option);
                                    });
                                    
                                    // Auto-select first vehicle and trigger change
                                    plateSelect.value = vehicles[0].plate_number;
                                    plateSelect.dispatchEvent(new Event('change'));
                                    
                                    plateSelect.style.display = 'block';
                                    plateInput.style.display = 'none';
                                    plateInput.removeAttribute('name');
                                } else {
                                    plateSelect.style.display = 'none';
                                    plateInput.style.display = 'block';
                                    plateInput.setAttribute('name', 'plate_number');
                                    plateInput.value = option.dataset.plateNo || '';
                                }
                            })
                            .catch(error => {
                                console.error('Error loading vehicles:', error);
                                document.getElementById('plateNumberSelectWalkin').style.display = 'none';
                                document.getElementById('clientPlateNumber').style.display = 'block';
                                document.getElementById('clientPlateNumber').setAttribute('name', 'plate_number');
                            });
                    }
                });

                // Handle vehicle selection change
                const plateSelect = document.getElementById('plateNumberSelectWalkin');
                if (plateSelect) {
                    plateSelect.addEventListener('change', function() {
                        const option = this.options[this.selectedIndex];
                        clientMakeModel.value = option.dataset.makeModel || '';
                        clientModelYear.value = option.dataset.modelYear || '';
                        clientColor.value = option.dataset.color || '';
                    });
                }

                // Trigger change event on load if a client is already selected
                if (clientSelect.value) {
                    clientSelect.dispatchEvent(new Event('change'));
                }
            }

            // Service selection functionality
            const serviceDropdown = document.getElementById('serviceDropdown');
            const servicesContainer = document.getElementById('servicesContainer');
            const servicesSubtotalInput = document.getElementById('servicesSubtotalWalkin');

            // Function to calculate services subtotal
            function calculateServicesSubtotal() {
                const servicePrices = Array.from(servicesContainer.querySelectorAll('input[name="service_payment_dues[]"]'))
                    .map(input => parseFloat(input.value) || 0);
                const subtotal = servicePrices.reduce((sum, price) => sum + price, 0);
                
                if (servicesSubtotalInput) {
                    servicesSubtotalInput.value = subtotal.toFixed(2);
                    // Trigger amount due calculation
                    calculateAmountDue();
                }
            }

            if (serviceDropdown) {
                serviceDropdown.addEventListener('change', function() {
                    if (this.value) {
                        const serviceName = this.value;
                        const servicePrice = this.options[this.selectedIndex].dataset.price || '0.00';

                        // Check if service already exists
                        const existingService = Array.from(servicesContainer.querySelectorAll('input[name="services[]"]'))
                            .some(input => input.value === serviceName);

                        if (!existingService) {
                            const serviceDiv = document.createElement('div');
                            serviceDiv.className = 'mb-2 p-2 bg-light rounded d-flex justify-content-between align-items-center';
                            serviceDiv.innerHTML = `
                                <span>${serviceName} - ₱${parseFloat(servicePrice).toFixed(2)}</span>
                                <input type="hidden" name="services[]" value="${serviceName}">
                                <input type="hidden" name="service_payment_dues[]" value="${servicePrice}">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeService(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                            servicesContainer.appendChild(serviceDiv);
                            calculateServicesSubtotal();
                        }
                        this.value = '';
                    }
                });
            }

            // Function to remove service and update subtotal
            window.removeService = function(button) {
                button.parentElement.remove();
                calculateServicesSubtotal();
            };

            // Payment terms - calculate installment amounts
            const paymentTermsSelect = document.querySelector('select[name="payment_terms"]');
            const paidAmountInput = document.getElementById('paidAmountWalkin');
            const amountDueInput = document.querySelector('input[name="amount_due"]');
            const balanceAmountInput = document.getElementById('balanceAmountWalkin');

            // Get all premium/tax inputs
            const premiumInput = document.querySelector('input[name="premium"]');
            const vatInput = document.querySelector('input[name="vat"]');
            const docStampTaxInput = document.querySelector('input[name="documentary_stamp_tax"]');
            const localGovTaxInput = document.querySelector('input[name="local_gov_tax"]');

            // Update balance calculation
            function updateBalance() {
                if (!amountDueInput || !paidAmountInput || !balanceAmountInput) return;
                const amountDue = parseFloat(amountDueInput.value) || 0;
                const paidAmount = parseFloat(paidAmountInput.value) || 0;
                const balance = amountDue - paidAmount;
                balanceAmountInput.value = balance.toFixed(2);
            }

            // Function to calculate amount due
            function calculateAmountDue() {
                if (!premiumInput || !vatInput || !docStampTaxInput || !localGovTaxInput || !servicesSubtotalInput || !amountDueInput) return;
                
                const premium = parseFloat(premiumInput.value) || 0;
                const vat = parseFloat(vatInput.value) || 0;
                const docStampTax = parseFloat(docStampTaxInput.value) || 0;
                const localGovTax = parseFloat(localGovTaxInput.value) || 0;
                const servicesSubtotal = parseFloat(servicesSubtotalInput.value) || 0;

                const totalAmountDue = premium + vat + docStampTax + localGovTax + servicesSubtotal;
                amountDueInput.value = totalAmountDue.toFixed(2);
                console.log('Amount Due calculated:', totalAmountDue);

                // Update balance when amount due changes
                updateBalance();
            }

            // Add event listeners to all premium/tax inputs
            if (premiumInput) premiumInput.addEventListener('input', calculateAmountDue);
            if (vatInput) vatInput.addEventListener('input', calculateAmountDue);
            if (docStampTaxInput) docStampTaxInput.addEventListener('input', calculateAmountDue);
            if (localGovTaxInput) localGovTaxInput.addEventListener('input', calculateAmountDue);
            if (servicesSubtotalInput) servicesSubtotalInput.addEventListener('input', calculateAmountDue);

            if (paymentTermsSelect && paidAmountInput && amountDueInput) {
                paymentTermsSelect.addEventListener('change', function() {
                    const amountDue = parseFloat(amountDueInput.value) || 0;
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
                    paidAmountInput.value = calculatedPaidAmount.toFixed(2);

                    // Trigger balance calculation
                    updateBalance();
                });

                // Update balance when paid amount changes
                paidAmountInput.addEventListener('input', updateBalance);
            }
        });
    </script>
</body>
</html>
