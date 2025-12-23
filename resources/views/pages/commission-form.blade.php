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
        .nav-link.active {
            background-color: #f5f5f5 !important;
            border-bottom: 3px solid #007bff !important;
        }
        .commission-type-section {
            display: none;
        }
        .commission-type-section.active {
            display: block;
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

            <!-- Commission Type Navbar -->
            <div class="row mb-4">
                <div class="col-12">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" href="#" data-commission-type="policy" onclick="switchCommissionType('policy'); return false;">
                                <i class="fas fa-file-contract me-2"></i>Policy Commission
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#" data-commission-type="claim" onclick="switchCommissionType('claim'); return false;">
                                <i class="fas fa-exclamation-circle me-2"></i>Claim Commission
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="#" data-commission-type="walkin" onclick="switchCommissionType('walkin'); return false;">
                                <i class="fas fa-user-plus me-2"></i>Walk-in Commission
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <!-- POLICY COMMISSION FORM -->
                            <form action="{{ isset($commission) ? route('commission.update', $commission->id) : route('commission.store') }}" method="POST" class="commission-form" id="policy-form">
                                @csrf
                                @if(isset($commission))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="commission_type" value="policy">

                                <!-- POLICY COMMISSION SECTION -->
                                <div class="commission-type-section active" id="section-policy">
                                    <h5 class="mb-4"><i class="fas fa-file-contract me-2"></i>Policy Commission Details</h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="policy_id" class="form-label">Policy <span class="text-danger">*</span></label>
                                            <select name="policy_id" id="policy_id" class="form-select @error('policy_id') is-invalid @enderror">
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
                                                        data-make-model="{{ $policy->make_model }}"
                                                        data-plate-number="{{ $policy->plate_number }}"
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
                                            <label for="insurance_provider_id_policy" class="form-label">Insurance Provider</label>
                                            <select name="insurance_provider_id" id="insurance_provider_id_policy" class="form-select @error('insurance_provider_id') is-invalid @enderror">
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
                                            <label for="insured_policy" class="form-label">Insured <span class="text-danger">*</span></label>
                                            <input type="text" name="insured" id="insured_policy" class="form-control" value="{{ old('insured', $commission->insured ?? '') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="policy_number_policy" class="form-label">Policy Number <span class="text-danger">*</span></label>
                                            <input type="text" name="policy_number" id="policy_number_policy" class="form-control" value="{{ old('policy_number', $commission->policy_number ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="unit_policy" class="form-label">Unit</label>
                                            <input type="text" name="unit_policy" id="unit_policy" class="form-control" value="{{ old('unit', '') }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="plate_number_policy" class="form-label">Plate Number</label>
                                            <input type="text" name="plate_number_policy" id="plate_number_policy" class="form-control" value="{{ old('plate_number', '') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="gross_premium" class="form-label">Gross Premium <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="gross_premium" id="gross_premium" class="form-control @error('gross_premium') is-invalid @enderror" value="{{ old('gross_premium', $commission->gross_premium ?? '') }}">
                                            @error('gross_premium')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="net_premium" class="form-label">Net Premium <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="net_premium" id="net_premium" class="form-control @error('net_premium') is-invalid @enderror" value="{{ old('net_premium', $commission->net_premium ?? '') }}">
                                            @error('net_premium')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="commission_rate" class="form-label">Commission Rate (%) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="commission_rate" id="commission_rate" class="form-control" value="{{ old('commission_rate', $commission->commission_rate ?? '15.00') }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="commission_amount_policy" class="form-label">Commission Amount (Auto-calculated)</label>
                                            <input type="text" id="commission_amount_policy" class="form-control" readonly value="₱0.00">
                                        </div>

                                        <div class="col-md-4 mb-3"></div>
                                    </div>

                                    <!-- Policy Commission Summary -->
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <h6 class="mb-3 text-center text-uppercase fw-bold">Summary of Premium and Other Charges</h6>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="border rounded p-4">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label class="fw-bold">PREMIUM</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="premium_policy" id="premium_policy" class="form-control form-control-sm" placeholder="PHP" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Value Added Tax</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="vat_policy" id="vat_policy" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->policy_id ? $commission->vat : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Documentary Stamp Tax</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="doc_stamp_tax_policy" id="doc_stamp_tax_policy" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->policy_id ? $commission->documentary_stamp_tax : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Local Government tax</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="local_gov_tax_policy" id="local_gov_tax_policy" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->policy_id ? $commission->local_gov_tax : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Services Subtotal</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" id="services_subtotal_policy" class="form-control form-control-sm" value="0.00" readonly>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="fw-bold">AMOUNT DUE</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" id="amount_due_policy" class="form-control form-control-sm fw-bold" value="0.00" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="border rounded p-4">
                                                        <label class="fw-bold mb-3">Remarks</label>
                                                        <textarea name="remarks_policy" id="remarks_policy" class="form-control" rows="10" placeholder="Enter remarks">{{ old('remarks', $commission->remarks ?? '') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="alert alert-success">
                                                        <label class="mb-0"><strong>Commission Amount:</strong> <span id="summary_total_commission_policy" class="float-end">₱0.00</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Submit button for Policy Commission -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Save Policy Commission</button>
                                        <a href="{{ route('commission.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>

                            <!-- CLAIM COMMISSION FORM -->
                            <form action="{{ isset($commission) ? route('commission.update', $commission->id) : route('commission.store') }}" method="POST" class="commission-form" id="claim-form">
                                @csrf
                                @if(isset($commission))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="commission_type" value="claim">
                                <input type="hidden" id="claim_id" name="claim_id" value="">
                                <input type="hidden" id="claim_gross_premium" name="gross_premium" value="">
                                <input type="hidden" id="claim_net_premium" name="net_premium" value="">
                                <input type="hidden" id="claim_insurance_provider_id" name="insurance_provider_id" value="">
                                <input type="hidden" id="claim_policy_number" name="policy_number" value="">
                                <input type="hidden" id="claim_insured" name="insured" value="">
                                <input type="hidden" id="claim_commission_rate" name="commission_rate" value="">

                                <!-- CLAIM COMMISSION SECTION -->
                                <div class="commission-type-section" id="section-claim">
                                    <h5 class="mb-4"><i class="fas fa-exclamation-circle me-2"></i>Claim Commission Details</h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="insured_claim" class="form-label">Insured <span class="text-danger">*</span></label>
                                            <select name="insured_claim" id="insured_claim" class="form-select">
                                                <option value="">Select Insured</option>
                                                @forelse($claims as $claim)
                                                    <option value="{{ $claim->id }}" 
                                                        data-client="{{ $claim->client_name ?? $claim->policy?->client_name ?? 'N/A' }}"
                                                        data-loa="{{ $claim->loa_amount ?? 0 }}"
                                                        data-provider="{{ $claim->insurance_provider_id ?? '' }}"
                                                        data-policy-number="{{ $claim->policy_number ?? $claim->policy?->policy_number ?? '' }}"
                                                        data-claim-number="{{ $claim->claim_number ?? '' }}"
                                                        data-make-model="{{ $claim->policy?->make_model ?? '' }}"
                                                        data-plate-number="{{ $claim->policy?->plate_number ?? '' }}"
                                                        {{ (isset($commission) && $commission->claim_id == $claim->id) ? 'selected' : '' }}>
                                                        {{ $claim->client_name ?? $claim->policy?->client_name ?? 'Unnamed Claim' }}
                                                    </option>
                                                @empty
                                                    <option disabled>No claims available</option>
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="policy_number_claim" class="form-label">Policy Number <span class="text-danger">*</span></label>
                                            <input type="text" name="policy_number_claim" id="policy_number_claim" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="claim_number" class="form-label">Claim Number <span class="text-danger">*</span></label>
                                            <input type="text" name="claim_number" id="claim_number" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-3"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="unit_claim" class="form-label">Unit</label>
                                            <input type="text" name="unit_claim" id="unit_claim" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="plate_number_claim" class="form-label">Plate Number</label>
                                            <input type="text" name="plate_number_claim" id="plate_number_claim" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="loa_amount" class="form-label">LOA Amount <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="loa_amount" id="loa_amount" class="form-control" value="{{ isset($commission) && $commission->claim_id ? $commission->gross_premium : '' }}">
                                        </div>

                                        <div class="col-md-6 mb-3"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="commission_rate_claim" class="form-label">Commission Rate (%) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="commission_rate_claim" id="commission_rate_claim" class="form-control" value="{{ isset($commission) && $commission->claim_id ? $commission->commission_rate : '15.00' }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="commission_amount_claim" class="form-label">Commission Amount (Auto-calculated)</label>
                                            <input type="text" id="commission_amount_claim" class="form-control" readonly value="₱0.00">
                                        </div>

                                        <div class="col-md-4 mb-3"></div>
                                    </div>

                                    <!-- Claim Commission Summary -->
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <h6 class="mb-3 text-center text-uppercase fw-bold">Summary of Premium and Other Charges</h6>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="border rounded p-4">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label class="fw-bold">PREMIUM</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="premium_claim" id="premium_claim" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->claim_id ? $commission->gross_premium : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Value Added Tax</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="vat_claim" id="vat_claim" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->claim_id ? $commission->vat : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Documentary Stamp Tax</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="doc_stamp_tax_claim" id="doc_stamp_tax_claim" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->claim_id ? $commission->documentary_stamp_tax : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Local Government tax</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="local_gov_tax_claim" id="local_gov_tax_claim" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->claim_id ? $commission->local_gov_tax : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Services Subtotal</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" id="services_subtotal_claim" class="form-control form-control-sm" value="0.00" readonly>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="fw-bold">AMOUNT DUE</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" id="amount_due_claim" class="form-control form-control-sm fw-bold" value="0.00" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="border rounded p-4">
                                                        <label class="fw-bold mb-3">Remarks</label>
                                                        <textarea name="remarks_claim" id="remarks_claim" class="form-control" rows="10" placeholder="Enter remarks">{{ isset($commission) && $commission->claim_id ? $commission->remarks : '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="alert alert-success">
                                                        <label class="mb-0"><strong>Commission Amount:</strong> <span id="summary_total_commission_claim" class="float-end">₱0.00</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Submit button for Claim Commission -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Save Claim Commission</button>
                                        <a href="{{ route('commission.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>

                            <!-- WALK-IN COMMISSION FORM -->
                            <form action="{{ isset($commission) ? route('commission.update', $commission->id) : route('commission.store') }}" method="POST" class="commission-form" id="walkin-form">
                                @csrf
                                @if(isset($commission))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="commission_type" value="walkin">
                                <input type="hidden" id="walkin_id" name="walk_in_id" value="">
                                <input type="hidden" id="walkin_gross_premium" name="gross_premium" value="">
                                <input type="hidden" id="walkin_net_premium" name="net_premium" value="">
                                <input type="hidden" id="walkin_commission_rate" name="commission_rate" value="">

                                <!-- WALK-IN COMMISSION SECTION -->
                                <div class="commission-type-section" id="section-walkin">
                                    <h5 class="mb-4"><i class="fas fa-user-plus me-2"></i>Walk-in Commission Details</h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="walk_in_id" class="form-label">Walk-In <span class="text-danger">*</span></label>
                                            <select name="walk_in_id" id="walk_in_id" class="form-select">
                                                <option value="">Select Walk-In</option>
                                                @if(isset($walkIns))
                                                    @foreach($walkIns as $walkIn)
                                                        <option value="{{ $walkIn->id }}" 
                                                            data-client="{{ $walkIn->insured_name }}"
                                                            data-unit="{{ $walkIn->unit }}"
                                                            data-plate="{{ $walkIn->plate_number }}"
                                                            data-premium="{{ $walkIn->premium }}"
                                                            {{ (isset($commission) && $commission->walk_in_id == $walkIn->id) ? 'selected' : '' }}>
                                                            {{ $walkIn->insured_name }} - {{ $walkIn->plate_number }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="client_name_walkin" class="form-label">Client Name <span class="text-danger">*</span></label>
                                            <input type="text" name="client_name_walkin" id="client_name_walkin" class="form-control" value="{{ isset($commission) && $commission->walk_in_id ? $commission->walkIn->insured_name : '' }}">
                                        </div>

                                        <div class="col-md-6 mb-3"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="unit_walkin" class="form-label">Unit</label>
                                            <input type="text" name="unit_walkin" id="unit_walkin" class="form-control" value="{{ isset($commission) && $commission->walk_in_id ? $commission->walkIn->unit : '' }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="plate_number_walkin" class="form-label">Plate Number</label>
                                            <input type="text" name="plate_number_walkin" id="plate_number_walkin" class="form-control" value="{{ isset($commission) && $commission->walk_in_id ? $commission->walkIn->plate_number : '' }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="services" class="form-label">Services <span class="text-danger">*</span></label>
                                            <select name="services" id="services" class="form-select">
                                                <option value="">Select Service</option>
                                                @if(isset($services))
                                                    @foreach($services as $service)
                                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->name }} - ₱{{ number_format($service->price, 2) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="amount_walkin" class="form-label">Amount <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="amount_walkin" id="amount_walkin" class="form-control" value="{{ isset($commission) && $commission->walk_in_id ? $commission->gross_premium : '' }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="commission_rate_walkin" class="form-label">Commission Rate (%) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="commission_rate_walkin" id="commission_rate_walkin" class="form-control" value="{{ isset($commission) && $commission->walk_in_id ? $commission->commission_rate : '15.00' }}">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="commission_amount_walkin" class="form-label">Commission Amount (Auto-calculated)</label>
                                            <input type="text" id="commission_amount_walkin" class="form-control" readonly value="₱0.00">
                                        </div>

                                        <div class="col-md-4 mb-3"></div>
                                    </div>

                                    <!-- Walk-in Commission Summary -->
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <h6 class="mb-3 text-center text-uppercase fw-bold">Summary of Premium and Other Charges</h6>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="border rounded p-4">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label class="fw-bold">PREMIUM</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="premium_walkin" id="premium_walkin" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->walk_in_id ? $commission->gross_premium : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Value Added Tax</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="vat_walkin" id="vat_walkin" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->walk_in_id ? $commission->vat : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Documentary Stamp Tax</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="doc_stamp_tax_walkin" id="doc_stamp_tax_walkin" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->walk_in_id ? $commission->documentary_stamp_tax : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Local Government tax</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" step="0.01" name="local_gov_tax_walkin" id="local_gov_tax_walkin" class="form-control form-control-sm" placeholder="PHP" value="{{ isset($commission) && $commission->walk_in_id ? $commission->local_gov_tax : '0' }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label>Services Subtotal</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" id="services_subtotal_walkin" class="form-control form-control-sm" value="0.00" readonly>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="fw-bold">AMOUNT DUE</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" id="amount_due_walkin" class="form-control form-control-sm fw-bold" value="0.00" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="border rounded p-4">
                                                        <label class="fw-bold mb-3">Remarks</label>
                                                        <textarea name="remarks_walkin" id="remarks_walkin" class="form-control" rows="10" placeholder="Enter remarks">{{ isset($commission) && $commission->walk_in_id ? $commission->remarks : '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="alert alert-success">
                                                        <label class="mb-0"><strong>Commission Amount:</strong> <span id="summary_total_commission_walkin" class="float-end">₱0.00</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Common Fields -->
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                                        <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror">
                                            <option value="pending" {{ old('payment_status', $commission->payment_status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="partial" {{ old('payment_status', $commission->payment_status ?? '') == 'partial' ? 'selected' : '' }}>Partial</option>
                                            <option value="paid" {{ old('payment_status', $commission->payment_status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        </select>
                                        @error('payment_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3"></div>

                                    <div class="col-md-4 mb-3"></div>
                                </div>

                                <!-- Submit button for Walk-in Commission -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Save Walk-in Commission</button>
                                        <a href="{{ route('commission.index') }}" class="btn btn-secondary">Cancel</a>
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
        // Switch between commission types
        function switchCommissionType(type) {
            // Hide all forms
            $('.commission-form').hide();
            
            // Show selected form
            $('#' + type + '-form').show();
            
            // Hide all sections
            $('.commission-type-section').removeClass('active').hide();
            
            // Show selected section
            $('#section-' + type).addClass('active').show();
            
            // Update navbar
            $('.nav-link').removeClass('active');
            $('.nav-link[data-commission-type="' + type + '"]').addClass('active');
            
            // Scroll to form
            document.querySelector('.card').scrollIntoView({ behavior: 'smooth' });
        }

        $(document).ready(function() {
            // Initialize Select2 for all dropdowns (excluding insured_claim to debug)
            $('#walk_in_id, #policy_id, #insurance_provider_id_policy, #insurance_provider_id_claim, #services').select2({
                theme: 'bootstrap-5',
                allowClear: true
            });
            
            // Initialize Select2 for insured_claim separately 
            $('#insured_claim').select2({
                theme: 'bootstrap-5',
                allowClear: true
            });

            // POLICY COMMISSION - Auto-fill fields when policy is selected
            $('#policy_id').on('change', function() {
                const selectedOption = $(this).find(':selected');
                
                if (selectedOption.val()) {
                    const providerId = selectedOption.data('provider');
                    const policyNumber = selectedOption.data('policy-number');
                    const client = selectedOption.data('client');
                    const premium = selectedOption.data('premium');
                    const makeModel = selectedOption.data('make-model');
                    const plateNumber = selectedOption.data('plate-number');

                    console.log('Policy selected:', {
                        makeModel: makeModel,
                        plateNumber: plateNumber
                    });

                    $('#insurance_provider_id_policy').val(providerId).trigger('change.select2');
                    $('#insured_policy').val(client);
                    $('#policy_number_policy').val(policyNumber);
                    $('#unit_policy').val(makeModel);
                    $('#plate_number_policy').val(plateNumber);
                    $('#gross_premium').val(premium);
                    $('#premium_policy').val(premium);
                    
                    // Force trigger input event to ensure reactivity
                    $('#unit_policy').trigger('change');
                    $('#plate_number_policy').trigger('change');
                    
                    calculateCommissionPolicy();
                } else {
                    $('#insurance_provider_id_policy').val('').trigger('change.select2');
                    $('#insured_policy').val('');
                    $('#policy_number_policy').val('');
                    $('#unit_policy').val('');
                    $('#plate_number_policy').val('');
                    $('#gross_premium').val('');
                    $('#premium_policy').val('');
                    $('#net_premium').val('');
                    $('#commission_amount_policy').val('₱0.00');
                }
            });

            // CLAIM COMMISSION - Auto-fill fields when insured is selected
            $('#insured_claim').on('change', function() {
                const selectedOption = $(this).find(':selected');
                
                if (selectedOption.val()) {
                    const clientName = selectedOption.data('client');
                    const loaAmount = selectedOption.data('loa');
                    const providerId = selectedOption.data('provider');
                    const policyNumber = selectedOption.data('policy-number');
                    const claimNumber = selectedOption.data('claim-number');
                    const makeModel = selectedOption.data('make-model');
                    const plateNumber = selectedOption.data('plate-number');

                    $('#insurance_provider_id_claim').val(providerId).trigger('change.select2');
                    $('#policy_number_claim').val(policyNumber);
                    $('#claim_number').val(claimNumber);
                    $('#unit_claim').val(makeModel);
                    $('#plate_number_claim').val(plateNumber);
                    $('#loa_amount').val(loaAmount);
                    $('#premium_claim').val(loaAmount);
                    calculateCommissionClaim();
                } else {
                    $('#insurance_provider_id_claim').val('').trigger('change.select2');
                    $('#policy_number_claim').val('');
                    $('#claim_number').val('');
                    $('#unit_claim').val('');
                    $('#plate_number_claim').val('');
                    $('#loa_amount').val('');
                    $('#premium_claim').val('');
                    $('#commission_amount_claim').val('₱0.00');
                }
            });

            // WALK-IN COMMISSION - Auto-fill fields when walk-in is selected
            $('#walk_in_id').on('change', function() {
                const selectedOption = $(this).find(':selected');
                
                if (selectedOption.val()) {
                    const clientName = selectedOption.data('client');
                    const unit = selectedOption.data('unit');
                    const plateNumber = selectedOption.data('plate');
                    const premium = selectedOption.data('premium');

                    $('#client_name_walkin').val(clientName);
                    $('#unit_walkin').val(unit);
                    $('#plate_number_walkin').val(plateNumber);
                    $('#amount_walkin').val(premium);
                    $('#premium_walkin').val(premium);
                    
                    // Auto-fill Services with the first available service
                    const firstServiceOption = $('#services option:not([value=""])').first();
                    if (firstServiceOption.length) {
                        $('#services').val(firstServiceOption.val()).trigger('change.select2');
                    }
                    
                    calculateCommissionWalkin();
                } else {
                    $('#client_name_walkin').val('');
                    $('#unit_walkin').val('');
                    $('#plate_number_walkin').val('');
                    $('#amount_walkin').val('');
                    $('#premium_walkin').val('');
                    $('#services').val('').trigger('change.select2');
                    $('#commission_amount_walkin').val('₱0.00');
                }
            });

            // Auto-fill premium_walkin when amount_walkin changes
            $('#amount_walkin').on('input', function() {
                $('#premium_walkin').val($(this).val());
                calculateCommissionWalkin();
            });

            // POLICY Commission calculation
            function calculateCommissionPolicy() {
                const premium = parseFloat($('#premium_policy').val()) || 0;
                const commissionRate = parseFloat($('#commission_rate').val()) || 0;
                const vat = parseFloat($('#vat_policy').val()) || 0;
                const docStampTax = parseFloat($('#doc_stamp_tax_policy').val()) || 0;
                const localGovTax = parseFloat($('#local_gov_tax_policy').val()) || 0;
                
                // Calculate commission amount from gross premium
                const commissionAmount = (premium * commissionRate) / 100;
                
                // Net Premium = Gross Premium - Commission Amount
                const netPremium = premium - commissionAmount;
                
                const subtotal = premium + vat + docStampTax + localGovTax;
                
                // Set values with proper formatting
                $('#commission_amount_policy').val('₱' + commissionAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#net_premium').val(netPremium.toFixed(2));
                $('#gross_premium').val(premium.toFixed(2));
                $('#services_subtotal_policy').val(subtotal.toFixed(2));
                $('#amount_due_policy').val(subtotal.toFixed(2));
                $('#summary_total_commission_policy').text('₱' + commissionAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }

            // CLAIM Commission calculation
            function calculateCommissionClaim() {
                const premium = parseFloat($('#premium_claim').val()) || 0;
                const commissionRate = parseFloat($('#commission_rate_claim').val()) || 0;
                const vat = parseFloat($('#vat_claim').val()) || 0;
                const docStampTax = parseFloat($('#doc_stamp_tax_claim').val()) || 0;
                const localGovTax = parseFloat($('#local_gov_tax_claim').val()) || 0;
                
                const subtotal = premium + vat + docStampTax + localGovTax;
                const commissionAmount = (premium * commissionRate) / 100;
                
                $('#commission_amount_claim').val('₱' + commissionAmount.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#services_subtotal_claim').val(subtotal.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#amount_due_claim').val(subtotal.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#summary_total_commission_claim').text('₱' + commissionAmount.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            }

            // WALK-IN Commission calculation
            function calculateCommissionWalkin() {
                const premium = parseFloat($('#premium_walkin').val()) || 0;
                const commissionRate = parseFloat($('#commission_rate_walkin').val()) || 0;
                const vat = parseFloat($('#vat_walkin').val()) || 0;
                const docStampTax = parseFloat($('#doc_stamp_tax_walkin').val()) || 0;
                const localGovTax = parseFloat($('#local_gov_tax_walkin').val()) || 0;
                
                const subtotal = premium + vat + docStampTax + localGovTax;
                const commissionAmount = (premium * commissionRate) / 100;
                
                $('#commission_amount_walkin').val('₱' + commissionAmount.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#services_subtotal_walkin').val(subtotal.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#amount_due_walkin').val(subtotal.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#summary_total_commission_walkin').text('₱' + commissionAmount.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            }

            // Recalculate when rates or amounts change
            $('#net_premium, #commission_rate, #gross_premium, #premium_policy, #vat_policy, #doc_stamp_tax_policy, #local_gov_tax_policy').on('input', calculateCommissionPolicy);
            $('#loa_amount, #commission_rate_claim, #premium_claim, #vat_claim, #doc_stamp_tax_claim, #local_gov_tax_claim').on('input', calculateCommissionClaim);
            $('#amount_walkin, #commission_rate_walkin, #premium_walkin, #vat_walkin, #doc_stamp_tax_walkin, #local_gov_tax_walkin').on('input', calculateCommissionWalkin);

            // Policy form submission - fields are now using correct names

            // Handle Claim form submission - map premium_claim to gross_premium
            $('#claim-form').on('submit', function(e) {
                const premiumValue = parseFloat($('#premium_claim').val()) || 0;
                const commissionRate = parseFloat($('#commission_rate_claim').val()) || 0;
                const claimId = $('#insured_claim').val();
                
                // Get the selected claim's data
                const selectedOption = $('#insured_claim').find(':selected');
                const providerIdFromClaim = selectedOption.data('provider');
                const policyNumberFromClaim = selectedOption.data('policy-number');
                const clientNameFromClaim = selectedOption.data('client');
                
                $('#claim_id').val(claimId);
                $('#claim_gross_premium').val(premiumValue);
                $('#claim_net_premium').val(premiumValue - (premiumValue * commissionRate / 100));
                $('#claim_insurance_provider_id').val(providerIdFromClaim || '');
                $('#claim_policy_number').val(policyNumberFromClaim || '');
                $('#claim_insured').val(clientNameFromClaim || '');
                $('#claim_commission_rate').val(commissionRate);
            });

            // Handle Walk-in form submission - map premium_walkin to gross_premium
            $('#walkin-form').on('submit', function(e) {
                const premiumValue = parseFloat($('#premium_walkin').val()) || 0;
                const commissionRate = parseFloat($('#commission_rate_walkin').val()) || 0;
                const walkInId = document.getElementById('walk_in_id').value;
                
                $('#walkin_id').val(walkInId);
                $('#walkin_gross_premium').val(premiumValue);
                $('#walkin_net_premium').val(premiumValue - (premiumValue * commissionRate / 100));
                $('#walkin_commission_rate').val(commissionRate);
            });

            // Initialize the correct form when editing
            @if(isset($commission))
                @if($commission->walk_in_id)
                    switchCommissionType('walkin');
                    // Trigger calculation for walk-in commission after page loads
                    setTimeout(function() {
                        $('#amount_walkin').trigger('input');
                        calculateCommissionWalkin();
                    }, 200);
                @elseif($commission->claim_id)
                    switchCommissionType('claim');
                    // Trigger calculation for claim commission
                    setTimeout(function() {
                        $('#insured_claim').trigger('change');
                        calculateCommissionClaim();
                    }, 200);
                @else
                    switchCommissionType('policy');
                    // Trigger calculation for policy commission
                    setTimeout(function() {
                        $('#policy_id').trigger('change');
                        calculateCommissionPolicy();
                    }, 200);
                @endif
            @endif
        });
    </script>
</body>
</html>
