@extends('layouts.app')

@section('title', 'New Insurance Provider - Powerlug')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">New Insurance Provider</h4>
                    <a href="{{ route('providers.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-1"></i> View All Providers
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                        <form method="POST" action="{{ route('providers.store') }}">
                            @csrf

                            <!-- Provider Information -->
                            <div class="section-title">Provider Information</div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Insurance Provider Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                           name="code" value="{{ old('code') }}" 
                                           placeholder="Enter provider code" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Unique code for the insurance provider (e.g., MERCANTILE, MALAYAN, FPG)</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Insurance Provider Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" 
                                           placeholder="Enter provider name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Full name of the insurance provider</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror" 
                                           name="contact_person" value="{{ old('contact_person') }}" 
                                           placeholder="Enter contact person name">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Email</label>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                           name="contact_email" value="{{ old('contact_email') }}" 
                                           placeholder="Enter contact email">
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Contact Phone</label>
                                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                                           name="contact_phone" value="{{ old('contact_phone') }}" 
                                           placeholder="Enter contact phone number">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Website</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                           name="website" value="{{ old('website') }}" 
                                           placeholder="Enter website URL">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" 
                                              name="address" rows="3" 
                                              placeholder="Enter provider address">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Active Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('is_active') is-invalid @enderror" name="is_active" required>
                                        <option value="">Select status</option>
                                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Commission Rate (%)</label>
                                    <input type="number" class="form-control @error('commission_rate') is-invalid @enderror" 
                                           name="commission_rate" value="{{ old('commission_rate') }}" 
                                           placeholder="Enter commission rate" min="0" max="100" step="0.01">
                                    @error('commission_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Standard commission rate for this provider</small>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label">Additional Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              name="notes" rows="3" 
                                              placeholder="Enter any additional notes or remarks">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="reset" class="btn btn-secondary me-2">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Submit Provider
                                </button>
                            </div>
                        </form>
                    </div>
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate code from name
        const nameInput = document.querySelector('input[name="name"]');
        const codeInput = document.querySelector('input[name="code"]');
        
        nameInput.addEventListener('blur', function() {
            if (!codeInput.value) {
                // Generate code from name (uppercase, remove spaces and special chars)
                const code = this.value
                    .toUpperCase()
                    .replace(/[^A-Z0-9]/g, '_')
                    .replace(/_+/g, '_')
                    .replace(/^_|_$/g, '');
                codeInput.value = code;
            }
        });

        // Initialize Feather Icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endpush