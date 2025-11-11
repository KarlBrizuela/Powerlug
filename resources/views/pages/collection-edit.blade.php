@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Collection</h4>
                <a href="{{ route('collections.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Collections
                </a>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            Please fix the following errors:
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('collections.update', $collection) }}">
                        @csrf
                        @method('PUT')

                        <!-- Collection Information -->
                        <div class="section-title">Collection Information</div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_id" class="form-label">Client Name <span class="text-danger">*</span></label>
                                    <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                        <option value="">Select Client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('client_id', $collection->client_id) == $client->id ? 'selected' : '' }}>
                                                {{ $client->lastName }}, {{ $client->firstName }} {{ $client->middleName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="invoice_number" class="form-label">Service Invoice Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" 
                                        id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $collection->invoice_number) }}" 
                                        placeholder="Enter service invoice number" required>
                                    @error('invoice_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="billing_status" class="form-label">Billing Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('billing_status') is-invalid @enderror" 
                                        id="billing_status" name="billing_status" required>
                                        <option value="">Select Status</option>
                                        <option value="billed" {{ old('billing_status', $collection->billing_status) == 'billed' ? 'selected' : '' }}>Billed</option>
                                        <option value="pending" {{ old('billing_status', $collection->billing_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="overdue" {{ old('billing_status', $collection->billing_status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                    @error('billing_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="collection_amount" class="form-label">Collection Amount (₱) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('collection_amount') is-invalid @enderror" 
                                        id="collection_amount" name="collection_amount" value="{{ old('collection_amount', $collection->collection_amount) }}" 
                                        placeholder="Amount collected" min="0" step="0.01" required>
                                    @error('collection_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror" 
                                        id="payment_method" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="cash" {{ old('payment_method', $collection->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="check" {{ old('payment_method', $collection->payment_method) == 'check' ? 'selected' : '' }}>Check</option>
                                        <option value="bank_transfer" {{ old('payment_method', $collection->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="collection_status" class="form-label">Status of Collection <span class="text-danger">*</span></label>
                                    <select class="form-select @error('collection_status') is-invalid @enderror" 
                                        id="collection_status" name="collection_status" required>
                                        <option value="">Select status</option>
                                        <option value="deposited" {{ old('collection_status', $collection->collection_status) == 'deposited' ? 'selected' : '' }}>Deposited to Bank</option>
                                        <option value="pending" {{ old('collection_status', $collection->collection_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="cleared" {{ old('collection_status', $collection->collection_status) == 'cleared' ? 'selected' : '' }}>Check Cleared</option>
                                        <option value="bounced" {{ old('collection_status', $collection->collection_status) == 'bounced' ? 'selected' : '' }}>Check Bounced</option>
                                        <option value="cash" {{ old('collection_status', $collection->collection_status) == 'cash' ? 'selected' : '' }}>Cash Collected</option>
                                    </select>
                                    @error('collection_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="collection_date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('collection_date') is-invalid @enderror" 
                                        id="collection_date" name="collection_date" value="{{ old('collection_date', $collection->collection_date->format('Y-m-d')) }}" required>
                                    @error('collection_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bank_name" class="form-label">Bank</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                        id="bank_name" name="bank_name" value="{{ old('bank_name', $collection->bank_name) }}" 
                                        placeholder="Bank (BDO, BPI, etc.)">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('collections.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Collection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection