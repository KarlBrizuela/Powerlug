<!-- Read-only view partial that mirrors the edit/create form fields -->
@php
    // $policy is provided by the parent view
    $display = function($value, $fallback = 'N/A') {
        if (is_null($value) || $value === '') return $fallback;
        return $value;
    };
@endphp

<style>
    .policy-view-section {
        background: #fff;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }
    
    .policy-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #007bff;
        display: inline-block;
    }
    
    .policy-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .policy-info-row:last-child {
        border-bottom: none;
    }
    
    .policy-info-label {
        font-weight: 600;
        color: #495057;
        margin: 0;
        font-size: 0.9rem;
    }
    
    .policy-info-value {
        color: #6c757d;
        margin: 0;
        text-align: right;
        font-size: 0.9rem;
    }
    
    .policy-summary-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.25rem;
        border: 1px solid #e9ecef;
    }
    
    .policy-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
    }
    
    .policy-summary-label {
        color: #495057;
        margin: 0;
        font-size: 0.9rem;
    }
    
    .policy-summary-value {
        color: #2c3e50;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .policy-summary-total {
        font-weight: 600;
        font-size: 1rem;
        color: #2c3e50;
    }
    
    .policy-remarks-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
        color: #495057;
        font-size: 0.9rem;
    }
    
    hr.policy-divider {
        margin: 1rem 0;
        border-top: 2px solid #dee2e6;
    }
</style>

<!-- Primary Information -->
<div class="policy-view-section">
    <div class="policy-section-title">Primary Information</div>
    <div class="mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Client Name:</p>
                    <p class="policy-info-value">{{ $display($policy->client_name ?? ($policy->client ? ($policy->client->firstName ?? $policy->client->first_name).' '.($policy->client->lastName ?? $policy->client->last_name) : null)) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Address:</p>
                    <p class="policy-info-value">{{ $display($policy->address) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Email:</p>
                    <p class="policy-info-value">{{ $display($policy->email) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Contact Number:</p>
                    <p class="policy-info-value">{{ $display($policy->contact_number) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Make / Model:</p>
                    <p class="policy-info-value">{{ $display($policy->make_model) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Plate No.:</p>
                    <p class="policy-info-value">{{ $display($policy->plate_number) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Model Year:</p>
                    <p class="policy-info-value">{{ $display($policy->model_year) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Color:</p>
                    <p class="policy-info-value">{{ $display($policy->color) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Insurance & Policy Details -->
<div class="policy-view-section">
    <div class="policy-section-title">Insurance & Policy Details</div>
    <div class="mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Insurance Provider:</p>
                    <p class="policy-info-value">{{ $display(optional($policy->insuranceProvider)->name ?? $policy->insurance_provider) }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="policy-info-row">
                    <p class="policy-info-label">Issue Date:</p>
                    <p class="policy-info-value">{{ optional($policy->issue_date)->format('F d, Y') ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="policy-info-row">
                    <p class="policy-info-label">Coverage From:</p>
                    <p class="policy-info-value">{{ optional($policy->coverage_from)->format('F d, Y') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="policy-info-row">
                    <p class="policy-info-label">Coverage To:</p>
                    <p class="policy-info-value">{{ optional($policy->coverage_to)->format('F d, Y') ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="policy-info-row">
                    <p class="policy-info-label">Chassis No.:</p>
                    <p class="policy-info-value">{{ $display($policy->chassis_number) }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="policy-info-row">
                    <p class="policy-info-label">Engine No.:</p>
                    <p class="policy-info-value">{{ $display($policy->engine_number) }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="policy-info-row">
                    <p class="policy-info-label">MV File No.:</p>
                    <p class="policy-info-value">{{ $display($policy->mv_file_number) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Mortgage:</p>
                    <p class="policy-info-value">{{ $display($policy->mortgage) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Freebie:</p>
                    <p class="policy-info-value">{{ $display($policy->freebie) }}</p>
                </div>
            </div>
        </div>

        @if($policy->remarks)
            <div class="row mt-2">
                <div class="col-12">
                    <p class="policy-info-label">Remarks:</p>
                    <div class="policy-remarks-box">{{ $policy->remarks }}</div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Walk-in Details -->
<div class="policy-view-section">
    <div class="policy-section-title">Walk-in Details</div>
    <div class="mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Date:</p>
                    <p class="policy-info-value">{{ optional($policy->walkin_date)->format('F d, Y') ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">File Upload:</p>
                    <p class="policy-info-value">{{ $display($policy->walkin_file) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Estimate Amount:</p>
                    <p class="policy-info-value">{{ $display($policy->estimate_amount) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Size:</p>
                    <p class="policy-info-value">{{ $display($policy->size) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="policy-info-row">
                    <p class="policy-info-label">Services Availed:</p>
                    <p class="policy-info-value">{{ is_array($policy->services ?? null) ? implode(', ', $policy->services) : $display($policy->services) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Rate:</p>
                    <p class="policy-info-value">{{ $display($policy->rate) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Payment (Walk-in):</p>
                    <p class="policy-info-value">{{ $display($policy->walkin_payment) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment & Bank -->
<div class="policy-view-section">
    <div class="policy-section-title">Payment</div>
    <div class="mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Payment Terms:</p>
                    <p class="policy-info-value">{{ $display($policy->payment_terms) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Paid Amount:</p>
                    <p class="policy-info-value">{{ $display($policy->paid_amount) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Payment Method:</p>
                    <p class="policy-info-value">{{ $display($policy->payment_method) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Bank Transfer To:</p>
                    <p class="policy-info-value">{{ $display($policy->bank_transfer ?? $policy->bank_transfer_other) }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Additional Freebie:</p>
                    <p class="policy-info-value">{{ $display($policy->additional_freebie) }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="policy-info-row">
                    <p class="policy-info-label">Reference No.:</p>
                    <p class="policy-info-value">{{ $display($policy->reference_number) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary of Premium and Other Charges -->
<div class="policy-view-section">
    <div class="policy-section-title">Summary of Premium and Other Charges</div>
    <div class="mt-3">
        <div class="policy-summary-card">
            <div class="policy-summary-row">
                <p class="policy-summary-label mb-0">Premium</p>
                <p class="policy-summary-value mb-0">₱ {{ number_format($policy->premium ?? 0, 2) }}</p>
            </div>

            <div class="policy-summary-row">
                <p class="policy-summary-label mb-0">Value Added Tax</p>
                <p class="policy-summary-value mb-0">₱ {{ number_format($policy->vat ?? 0, 2) }}</p>
            </div>

            <div class="policy-summary-row">
                <p class="policy-summary-label mb-0">Documentary Stamp Tax</p>
                <p class="policy-summary-value mb-0">₱ {{ number_format($policy->documentary_stamp_tax ?? 0, 2) }}</p>
            </div>

            <div class="policy-summary-row">
                <p class="policy-summary-label mb-0">Local Government Tax</p>
                <p class="policy-summary-value mb-0">₱ {{ number_format($policy->local_gov_tax ?? 0, 2) }}</p>
            </div>

            <hr class="policy-divider" />

            <div class="policy-summary-row">
                <p class="policy-summary-label policy-summary-total mb-0">Amount Due</p>
                <p class="policy-summary-value policy-summary-total mb-0">₱ {{ number_format($policy->amount_due ?? 0, 2) }}</p>
            </div>

            @php
                $balance = ($policy->amount_due ?? 0) - ($policy->paid_amount ?? 0);
            @endphp

            <div class="policy-summary-row">
                <p class="policy-summary-label policy-summary-total mb-0">Balance (Remaining)</p>
                <p class="policy-summary-value policy-summary-total mb-0 {{ $balance > 0 ? 'text-danger' : 'text-success' }}">
                    ₱ {{ number_format($balance, 2) }}
                </p>
            </div>

            <div class="policy-summary-row">
                <p class="policy-summary-label mb-0">COC VP</p>
                <p class="policy-summary-value mb-0">₱ {{ number_format($policy->coc_vp ?? 0, 2) }}</p>
            </div>

            @if($policy->premium_remarks)
                <div class="mt-3">
                    <p class="policy-info-label">Remarks</p>
                    <div class="policy-remarks-box">{{ $policy->premium_remarks }}</div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- End of partial -->
