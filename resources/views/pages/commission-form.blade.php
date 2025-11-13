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
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="policy_number" class="form-label">Policy Number <span class="text-danger">*</span></label>
                                        <input type="text" name="policy_number" id="policy_number" class="form-control @error('policy_number') is-invalid @enderror" value="{{ old('policy_number', $commission->policy_number ?? '') }}" required>
                                        @error('policy_number')
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
                                    <div class="col-md-4 mb-3">
                                        <label for="term" class="form-label">Term <span class="text-danger">*</span></label>
                                        <input type="text" name="term" id="term" class="form-control @error('term') is-invalid @enderror" placeholder="e.g., 12 Months" value="{{ old('term', $commission->term ?? '') }}" required>
                                        @error('term')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="gross_premium" class="form-label">Gross Premium <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="gross_premium" id="gross_premium" class="form-control @error('gross_premium') is-invalid @enderror" value="{{ old('gross_premium', $commission->gross_premium ?? '') }}" required>
                                        @error('gross_premium')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="net_premium" class="form-label">Net Premium <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" name="net_premium" id="net_premium" class="form-control @error('net_premium') is-invalid @enderror" value="{{ old('net_premium', $commission->net_premium ?? '') }}" required>
                                        @error('net_premium')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="days_30" class="form-label">30 Days</label>
                                        <input type="number" step="0.01" name="days_30" id="days_30" class="form-control @error('days_30') is-invalid @enderror" value="{{ old('days_30', $commission->days_30 ?? '0') }}">
                                        @error('days_30')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="days_60" class="form-label">60 Days</label>
                                        <input type="number" step="0.01" name="days_60" id="days_60" class="form-control @error('days_60') is-invalid @enderror" value="{{ old('days_60', $commission->days_60 ?? '0') }}">
                                        @error('days_60')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="days_90" class="form-label">90 Days</label>
                                        <input type="number" step="0.01" name="days_90" id="days_90" class="form-control @error('days_90') is-invalid @enderror" value="{{ old('days_90', $commission->days_90 ?? '0') }}">
                                        @error('days_90')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="last_pdc_date" class="form-label">Last PDC Date</label>
                                        <input type="date" name="last_pdc_date" id="last_pdc_date" class="form-control @error('last_pdc_date') is-invalid @enderror" value="{{ old('last_pdc_date', isset($commission) && $commission->last_pdc_date ? $commission->last_pdc_date->format('Y-m-d') : '') }}">
                                        @error('last_pdc_date')
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
            $('#policy_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Policy'
            });

            $('#insurance_provider_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Insurance Provider'
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
                    $('#net_premium').val(premium);

                    // Calculate term
                    if (startDate && endDate) {
                        const start = new Date(startDate);
                        const end = new Date(endDate);
                        const months = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth());
                        $('#term').val(months + ' Months');
                    }

                    // Trigger commission calculation
                    calculateCommission();
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
