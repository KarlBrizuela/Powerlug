<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Policy - Policy Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .main-content {
            margin-left: 280px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }

        /* Page Header */
        .page-header {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            background: #fff;
        }
        
        .card-body {
            padding: 2rem;
        }

        /* Form Controls */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.6rem 0.75rem;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
        }

        /* Button Styling */
        .btn {
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,123,255,0.3);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-outline-primary {
            border: 2px solid #007bff;
            color: #007bff;
        }

        .btn-outline-primary:hover {
            background: #007bff;
            color: #fff;
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Select2 Customization */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 8px !important;
            border: 1px solid #dee2e6 !important;
            min-height: 42px !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding: 0.6rem 0.75rem !important;
        }

        /* Services Availed UI Styling */
        .services-input-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            background-color: #fff;
            min-height: 42px;
            align-items: center;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .services-input-wrapper:focus-within {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .services-dropdown {
            border: none !important;
            padding: 0 !important;
            flex: 1;
            min-width: 150px;
            background: transparent !important;
            outline: none;
            font-family: inherit;
        }

        .services-dropdown:focus {
            outline: none;
            box-shadow: none;
        }

        .services-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background-color: #0d6efd;
            color: white;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .services-badge .btn-remove {
            background: none;
            border: none;
            color: white;
            padding: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            font-size: 14px;
            line-height: 1;
        }

        .services-badge .btn-remove:hover {
            opacity: 0.8;
        }

        /* Service payment due styles */
        .service-with-due {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 8px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 8px;
            width: 100%;
        }

        .service-info {
            flex: 1;
        }

        .service-badge-small {
            display: inline-block;
            padding: 4px 8px;
            background-color: #0d6efd;
            color: white;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .service-due-date-input {
            flex: 0 0 auto;
            width: 150px;
        }

        .service-remove-btn {
            flex: 0 0 auto;
            background: #dc3545;
            border: none;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.2s;
        }

        .service-remove-btn:hover {
            background: #bb2d3b;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('components.sidebar')
        
        <!-- Main content -->
        <main class="main-content flex-grow-1">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="page-title">Edit Policy</h2>
                        <a href="{{ route('policies.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6 class="alert-heading mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Validation Errors</h6>
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
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- Custom Scripts -->
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

            // Services selection functionality (matching policy.blade.php create)
            const serviceDropdown = document.getElementById('serviceDropdown');
            const servicesInputGroup = document.getElementById('servicesInputGroup');
            let selectedServices = [];

            // Load existing services from server-side rendered elements (service-with-due)
            if (servicesInputGroup) {
                document.querySelectorAll('#servicesInputGroup .service-with-due').forEach(container => {
                    const service = container.dataset.service;
                    const price = parseFloat(container.dataset.price) || 0;
                    const dueDate = container.dataset.dueDate || '';
                    if (service) {
                        selectedServices.push({ name: service, price: price, paymentDue: dueDate });
                    }
                });
            }

            // Initialize the services container if it doesn't exist
            if (!document.getElementById('servicesContainer')) {
                const container = document.createElement('div');
                container.id = 'servicesContainer';
                if (servicesInputGroup && servicesInputGroup.parentElement) {
                    servicesInputGroup.parentElement.appendChild(container);
                }
            }

            if (serviceDropdown) {
                serviceDropdown.addEventListener('change', function() {
                    const selectedValue = this.value;
                    const opt = this.selectedOptions && this.selectedOptions[0] ? this.selectedOptions[0] : null;
                    const price = opt && opt.dataset && opt.dataset.price ? parseFloat(opt.dataset.price) || 0 : 0;
                    if (selectedValue && !selectedServices.some(s => s.name === selectedValue)) {
                        // Prompt user for payment due date
                        const dueDate = prompt(`When is the payment due for "${selectedValue}"? (Enter date as YYYY-MM-DD or leave blank)`);
                        selectedServices.push({ name: selectedValue, price: price, paymentDue: dueDate || '' });
                        renderServices();
                        this.value = '';
                    }
                });
            }

            function renderServices() {
                const dropdown = document.getElementById('serviceDropdown');
                if (!dropdown || !servicesInputGroup) return;

                const existingElements = servicesInputGroup.querySelectorAll('.services-badge, .service-with-due');
                existingElements.forEach(el => el.remove());
                dropdown.style.display = 'block';

                const placeholderOption = dropdown.querySelector('option[value=""]');
                if (selectedServices.length > 0) {
                    if (placeholderOption) placeholderOption.style.display = 'none';
                } else {
                    if (placeholderOption) placeholderOption.style.display = 'block';
                }

                selectedServices.forEach(svc => {
                    const serviceContainer = document.createElement('div');
                    serviceContainer.className = 'service-with-due';
                    serviceContainer.dataset.service = svc.name;
                    serviceContainer.dataset.price = svc.price || 0;
                    // Ensure payment due date is in the correct format (YYYY-MM-DD)
                    const formattedDueDate = svc.paymentDue && svc.paymentDue.trim() ? svc.paymentDue : '';
                    serviceContainer.dataset.dueDate = formattedDueDate;
                    
                    serviceContainer.innerHTML = `
                        <div class="service-info">
                            <span class="service-badge-small">${svc.name} - ₱ ${Number(svc.price || 0).toFixed(2)}</span>
                        </div>
                        <div class="service-due-date-input">
                            <input type="date" class="form-control form-control-sm service-due-date" 
                                   value="${formattedDueDate}" 
                                   placeholder="Payment due date">
                        </div>
                        <button type="button" class="service-remove-btn" aria-label="Remove ${svc.name}">Remove</button>
                    `;
                    servicesInputGroup.insertBefore(serviceContainer, dropdown);

                    // Add event listener to update payment due when date changes
                    const dateInput = serviceContainer.querySelector('.service-due-date');
                    dateInput.addEventListener('change', function() {
                        const serviceIndex = selectedServices.findIndex(x => x.name === svc.name);
                        if (serviceIndex !== -1) {
                            selectedServices[serviceIndex].paymentDue = this.value;
                        }
                    });

                    serviceContainer.querySelector('.service-remove-btn').addEventListener('click', function(e) {
                        e.preventDefault();
                        selectedServices = selectedServices.filter(x => x.name !== svc.name);
                        renderServices();
                    });
                });

                const container = document.createElement('div');
                container.id = 'servicesContainer';
                selectedServices.forEach(svc => {
                    const serviceInput = document.createElement('input');
                    serviceInput.type = 'hidden';
                    serviceInput.name = 'services[]';
                    serviceInput.value = svc.name;
                    container.appendChild(serviceInput);

                    const dueInput = document.createElement('input');
                    dueInput.type = 'hidden';
                    dueInput.name = 'service_payment_dues[]';
                    dueInput.value = svc.paymentDue || '';
                    container.appendChild(dueInput);
                });

                const oldContainer = document.getElementById('servicesContainer');
                if (oldContainer) {
                    oldContainer.replaceWith(container);
                } else {
                    servicesInputGroup.parentElement.appendChild(container);
                }

                // Expose selected services globally so amount calculation can include prices
                window.selectedServices = selectedServices;
                
                // Update services subtotal directly
                const servicesTotal = selectedServices.reduce((sum, s) => sum + (parseFloat(s.price) || 0), 0);
                const servicesSubtotalEl = document.getElementById('servicesSubtotal');
                if (servicesSubtotalEl) {
                    servicesSubtotalEl.value = servicesTotal.toFixed(2);
                }
                
                // Force direct calculation of amount due without relying on jQuery
                const premium = parseFloat(document.querySelector('input[name="premium"]')?.value) || 0;
                const vat = parseFloat(document.querySelector('input[name="vat"]')?.value) || 0;
                const docStampTax = parseFloat(document.querySelector('input[name="documentary_stamp_tax"]')?.value) || 0;
                const localGovTax = parseFloat(document.querySelector('input[name="local_gov_tax"]')?.value) || 0;
                const totalAmountDue = premium + vat + docStampTax + localGovTax + servicesTotal;
                const amountDueInput = document.querySelector('input[name="amount_due"]');
                if (amountDueInput) {
                    amountDueInput.value = totalAmountDue.toFixed(2);
                }
                
                // Recalculate balance
                const paidAmountEl = document.getElementById('paidAmount');
                if (paidAmountEl) {
                    const paidAmount = parseFloat(paidAmountEl.value) || 0;
                    const balance = totalAmountDue - paidAmount;
                    const balanceEl = document.getElementById('balanceAmount');
                    if (balanceEl) {
                        balanceEl.value = balance.toFixed(2);
                        if (balance <= 0) {
                            balanceEl.style.color = '#198754';
                            balanceEl.style.fontWeight = 'bold';
                        } else {
                            balanceEl.style.color = '#dc3545';
                            balanceEl.style.fontWeight = 'bold';
                        }
                    }
                }
                
                // Recalculate amount due (if the page script uses it)
                if (typeof calculateAmountDue === 'function') {
                    calculateAmountDue();
                }
            }

            if (selectedServices.length > 0) {
                // Delay initial render until jQuery ready to ensure calculateAmountDue is available
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', function() {
                        // Ensure existing services are rendered with the new format
                        renderServices();
                    });
                } else {
                    setTimeout(renderServices, 100);
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initPolicyForm);
            } else {
                initPolicyForm();
            }
        })();
    </script>
    
    <!-- Client Select2 and Auto-fill Script -->
    <script>
        $(document).ready(function() {
            // Initialize Select2 for client dropdown
            $('#clientSelect').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select or type to search client...',
                allowClear: true
            });

            // Handle client selection change
            $('#clientSelect').on('change', function() {
                const selectedOption = $(this).find(':selected');
                const clientId = $(this).val();
                
                if (clientId) {
                    // Get client data from option attributes
                    const email = selectedOption.data('email') || '';
                    const phone = selectedOption.data('phone') || '';
                    const address = selectedOption.data('address') || '';
                    const clientName = selectedOption.text().trim();
                    
                    // Fill the form fields
                    $('#clientEmail').val(email);
                    $('#clientPhone').val(phone);
                    $('#clientAddress').val(address);
                    $('#clientNameHidden').val(clientName);
                } else {
                    // Clear fields if no client selected
                    $('#clientEmail').val('');
                    $('#clientPhone').val('');
                    $('#clientAddress').val('');
                    $('#clientNameHidden').val('');
                }
            });

            // Trigger change on page load if a client is already selected (for edit mode)
            if ($('#clientSelect').val()) {
                $('#clientSelect').trigger('change');
            }

            // Auto-calculate Amount Due
            function calculateAmountDue() {
                const premium = parseFloat($('input[name="premium"]').val()) || 0;
                const vat = parseFloat($('input[name="vat"]').val()) || 0;
                const docStampTax = parseFloat($('input[name="documentary_stamp_tax"]').val()) || 0;
                const localGovTax = parseFloat($('input[name="local_gov_tax"]').val()) || 0;

                // Include services total if available
                const services = (window.selectedServices || []);
                const servicesTotal = services.reduce((sum, s) => sum + (parseFloat(s.price) || 0), 0);

                // Update services subtotal display
                $('#servicesSubtotal').val(servicesTotal.toFixed(2));

                const amountDue = premium + vat + docStampTax + localGovTax + servicesTotal;
                $('input[name="amount_due"]').val(amountDue.toFixed(2));
                
                // Also update balance when amount due changes
                calculateBalance();
            }

            // Calculate Balance (Amount Due - Paid Amount)
            function calculateBalance() {
                const amountDue = parseFloat($('input[name="amount_due"]').val()) || 0;
                const paidAmount = parseFloat($('#paidAmount').val()) || 0;
                
                const balance = amountDue - paidAmount;
                $('#balanceAmount').val(balance.toFixed(2));
                
                // Change color based on balance
                if (balance <= 0) {
                    $('#balanceAmount').css({'color': '#198754', 'font-weight': 'bold'}); // Green for paid
                } else {
                    $('#balanceAmount').css({'color': '#dc3545', 'font-weight': 'bold'}); // Red for unpaid
                }
            }

            // Attach event listeners to premium fields
            $('input[name="premium"], input[name="vat"], input[name="documentary_stamp_tax"], input[name="local_gov_tax"]').on('input', function() {
                calculateAmountDue();
            });

            // Attach event listener to paid amount
            $('#paidAmount').on('input', function() {
                calculateBalance();
            });

            // Also recalculate balance when amount due changes manually
            $('input[name="amount_due"]').on('input', function() {
                calculateBalance();
            });

            // Calculate on page load if values exist
            calculateAmountDue();
            calculateBalance();
        });
    </script>
</body>
</html>