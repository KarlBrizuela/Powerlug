<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Client - Powerlug</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        
        /* Sidebar layout */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
        
        /* Card styling */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .card-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #007bff;
            padding-bottom: 0.5rem;
        }
        
        /* Form styling */
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            font-size: 0.95rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        /* Section styles */
        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }
        
        /* Button styling */
        .btn {
            border-radius: 0.375rem;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        
        /* Page header */
        h3 {
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
        }
        
        .page-title-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        /* Alert styling */
        .alert {
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    @include('components.sidebar')
    
    <div class="main-content">
        <div class="container py-4">
            <div class="page-title-box">
                <h3>
                    <i class="fas fa-user-plus me-2"></i> Create New Client
                </h3>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Please fix the following errors:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Client Information</h5>
                    
                    <form action="{{ route('clients.store') }}" method="POST" novalidate class="needs-validation">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="section-title">Personal Information</div>
                        
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('firstName') is-invalid @enderror" 
                                       name="firstName" value="{{ old('firstName') }}" placeholder="Enter first name" required>
                                @error('firstName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" class="form-control @error('middleName') is-invalid @enderror" 
                                       name="middleName" value="{{ old('middleName') }}" placeholder="Enter middle name">
                                @error('middleName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lastName') is-invalid @enderror" 
                                       name="lastName" value="{{ old('lastName') }}" placeholder="Enter last name" required>
                                @error('lastName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">TIN</label>
                                <input type="text" class="form-control @error('tin') is-invalid @enderror" 
                                       name="tin" value="{{ old('tin') }}" placeholder="Enter TIN">
                                @error('tin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="section-title">Contact Information</div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Address Information -->
                        <div class="section-title">Address Information</div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Street Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                       name="address" value="{{ old('address') }}" placeholder="Enter street address" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       name="city" value="{{ old('city') }}" placeholder="Enter city" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Province <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('province') is-invalid @enderror" 
                                       name="province" value="{{ old('province') }}" placeholder="Enter province" required>
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('postalCode') is-invalid @enderror" 
                                       name="postalCode" value="{{ old('postalCode') }}" placeholder="Enter postal code" required>
                                @error('postalCode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Vehicle Information -->
                        <div class="section-title">
                            Vehicle Information
                            <button type="button" class="btn btn-sm btn-success float-end" id="addCarBtn">
                                <i class="fas fa-plus me-2"></i>Add Car
                            </button>
                        </div>
                        
                        <div id="vehiclesContainer">
                            <!-- Vehicle rows will be added here -->
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-redo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Client
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        }());

        // Vehicle management
        let vehicleRowCount = 0;

        function addVehicleRow(makeModel = '', plateNumber = '', modelYear = '', color = '') {
            const container = document.getElementById('vehiclesContainer');
            const rowId = 'vehicle-row-' + vehicleRowCount++;
            
            const row = document.createElement('div');
            row.id = rowId;
            row.className = 'row mb-3 p-3 border rounded bg-light vehicle-row';
            row.innerHTML = `
                <div class="col-md-3">
                    <label class="form-label">Make & Model</label>
                    <input type="text" class="form-control" 
                           name="vehicles[${vehicleRowCount - 1}][make_model]" 
                           value="${makeModel}" 
                           placeholder="Enter vehicle make and model">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Plate Number</label>
                    <input type="text" class="form-control" 
                           name="vehicles[${vehicleRowCount - 1}][plate_number]" 
                           value="${plateNumber}" 
                           placeholder="Enter plate number">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Model Year</label>
                    <input type="text" class="form-control" 
                           name="vehicles[${vehicleRowCount - 1}][model_year]" 
                           value="${modelYear}" 
                           placeholder="e.g., 2020">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Color</label>
                    <input type="text" class="form-control" 
                           name="vehicles[${vehicleRowCount - 1}][color]" 
                           value="${color}" 
                           placeholder="Enter vehicle color">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger w-100" onclick="removeVehicleRow('${rowId}')">
                        <i class="fas fa-trash me-2"></i>Remove
                    </button>
                </div>
            `;
            
            container.appendChild(row);
        }

        function removeVehicleRow(rowId) {
            const row = document.getElementById(rowId);
            if (row) {
                row.remove();
            }
        }

        // Add Car button event listener
        document.getElementById('addCarBtn').addEventListener('click', function(e) {
            e.preventDefault();
            addVehicleRow();
        });

        // Initialize with one empty vehicle row on page load
        window.addEventListener('load', function() {
            addVehicleRow();
        });
    </script>
</body>
</html>
