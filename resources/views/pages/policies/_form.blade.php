<!-- Shared policy form fields (used by create and edit) -->
@php
    // $policy may be null for the create form
    // allow caller to hide the Policy / Walk-in toggle buttons by passing $showDetailsButtons = false
    $showDetailsButtons = isset($showDetailsButtons) ? (bool)$showDetailsButtons : true;
@endphp

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
                                {{ old('client_id', optional($policy)->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->firstName }} {{ $client->middleName }} {{ $client->lastName }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <input type="hidden" name="client_name" id="clientNameHidden" value="{{ old('client_name', optional($policy)->client_name) }}">
                @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @error('client_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="clientAddress"
                       name="address" value="{{ old('address', optional($policy)->address) }}" required>
                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="clientEmail"
                       name="email" value="{{ old('email', optional($policy)->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="clientPhone"
                       name="contact_number" value="{{ old('contact_number', optional($policy)->contact_number) }}" required>
                @error('contact_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Make Model</label>
                <input type="text" class="form-control @error('make_model') is-invalid @enderror"
                       name="make_model" value="{{ old('make_model', optional($policy)->make_model) }}" required>
                @error('make_model')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Plate No.</label>
                <input type="text" class="form-control @error('plate_number') is-invalid @enderror"
                       name="plate_number" value="{{ old('plate_number', optional($policy)->plate_number) }}" required>
                @error('plate_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Model Year</label>
                <input type="text" class="form-control @error('model_year') is-invalid @enderror"
                       name="model_year" value="{{ old('model_year', optional($policy)->model_year) }}" required>
                @error('model_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Color</label>
                <input type="text" class="form-control @error('color') is-invalid @enderror"
                       name="color" value="{{ old('color', optional($policy)->color) }}" required>
                @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                @if($showDetailsButtons)
                    <div class="form-type-buttons">
                        <button type="button" class="btn btn-primary" id="policyDetailsBtn">Policy Details</button>
                        <button type="button" class="btn btn-outline-primary" id="walkinDetailsBtn">Walk-in Details</button>
                    </div>
                @endif
            </div>

            <div id="policyDetails" class="details-content active">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Insurance Provider</label>
                        <select class="form-select @error('insurance_provider_id') is-invalid @enderror"
                                id="insuranceProvider" name="insurance_provider_id" required>
                            <option value="">Select insurance provider</option>
                            @foreach($insuranceProviders as $provider)
                                <option value="{{ $provider->id }}" data-code="{{ $provider->code }}" data-banks='@json($provider->banks)'
                                    {{ (string)old('insurance_provider_id', optional($policy)->insurance_provider_id) === (string)$provider->id ? 'selected' : '' }}>
                                    {{ $provider->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('insurance_provider_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Issue Date</label>
                        <input type="date" class="form-control @error('issue_date') is-invalid @enderror"
                               name="issue_date" value="{{ old('issue_date', optional($policy)->issue_date) }}">
                        @error('issue_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Coverage Period From</label>
                        <input type="date" class="form-control @error('coverage_from') is-invalid @enderror"
                               name="coverage_from" value="{{ old('coverage_from', optional($policy)->coverage_from) }}">
                        @error('coverage_from')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Coverage Period To</label>
                        <input type="date" class="form-control @error('coverage_to') is-invalid @enderror"
                               name="coverage_to" value="{{ old('coverage_to', optional($policy)->coverage_to) }}">
                        @error('coverage_to')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3">
                        <label class="form-label">Serial/Chassis No.</label>
                        <input type="text" class="form-control @error('chassis_number') is-invalid @enderror"
                               name="chassis_number" value="{{ old('chassis_number', optional($policy)->chassis_number ?? 'MPATK51V0PJ406822') }}" placeholder="MPATK51V0PJ406822">
                        @error('chassis_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Motor/Engine No.</label>
                        <input type="text" class="form-control @error('engine_number') is-invalid @enderror"
                               name="engine_number" value="{{ old('engine_number', optional($policy)->engine_number ?? 'K15RT1422393') }}" placeholder="K15RT1422393">
                        @error('engine_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">MV File No.</label>
                        <input type="text" class="form-control @error('mv_file_number') is-invalid @enderror"
                               name="mv_file_number" value="{{ old('mv_file_number', optional($policy)->mv_file_number ?? 'TBA') }}" placeholder="TBA">
                        @error('mv_file_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Mortgage</label>
                        <input type="text" class="form-control @error('mortgage') is-invalid @enderror"
                               name="mortgage" value="{{ old('mortgage', optional($policy)->mortgage ?? 'BANK OF THE PHILIPPINE ISLANDS') }}" placeholder="BANK OF THE PHILIPPINE ISLANDS">
                        @error('mortgage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">File Upload</label>
                        <input type="file" class="form-control @error('policy_file') is-invalid @enderror"
                               name="policy_file">
                        @error('policy_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">Remarks</label>
                        <textarea class="form-control @error('remarks') is-invalid @enderror" name="remarks" rows="3" placeholder="Enter remarks">{{ old('remarks', optional($policy)->remarks) }}</textarea>
                        @error('remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Freebie</label>
                        <select class="form-select @error('freebie') is-invalid @enderror" name="freebie">
                            <option value="">Select freebie</option>
                            @if(isset($freebies) && $freebies->count())
                                @foreach($freebies as $f)
                                    <option value="{{ $f->name }}" {{ old('freebie', optional($policy)->freebie) == $f->name ? 'selected' : '' }}>{{ $f->name }}</option>
                                @endforeach
                            @else
                                @foreach(['Undercoat','Buffing'] as $freebie)
                                    <option value="{{ $freebie }}" {{ old('freebie', optional($policy)->freebie) == $freebie ? 'selected' : '' }}>{{ $freebie }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('freebie')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Walk-in Details -->
            <div id="walkinDetails" class="details-content">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control @error('walkin_date') is-invalid @enderror" name="walkin_date" value="{{ old('walkin_date', optional($policy)->walkin_date) }}">
                        @error('walkin_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">File Upload</label>
                        <input type="file" class="form-control @error('walkin_file') is-invalid @enderror" name="walkin_file">
                        @error('walkin_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">Estimate Amount</label>
                        <input type="text" class="form-control @error('estimate_amount') is-invalid @enderror" name="estimate_amount" value="{{ old('estimate_amount', optional($policy)->estimate_amount) }}" placeholder="Enter estimate amount">
                        @error('estimate_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Size</label>
                        <select class="form-select @error('size') is-invalid @enderror" name="size">
                            <option value="">Select size</option>
                            @foreach(['Small','Medium','Large','X-Large','XXL-Large'] as $size)
                                <option value="{{ $size }}" {{ old('size', optional($policy)->size) == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                        @error('size')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12">
                        <label class="form-label">Services Availed</label>
                        <div class="services-input-wrapper" id="servicesInputGroup">
                            {{-- If editing and there are existing services, render them as badges (with data-price) so JS can pick them up on load --}}
                            @if(!empty(optional($policy)->services) && is_array(optional($policy)->services))
                                @foreach(optional($policy)->services as $existingService)
                                    @php
                                        $svc = isset($services) ? collect($services)->firstWhere('name', $existingService) : null;
                                        $svcPrice = $svc ? number_format((float)$svc->price, 2, '.', '') : '0.00';
                                    @endphp
                                    <div class="services-badge" data-service="{{ $existingService }}" data-price="{{ $svcPrice }}">
                                        {{ $existingService }} - ₱ {{ number_format((float)$svcPrice, 2) }}
                                        <button type="button" class="btn-remove">&times;</button>
                                    </div>
                                @endforeach
                            @endif

                            <select class="services-dropdown" id="serviceDropdown">
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
                        <input type="hidden" name="services[]" id="servicesInput">
                        @error('services')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">Rate</label>
                        <input type="text" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate', optional($policy)->rate) }}" placeholder="Enter rate">
                        @error('rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Payment</label>
                        <input type="text" class="form-control @error('walkin_payment') is-invalid @enderror" name="walkin_payment" value="{{ old('walkin_payment', optional($policy)->walkin_payment) }}" placeholder="Enter payment amount">
                        @error('walkin_payment')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                    @foreach(['Full payment','30 days','60 days','90 days'] as $term)
                        <option value="{{ $term }}" {{ old('payment_terms', optional($policy)->payment_terms) == $term ? 'selected' : '' }}>{{ $term }}</option>
                    @endforeach
                </select>
                @error('payment_terms')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Paid Amount</label>
                <input type="text" class="form-control @error('paid_amount') is-invalid @enderror" name="paid_amount" value="{{ old('paid_amount', optional($policy)->paid_amount) }}" placeholder="Enter paid amount">
                @error('paid_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Payment Method</label>
                <select class="form-select @error('payment_method') is-invalid @enderror" id="paymentMethod" name="payment_method">
                    <option value="">Select method</option>
                    @foreach(['Cash','Transfer','PDC','Cancelled'] as $method)
                        <option value="{{ $method }}" {{ old('payment_method', optional($policy)->payment_method) == $method ? 'selected' : '' }}>{{ $method }}</option>
                    @endforeach
                </select>
                @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <div class="bank-transfer-fields" id="bankTransferFields">
                    <label class="form-label">Bank Transfer To</label>
                    <select class="form-select @error('bank_transfer') is-invalid @enderror" id="bankTransfer" name="bank_transfer">
                        <option value="">Select bank</option>
                    </select>
                    @error('bank_transfer')<div class="invalid-feedback">{{ $message }}</div>@enderror

                    <input type="text" id="bankOther" name="bank_transfer_other" class="form-control mt-2 @error('bank_transfer_other') is-invalid @enderror" style="display:none;" placeholder="Enter bank name" value="{{ old('bank_transfer_other', optional($policy)->bank_transfer) }}">
                    @error('bank_transfer_other')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label">Freebie</label>
                <select class="form-select @error('additional_freebie') is-invalid @enderror" name="additional_freebie">
                    <option value="">Select freebie</option>
                    @if(isset($freebies) && $freebies->count())
                        @foreach($freebies as $f)
                            <option value="{{ $f->name }}" {{ old('additional_freebie', optional($policy)->additional_freebie) == $f->name ? 'selected' : '' }}>{{ $f->name }}</option>
                        @endforeach
                    @else
                        @foreach(['Undercoat','Buffing'] as $freebie)
                            <option value="{{ $freebie }}" {{ old('additional_freebie', optional($policy)->additional_freebie) == $freebie ? 'selected' : '' }}>{{ $freebie }}</option>
                        @endforeach
                    @endif
                </select>
                @error('additional_freebie')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Reference No.</label>
                <input type="text" class="form-control @error('reference_number') is-invalid @enderror" name="reference_number" value="{{ old('reference_number', optional($policy)->reference_number) }}" placeholder="Enter reference number">
                @error('reference_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
</div>

<!-- Summary of Premium and Other Charges Section -->
<div class="section-container mb-4">
    <div class="section-title">Summary of Premium and Other Charges</div>
    <div class="section-content">
        <div class="card p-3">
            <h6 class="mb-3 fw-bold">SUMMARY OF PREMIUM AND OTHER CHARGES</h6>

            <div class="row g-2 align-items-center mb-2">
                <div class="col-8">
                    <label class="form-label mb-0">Premium</label>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control form-control-sm text-end @error('premium') is-invalid @enderror" name="premium" value="{{ old('premium', optional($policy)->premium) }}" placeholder="PHP">
                    @error('premium')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
                <div class="col-8">
                    <label class="form-label mb-0">Value Added Tax</label>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control form-control-sm text-end @error('vat') is-invalid @enderror" name="vat" value="{{ old('vat', optional($policy)->vat) }}" placeholder="PHP">
                    @error('vat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
                <div class="col-8">
                    <label class="form-label mb-0">Documentary Stamp Tax</label>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control form-control-sm text-end @error('documentary_stamp_tax') is-invalid @enderror" name="documentary_stamp_tax" value="{{ old('documentary_stamp_tax', optional($policy)->documentary_stamp_tax) }}" placeholder="PHP">
                    @error('documentary_stamp_tax')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
                <div class="col-8">
                    <label class="form-label mb-0">Local Government Tax</label>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control form-control-sm text-end @error('local_gov_tax') is-invalid @enderror" name="local_gov_tax" value="{{ old('local_gov_tax', optional($policy)->local_gov_tax) }}" placeholder="PHP">
                    @error('local_gov_tax')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr />
            <!-- Services subtotal (auto-filled) -->
            <div class="row g-2 align-items-center mb-2">
                <div class="col-8">
                    <label class="form-label mb-0">Services Subtotal</label>
                </div>
                <div class="col-4">
                    <input type="text" id="servicesSubtotal" class="form-control form-control-sm text-end" value="0.00" readonly style="background-color: #f1f3f5;">
                </div>
            </div>

            <div class="row g-2 align-items-center mb-3">
                <div class="col-8">
                    <label class="form-label mb-0 fw-bold">Amount Due</label>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control form-control-sm fw-bold text-end @error('amount_due') is-invalid @enderror" name="amount_due" value="{{ old('amount_due', optional($policy)->amount_due) }}" placeholder="PHP" id="amountDueInput" readonly style="background-color: #f1f3f5;">
                    @error('amount_due')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-2 align-items-center mb-3">
                <div class="col-8">
                    <label class="form-label mb-0">COC VP</label>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control form-control-sm text-end @error('coc_vp') is-invalid @enderror" name="coc_vp" value="{{ old('coc_vp', optional($policy)->coc_vp ?? '0.00') }}" placeholder="PHP">
                    @error('coc_vp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12">
                    <label class="form-label">Remarks</label>
                    <textarea class="form-control @error('premium_remarks') is-invalid @enderror" name="premium_remarks" rows="3" placeholder="Enter remarks">{{ old('premium_remarks', optional($policy)->premium_remarks) }}</textarea>
                    @error('premium_remarks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form actions (rendered by parent view) -->
<div class="text-end">
    <button type="reset" class="btn btn-secondary me-2">Reset</button>
    <button type="submit" class="btn btn-primary">Submit Policy</button>
</div>
