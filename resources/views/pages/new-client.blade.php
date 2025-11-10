<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Client - Powerlug</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fc;
        }
        .page-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .page-content {
            flex: 1;
            padding: 20px;
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }
        .sidebar-collapsed .page-content {
            margin-left: 0;
        }
        .page-title-box {
            padding: 20px 0;
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
        }
        .card-body {
            padding: 2rem;
        }
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #5a5c69;
        }
        .text-danger {
            color: #e74a3b !important;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        .btn-secondary {
            background-color: #858796;
            border-color: #858796;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }
        h5 {
            color: #4e73df;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
        }
        h4 {
            color: #5a5c69;
            font-weight: 700;
        }
        .form-control {
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            padding: 0.75rem;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        .invalid-feedback {
            font-size: 0.875rem;
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .page-content {
                margin-left: 250px; /* Adjust this value based on your sidebar width */
            }
        }

        @media (max-width: 767.98px) {
            .page-content {
                margin-left: 0;
                padding: 15px;
            }
            .card-body {
                padding: 1.5rem;
            }
            .page-title-box {
                padding: 15px 0;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        @include('components.sidebar')
        
        <div class="page-content">
            <div class="container-fluid">
              
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('clients.store') }}" method="POST" id="clientForm">
                                    @csrf
                                    
                                    <!-- Personal Information -->
                                    <div class="row mb-4">
                                        <h5 class="mb-3">Personal Information</h5>
                                        
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('firstName') is-invalid @enderror" 
                                                    id="firstName" name="firstName" value="{{ old('firstName') }}" required>
                                                @error('firstName')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="middleName" class="form-label">Middle Name</label>
                                                <input type="text" class="form-control @error('middleName') is-invalid @enderror" 
                                                    id="middleName" name="middleName" value="{{ old('middleName') }}">
                                                @error('middleName')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('lastName') is-invalid @enderror" 
                                                    id="lastName" name="lastName" value="{{ old('lastName') }}" required>
                                                @error('lastName')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Contact Information -->
                                    <div class="row mb-4">
                                        <h5 class="mb-3">Contact Information</h5>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                    id="email" name="email" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                    id="phone" name="phone" value="{{ old('phone') }}" required
                                                    pattern="[0-9]{11}" placeholder="09123456789">
                                                @error('phone')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Address Information -->
                                    <div class="row mb-4">
                                        <h5 class="mb-3">Address Information</h5>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Street Address <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                                    id="address" name="address" value="{{ old('address') }}" required>
                                                @error('address')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                                    id="city" name="city" value="{{ old('city') }}" required>
                                                @error('city')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                                    id="province" name="province" value="{{ old('province') }}" required>
                                                @error('province')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="postalCode" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('postalCode') is-invalid @enderror" 
                                                    id="postalCode" name="postalCode" value="{{ old('postalCode') }}" 
                                                    required pattern="[0-9]{4}">
                                                @error('postalCode')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Information -->
                                    <div class="row mb-4">
                                        <h5 class="mb-3">Additional Information</h5>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="birthDate" class="form-label">Birth Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('birthDate') is-invalid @enderror" 
                                                    id="birthDate" name="birthDate" value="{{ old('birthDate') }}" required>
                                                @error('birthDate')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="occupation" class="form-label">Occupation <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('occupation') is-invalid @enderror" 
                                                    id="occupation" name="occupation" value="{{ old('occupation') }}" required>
                                                @error('occupation')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Save Client</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Phone number formatting
            const phoneInput = document.getElementById('phone');
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) {
                    value = value.substr(0, 11);
                }
                e.target.value = value;
            });

            // Postal code formatting
            const postalInput = document.getElementById('postalCode');
            postalInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 4) {
                    value = value.substr(0, 4);
                }
                e.target.value = value;
            });

            // Form validation
            const form = document.getElementById('clientForm');
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            // Adjust layout based on sidebar state
            function adjustLayout() {
                const sidebar = document.querySelector('.sidebar');
                const pageContent = document.querySelector('.page-content');
                
                if (sidebar && sidebar.classList.contains('collapsed')) {
                    pageContent.classList.add('sidebar-collapsed');
                } else {
                    pageContent.classList.remove('sidebar-collapsed');
                }
            }

            // Check for sidebar state changes
            const observer = new MutationObserver(adjustLayout);
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
            }
        });
    </script>
</body>
</html>