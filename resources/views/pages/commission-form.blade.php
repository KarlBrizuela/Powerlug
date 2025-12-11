<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($commission) ? 'Edit' : 'Add' }} Commission - Powerlug</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
    <style>
        .page-content {
            padding: 20px 0;
            margin-left: 250px;
        }
        .card {
            border: none;
            box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
        }
        @media (max-width: 768px) {
            .page-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    @include('components.sidebar')
    
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ isset($commission) ? 'Edit' : 'Add' }} Commission</h4>
                        <a href="{{ route('commission.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ isset($commission) ? route('commission.update', $commission->id) : route('commission.store') }}" method="POST">
                                @csrf
                                @if(isset($commission))
                                    @method('PUT')
                                @endif

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="claim_id" class="form-label">Claim</label>
                                        <select name="claim_id" id="claim_id" class="form-select">
                                            <option value="">Select Claim (Optional)</option>
                                            @foreach($claims as $claim)
                                                <option value="{{ $claim->id }}" 
                                                    data-client="{{ $claim->client_name }}"
                                                    data-loa="{{ $claim->loa_amount }}"
                                                    data-provider="{{ $claim->insurance_provider_id }}"
                                                    data-policy-number="{{ $claim->policy_number }}">
                                                    {{ $claim->client_name }} - LOA: ₱{{ number_format($claim->loa_amount, 2) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="policy_id" class="form-label">Policy <span class="text-danger">*</span></label>
                                        <select name="policy_id" id="policy_id" class="form-select @error('policy_id') is-invalid @enderror" required>
                                            <option value="">Select Policy</option>
                                            @foreach($policies as $policy)
                                                <option value="{{ $policy->id }}" 
                                                    data-provider="{{ $policy->insurance_provider_id }}"
                                                    data-provider-name="{{ $policy->insuranceProvider->name ?? '' }}"
                                                    data-policy-number="{{ $policy->policy_number }}"
                                                    data-client="{{ $policy->client_name }}"
                                                    data-premium="{{ $policy->premium }}"
                                                    data-start="{{ $policy->start_date }}"
                                                    data-end="{{ $policy->end_date }}"
                                                    {{ (isset($commission) && $commission->policy_id == $policy->id) || old('policy_id') == $policy->id ? 'selected' : '' }}>
                                                    {{ $policy->policy_number }} - {{ $policy->client_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('policy_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="insurance_provider_id" class="form-label">Insurance Provider <span class="text-danger">*</span></label>
                                        <select name="insurance_provider_id" id="insurance_provider_id" class="form-select @error('insurance_provider_id') is-invalid @enderror" required>
                                            <option value="">Select Insurance Provider</option>
                                            @foreach($insuranceProviders as $provider)
                                                <option value="{{ $provider->id }}" {{ (isset($commission) && $commission->insurance_provider_id == $provider->id) || old('insurance_provider_id') == $provider->id ? 'selected' : '' }}>
                                                    {{ $provider->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('insurance_provider_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="insured" class="form-label">Insured <span class="text-danger">*</span></label>
                                        <input type="text" name="insured" id="insured" class="form-control @error('insured') is-invalid @enderror" value="{{ old('insured', $commission->insured ?? '') }}" required>
                                        @error('insured')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="agent" class="form-label">Agent</label>
                                        <input type="text" name="agent" id="agent" class="form-control @error('agent') is-invalid @enderror" value="{{ old('agent', $commission->agent ?? '') }}" placeholder="Enter agent name">
                                        @error('agent')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="policy_number" class="form-label">Policy Number <span class="text-danger">*</span></label>
                                        <input type="text" name="policy_number" id="policy_number" class="form-control @error('policy_number') is-invalid @enderror" value="{{ old('policy_number', $commission->policy_number ?? '') }}" required>
                                        @error('policy_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="loa" class="form-label">LOA (Authorization)</label>
                                        <input type="text" name="loa" id="loa" class="form-control @error('loa') is-invalid @enderror" value="{{ old('loa', $commission->loa ?? '') }}" placeholder="LOA reference or notes">
                                        @error('loa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="gross_premium" class="form-label">Gross Premium <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="gross_premium" id="gross_premium" class="form-control @error('gross_premium') is-invalid @enderror" value="{{ old('gross_premium', $commission->gross_premium ?? '') }}" required>
                                        @error('gross_premium')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="net_premium" class="form-label">Net Premium <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="net_premium" id="net_premium" class="form-control @error('net_premium') is-invalid @enderror" value="{{ old('net_premium', $commission->net_premium ?? '') }}" required>
                                        @error('net_premium')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="commission_rate" class="form-label">Commission Rate (%) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="commission_rate" id="commission_rate" class="form-control @error('commission_rate') is-invalid @enderror" value="{{ old('commission_rate', $commission->commission_rate ?? '15.00') }}" required>
                                        @error('commission_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="commission_amount" class="form-label">Commission Amount (Auto-calculated)</label>
                                        <input type="text" id="commission_amount_display" class="form-control" readonly value="₱0.00">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                                        <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                            <option value="pending" {{ old('payment_status', $commission->payment_status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="partial" {{ old('payment_status', $commission->payment_status ?? '') == 'partial' ? 'selected' : '' }}>Partial</option>
                                            <option value="paid" {{ old('payment_status', $commission->payment_status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        </select>
                                        @error('payment_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3">{{ old('remarks', $commission->remarks ?? '') }}</textarea>
                                        @error('remarks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> {{ isset($commission) ? 'Update' : 'Save' }} Commission
                                        </button>
                                        <a href="{{ route('commission.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-1"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#claim_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Claim (Optional)',
                allowClear: true
            });

            $('#policy_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Policy',
                allowClear: true
            });

            $('#insurance_provider_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Insurance Provider'
            });

            // Auto-fill fields when claim is selected
            $('#claim_id').on('change', function() {
                const selectedOption = $(this).find(':selected');
                
                if (selectedOption.val()) {
                    const clientName = selectedOption.data('client');
                    const loaAmount = selectedOption.data('loa');
                    const providerId = selectedOption.data('provider');
                    const policyNumber = selectedOption.data('policy-number');

                    // Fill in the fields
                    $('#insured').val(clientName);
                    $('#loa').val('₱' + parseFloat(loaAmount).toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    $('#insurance_provider_id').val(providerId).trigger('change');
                    $('#policy_number').val(policyNumber);
                    
                    // Disable policy dropdown
                    $('#policy_id').prop('disabled', true).trigger('change.select2');
                } else {
                    // Clear fields when claim is unselected
                    $('#insured').val('');
                    $('#loa').val('');
                    $('#insurance_provider_id').val('').trigger('change');
                    $('#policy_number').val('');
                    
                    // Enable policy dropdown if no claim is selected
                    $('#policy_id').prop('disabled', false).trigger('change.select2');
                }
            });

            // Auto-fill fields when policy is selected
            $('#policy_id').on('change', function() {
                const selectedOption = $(this).find(':selected');
                
                if (selectedOption.val()) {
                    const providerId = selectedOption.data('provider');
                    const policyNumber = selectedOption.data('policy-number');
                    const client = selectedOption.data('client');
                    const premium = selectedOption.data('premium');
                    const startDate = selectedOption.data('start');
                    const endDate = selectedOption.data('end');

                    // Fill in the fields
                    $('#insurance_provider_id').val(providerId).trigger('change');
                    $('#policy_number').val(policyNumber);
                    $('#insured').val(client);
                    $('#gross_premium').val(premium);
                    // Do not auto-fill net premium, leave it empty for manual entry

                    // Trigger commission calculation
                    calculateCommission();
                    
                    // Disable claim dropdown
                    $('#claim_id').prop('disabled', true).trigger('change.select2');
                } else {
                    // Clear fields when policy is unselected
                    $('#insurance_provider_id').val('').trigger('change');
                    $('#policy_number').val('');
                    $('#insured').val('');
                    $('#gross_premium').val('');
                    $('#commission_amount_display').val('₱0.00');
                    
                    // Enable claim dropdown if no policy is selected
                    $('#claim_id').prop('disabled', false).trigger('change.select2');
                }
            });

            // Calculate commission amount
            function calculateCommission() {
                const netPremium = parseFloat($('#net_premium').val()) || 0;
                const commissionRate = parseFloat($('#commission_rate').val()) || 0;
                const commissionAmount = (netPremium * commissionRate) / 100;
                
                $('#commission_amount_display').val('₱' + commissionAmount.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            }

            // Recalculate when net premium or commission rate changes
            $('#net_premium, #commission_rate').on('input', calculateCommission);

            // Initial calculation if editing
            @if(isset($commission))
                calculateCommission();
            @endif
        });
    </script>
</body>
</html>
