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
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Validation Error!</strong> Please check the following:
                                    <ul class="mb-0 mt-2">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

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
                                        <label class="form-label fw-semibold">Insurance Provider <span class="text-danger">*</span></label>
                                        <select name="insurance_provider_id" id="insurance_provider_id" class="form-select @error('insurance_provider_id') is-invalid @enderror" required>
                                            <option value="">Select Insurance Provider</option>
                                            @if(isset($insuranceProviders) && $insuranceProviders->count())
                                                @foreach($insuranceProviders as $provider)
                                                    <option value="{{ $provider->id }}" {{ old('insurance_provider_id') == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('insurance_provider_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Policy <span class="text-danger">*</span></label>
                                        <select name="policy_id" id="policy_id" class="form-select @error('policy_id') is-invalid @enderror" required>
                                            <option value="">Select Policy</option>
                                            @if(isset($policies) && $policies->count())
                                                @foreach($policies as $policy)
                                                    <option value="{{ $policy->id }}" 
                                                        data-provider="{{ $policy->insurance_provider_id }}"
                                                        data-policy-number="{{ $policy->policy_number }}"
                                                        data-client="{{ $policy->client_name }}"
                                                        data-contact-number="{{ $policy->contact_number ?? '' }}"
                                                        data-plate-number="{{ $policy->plate_number ?? '' }}"
                                                        data-make-model="{{ $policy->make_model ?? '' }}"
                                                        data-color="{{ $policy->color ?? '' }}"
                                                        data-address="{{ $policy->address ?? '' }}"
                                                        data-model-year="{{ $policy->model_year ?? '' }}"
                                                        {{ old('policy_id') == $policy->id ? 'selected' : '' }}>
                                                        {{ $policy->policy_number }} - {{ $policy->client_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('policy_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Policy Number <span class="text-danger">*</span></label>
                                        <input type="text" name="policy_number" id="policy_number" class="form-control @error('policy_number') is-invalid @enderror" placeholder="Auto-filled from policy" required>
                                        @error('policy_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Claim Number</label>
                                        <input type="text" class="form-control" value="Auto-generated on submit" readonly>
                                        <small class="text-muted">Claim number will be generated automatically</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Client</label>
                                        <input type="text" name="client" id="client" value="{{ old('client') }}" class="form-control @error('client') is-invalid @enderror" placeholder="Auto-filled from policy">
                                        @error('client')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Cellphone</label>
                                        <input type="text" name="client_cellphone" id="client_cellphone" value="{{ old('client_cellphone') }}" class="form-control @error('client_cellphone') is-invalid @enderror" placeholder="Client cellphone number">
                                        @error('client_cellphone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Plate Number</label>
                                        <input type="text" name="plate_no" id="plate_no" value="{{ old('plate_no') }}" class="form-control @error('plate_no') is-invalid @enderror" placeholder="Vehicle plate number">
                                        @error('plate_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Model</label>
                                        <input type="text" name="vehicle_model" id="vehicle_model" value="{{ old('vehicle_model') }}" class="form-control @error('vehicle_model') is-invalid @enderror" placeholder="Vehicle model">
                                        @error('vehicle_model')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Color</label>
                                        <input type="text" name="vehicle_color" id="vehicle_color" value="{{ old('vehicle_color') }}" class="form-control @error('vehicle_color') is-invalid @enderror" placeholder="Vehicle color">
                                        @error('vehicle_color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Model Year</label>
                                        <input type="number" name="model_year" id="model_year" value="{{ old('model_year') }}" class="form-control @error('model_year') is-invalid @enderror" placeholder="e.g. 2020" min="1900" max="2100">
                                        @error('model_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Address</label>
                                        <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" placeholder="Client address">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
        // Auto-fill policy number and client when policy is selected (also fills new client/vehicle fields)
        document.getElementById('policy_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const providerId = selectedOption.getAttribute('data-provider');
            const policyNumber = selectedOption.getAttribute('data-policy-number');
            const clientName = selectedOption.getAttribute('data-client');
            // Prefer Policy model column names; keep older attribute names as fallback
            const clientPhone = selectedOption.getAttribute('data-contact-number') || selectedOption.getAttribute('data-client-phone');
            const plate = selectedOption.getAttribute('data-plate-number') || selectedOption.getAttribute('data-plate');
            const vehicleModel = selectedOption.getAttribute('data-make-model') || selectedOption.getAttribute('data-vehicle-model');
            const vehicleColor = selectedOption.getAttribute('data-color') || selectedOption.getAttribute('data-vehicle-color');
            const address = selectedOption.getAttribute('data-address') || selectedOption.getAttribute('data-client-address');
            const modelYear = selectedOption.getAttribute('data-model-year');

            if (this.value) {
                // Fill in the fields
                document.getElementById('insurance_provider_id').value = providerId || '';
                document.getElementById('policy_number').value = policyNumber || '';
                document.getElementById('client').value = clientName || '';
                if (document.getElementById('client_cellphone')) document.getElementById('client_cellphone').value = clientPhone || '';
                if (document.getElementById('plate_no')) document.getElementById('plate_no').value = plate || '';
                if (document.getElementById('vehicle_model')) document.getElementById('vehicle_model').value = vehicleModel || '';
                if (document.getElementById('vehicle_color')) document.getElementById('vehicle_color').value = vehicleColor || '';
                if (document.getElementById('address')) document.getElementById('address').value = address || '';
                if (document.getElementById('model_year')) document.getElementById('model_year').value = modelYear || '';
            } else {
                // Clear fields if no policy selected
                document.getElementById('policy_number').value = '';
                document.getElementById('client').value = '';
                if (document.getElementById('client_cellphone')) document.getElementById('client_cellphone').value = '';
                if (document.getElementById('plate_no')) document.getElementById('plate_no').value = '';
                if (document.getElementById('vehicle_model')) document.getElementById('vehicle_model').value = '';
                if (document.getElementById('vehicle_color')) document.getElementById('vehicle_color').value = '';
                if (document.getElementById('address')) document.getElementById('address').value = '';
                if (document.getElementById('model_year')) document.getElementById('model_year').value = '';
            }
        });

        // Filter policies by selected insurance provider
        document.getElementById('insurance_provider_id').addEventListener('change', function() {
            const providerId = this.value;
            const policySelect = document.getElementById('policy_id');
            const options = policySelect.querySelectorAll('option');
            
            options.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                    return;
                }
                
                const optionProviderId = option.getAttribute('data-provider');
                if (!providerId || optionProviderId === providerId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
            
            // Reset policy selection
            policySelect.value = '';
            document.getElementById('policy_number').value = '';
            document.getElementById('client').value = '';
            // Also clear newly added client/vehicle fields
            if (document.getElementById('client_cellphone')) document.getElementById('client_cellphone').value = '';
            if (document.getElementById('plate_no')) document.getElementById('plate_no').value = '';
            if (document.getElementById('vehicle_model')) document.getElementById('vehicle_model').value = '';
            if (document.getElementById('vehicle_color')) document.getElementById('vehicle_color').value = '';
            if (document.getElementById('address')) document.getElementById('address').value = '';
            if (document.getElementById('model_year')) document.getElementById('model_year').value = '';
        });

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

        // Initialize totals on page load and trigger policy autofill if a policy is preselected
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotals();
            var policySelect = document.getElementById('policy_id');
            if (policySelect && policySelect.value) {
                // dispatch a change event so the autofill runs for phone/model/color if policy preselected
                policySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>
</html>