<!-- Read-only view partial that mirrors the edit/create form fields -->
@php
    // $policy is provided by the parent view
    $display = function($value, $fallback = 'N/A') {
        if (is_null($value) || $value === '') return $fallback;
        return $value;
    };
@endphp

<!-- Primary Information -->
<div class="section-container mb-4">
    <div class="section-title">Primary Information</div>
    <div class="section-content">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Client Name:</strong></label>
                    <span class="mb-0">{{ $display($policy->client_name ?? ($policy->client ? ($policy->client->firstName ?? $policy->client->first_name).' '.($policy->client->lastName ?? $policy->client->last_name) : null)) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Address:</strong></label>
                    <span class="mb-0">{{ $display($policy->address) }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Email:</strong></label>
                    <span class="mb-0">{{ $display($policy->email) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Contact Number:</strong></label>
                    <span class="mb-0">{{ $display($policy->contact_number) }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Make / Model:</strong></label>
                    <span class="mb-0">{{ $display($policy->make_model) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Plate No.:</strong></label>
                    <span class="mb-0">{{ $display($policy->plate_number) }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Model Year:</strong></label>
                    <span class="mb-0">{{ $display($policy->model_year) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Color:</strong></label>
                    <span class="mb-0">{{ $display($policy->color) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Insurance & Policy Details -->
<div class="section-container mb-4">
    <div class="section-title">Insurance & Policy Details</div>
    <div class="section-content">
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Insurance Provider:</strong></label>
                    <span class="mb-0">{{ $display(optional($policy->insuranceProvider)->name ?? $policy->insurance_provider) }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Issue Date:</strong></label>
                    <span class="mb-0">{{ optional($policy->issue_date)->format('F d, Y') ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Coverage From:</strong></label>
                    <span class="mb-0">{{ optional($policy->coverage_from)->format('F d, Y') ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Coverage To:</strong></label>
                    <span class="mb-0">{{ optional($policy->coverage_to)->format('F d, Y') ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Chassis No.:</strong></label>
                    <span class="mb-0">{{ $display($policy->chassis_number) }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Engine No.:</strong></label>
                    <span class="mb-0">{{ $display($policy->engine_number) }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>MV File No.:</strong></label>
                    <span class="mb-0">{{ $display($policy->mv_file_number) }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Mortgage:</strong></label>
                    <span class="mb-0">{{ $display($policy->mortgage) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Freebie:</strong></label>
                    <span class="mb-0">{{ $display($policy->freebie) }}</span>
                </div>
            </div>
        </div>

        @if($policy->remarks)
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label mb-0"><strong>Remarks:</strong></label>
                    <div class="border rounded p-2 mt-1">{{ $policy->remarks }}</div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Walk-in Details -->
<div class="section-container mb-4">
    <div class="section-title">Walk-in Details</div>
    <div class="section-content">
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Date:</strong></label>
                    <span class="mb-0">{{ optional($policy->walkin_date)->format('F d, Y') ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>File Upload:</strong></label>
                    <span class="mb-0">{{ $display($policy->walkin_file) }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Estimate Amount:</strong></label>
                    <span class="mb-0">{{ $display($policy->estimate_amount) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Size:</strong></label>
                    <span class="mb-0">{{ $display($policy->size) }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12">
                <label class="form-label mb-0"><strong>Services Availed:</strong></label>
                <div class="mt-1">{{ is_array($policy->services ?? null) ? implode(', ', $policy->services) : $display($policy->services) }}</div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Rate:</strong></label>
                    <span class="mb-0">{{ $display($policy->rate) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Payment (Walk-in):</strong></label>
                    <span class="mb-0">{{ $display($policy->walkin_payment) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment & Bank -->
<div class="section-container mb-4">
    <div class="section-title">Payment</div>
    <div class="section-content">
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Payment Terms:</strong></label>
                    <span class="mb-0">{{ $display($policy->payment_terms) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Paid Amount:</strong></label>
                    <span class="mb-0">{{ $display($policy->paid_amount) }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Payment Method:</strong></label>
                    <span class="mb-0">{{ $display($policy->payment_method) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Bank Transfer To:</strong></label>
                    <span class="mb-0">{{ $display($policy->bank_transfer ?? $policy->bank_transfer_other) }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Additional Freebie:</strong></label>
                    <span class="mb-0">{{ $display($policy->additional_freebie) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0"><strong>Reference No.:</strong></label>
                    <span class="mb-0">{{ $display($policy->reference_number) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary of Premium and Other Charges -->
<div class="section-container mb-4">
    <div class="section-title">Summary of Premium and Other Charges</div>
    <div class="section-content">
        <div class="card p-3">
            <div class="row g-2 align-items-center mb-2">
                <div class="col-8"><label class="form-label mb-0">Premium</label></div>
                <div class="col-4 text-end">₱ {{ number_format($policy->premium ?? 0, 2) }}</div>
            </div>

            <div class="row g-2 align-items-center mb-2">
                <div class="col-8"><label class="form-label mb-0">Value Added Tax</label></div>
                <div class="col-4 text-end">₱ {{ number_format($policy->vat ?? 0, 2) }}</div>
            </div>

            <div class="row g-2 align-items-center mb-2">
                <div class="col-8"><label class="form-label mb-0">Documentary Stamp Tax</label></div>
                <div class="col-4 text-end">₱ {{ number_format($policy->documentary_stamp_tax ?? 0, 2) }}</div>
            </div>

            <div class="row g-2 align-items-center mb-2">
                <div class="col-8"><label class="form-label mb-0">Local Government Tax</label></div>
                <div class="col-4 text-end">₱ {{ number_format($policy->local_gov_tax ?? 0, 2) }}</div>
            </div>

            <hr />

            <div class="row g-2 align-items-center mb-3">
                <div class="col-8"><label class="form-label mb-0 fw-bold">Amount Due</label></div>
                <div class="col-4 text-end fw-bold">₱ {{ number_format($policy->amount_due ?? 0, 2) }}</div>
            </div>

            <div class="row g-2 align-items-center mb-3">
                <div class="col-8"><label class="form-label mb-0">COC VP</label></div>
                <div class="col-4 text-end">₱ {{ number_format($policy->coc_vp ?? 0, 2) }}</div>
            </div>

            @if($policy->premium_remarks)
                <div class="row mt-2">
                    <div class="col-12">
                        <label class="form-label">Remarks</label>
                        <div class="border rounded p-2">{{ $policy->premium_remarks }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- End of partial -->
