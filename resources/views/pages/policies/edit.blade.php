@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="page-title">Edit Policy</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('policies.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading">Validation Errors</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('policies.update', $policy->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('pages.policies._form', ['policy' => $policy, 'insuranceProviders' => $insuranceProviders, 'showDetailsButtons' => false])
            </form>
        </div>
    </div>
</div>

<style>
    .page-title {
        font-size: 2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }

    .card {
        border: 1px solid #dee2e6;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
@endsection

@push('scripts')
<script>
    (function() {
        // Bank transfer options based on insurance provider (keyed by provider code)
        const bankOptions = {
            'MERCANTILE': ['BDO', 'Metrobank', 'BPI'],
            'MALAYAN': ['Bills payment'],
            'FPG': ['BDO'],
            'FORTUNE_GEN': ['BDO', 'Union Bank', 'BPI', 'GCash'],
            'Cocogen Insurance': ['No specific banks'],
            'COUNTRY_BANKER': ['BPI', 'Union Bank'],
            'Standard Insurance': ['BDO']
        };

        // Map of insurance provider id -> provider code (populated from server-side $insuranceProviders)
        const providerIdToCodeMap = {
            @foreach($insuranceProviders as $provider)
                '{{ $provider->id }}': '{{ $provider->code ?? '' }}',
            @endforeach
        };

        // Normalized bank options (keys lowercased and trimmed) for robust lookup
        const normalizedBankOptions = {};
        Object.keys(bankOptions).forEach(k => {
            const key = (k || '').toString().trim().toLowerCase();
            normalizedBankOptions[key] = bankOptions[k];
        });

        function initPolicyForm() {
            const policyDetailsBtn = document.getElementById('policyDetailsBtn');
            const walkinDetailsBtn = document.getElementById('walkinDetailsBtn');
            const policyDetails = document.getElementById('policyDetails');
            const walkinDetails = document.getElementById('walkinDetails');
            const insuranceProvider = document.getElementById('insuranceProvider');
            const paymentMethod = document.getElementById('paymentMethod');
            const bankTransferFields = document.getElementById('bankTransferFields');
            const bankTransfer = document.getElementById('bankTransfer');

            // Initialize sections if present
            if (policyDetails && walkinDetails) {
                policyDetails.classList.add('active');
                walkinDetails.classList.remove('active');
            }

            if (policyDetailsBtn) {
                policyDetailsBtn.addEventListener('click', function() {
                    if (policyDetails && walkinDetails) {
                        policyDetails.classList.add('active');
                        walkinDetails.classList.remove('active');
                        policyDetailsBtn.classList.remove('btn-outline-primary');
                        policyDetailsBtn.classList.add('btn-primary');
                        walkinDetailsBtn.classList.remove('btn-primary');
                        walkinDetailsBtn.classList.add('btn-outline-primary');
                    }
                });
            }

            if (walkinDetailsBtn) {
                walkinDetailsBtn.addEventListener('click', function() {
                    if (policyDetails && walkinDetails) {
                        walkinDetails.classList.add('active');
                        policyDetails.classList.remove('active');
                        walkinDetailsBtn.classList.remove('btn-outline-primary');
                        walkinDetailsBtn.classList.add('btn-primary');
                        policyDetailsBtn.classList.remove('btn-primary');
                        policyDetailsBtn.classList.add('btn-outline-primary');
                    }
                });
            }

            // Show/hide bank transfer fields based on payment method
            if (paymentMethod) {
                paymentMethod.addEventListener('change', function() {
                    if (this.value === 'Transfer' && bankTransferFields) {
                        bankTransferFields.classList.add('show');
                        updateBankOptions();
                    } else if (bankTransferFields) {
                        bankTransferFields.classList.remove('show');
                    }
                });
            }

            if (insuranceProvider) {
                insuranceProvider.addEventListener('change', function() {
                    if (paymentMethod && paymentMethod.value === 'Transfer') {
                        updateBankOptions();
                    }
                });
            }

            if (bankTransfer) {
                bankTransfer.addEventListener('change', function() {
                    const bankOther = document.getElementById('bankOther');
                    if (!bankOther) return;
                    if (this.value === 'OTHER') {
                        bankOther.style.display = 'block';
                    } else {
                        bankOther.style.display = 'none';
                        bankOther.value = '';
                    }
                });
            }

            function updateBankOptions() {
                const selectedOption = insuranceProvider && insuranceProvider.selectedOptions && insuranceProvider.selectedOptions[0] ? insuranceProvider.selectedOptions[0] : null;
                const providerId = insuranceProvider ? insuranceProvider.value : null;
                const providerName = selectedOption ? selectedOption.textContent.trim() : '';
                // Prefer provider-specific banks provided in data-banks attribute
                let banks = [];
                const dataBanks = selectedOption ? selectedOption.dataset.banks : null;
                if (dataBanks) {
                    try {
                        const parsed = JSON.parse(dataBanks);
                        if (Array.isArray(parsed)) {
                            banks = parsed;
                        }
                    } catch (e) {
                        // fallback: split by comma or newline
                        banks = (dataBanks || '').toString().split(/[,\r\n]+/).map(s => s.trim()).filter(Boolean);
                    }
                }

                if (banks.length === 0) {
                    const providerCode = (providerId && providerIdToCodeMap[providerId]) || (selectedOption ? selectedOption.dataset.code : '') || providerName || providerId;
                    const lookupKey = (providerCode || '').toString().trim().toLowerCase();
                    banks = normalizedBankOptions[lookupKey] || [];
                }

                if (bankTransfer) {
                    bankTransfer.innerHTML = '<option value="">Select bank</option>';
                    banks.forEach(bank => {
                        const option = document.createElement('option');
                        option.value = bank;
                        option.textContent = bank;
                        bankTransfer.appendChild(option);
                    });

                    if (banks.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'No banks available for this provider';
                        bankTransfer.appendChild(option);

                        const otherOption = document.createElement('option');
                        otherOption.value = 'OTHER';
                        otherOption.textContent = 'Other (specify)';
                        bankTransfer.appendChild(otherOption);

                        bankTransfer.disabled = false;
                    } else {
                        bankTransfer.disabled = false;
                    }
                }
            }

            // Initialize on load
            updateBankOptions();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPolicyForm);
        } else {
            initPolicyForm();
        }
    })();
</script>
@endpush
