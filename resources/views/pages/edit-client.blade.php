<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client - Powerlug</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fc;
            overflow-x: hidden;
        }
        .page-wrapper {
            display: flex;
            min-height: 100vh;
        }
        /* Remove the sidebar styles - let your component handle it */
        .page-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px; /* Adjust this to match your sidebar width */
            transition: all 0.3s;
            min-width: 0;
        }
        /* If sidebar is collapsed */
        .sidebar-collapsed .page-content {
            margin-left: 80px; /* Adjust this to match your collapsed sidebar width */
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
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .page-wrapper {
                flex-direction: column;
            }
            .page-content {
                margin-left: 0 !important;
                padding: 15px;
            }
            .card-body {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .page-content {
                padding: 10px;
            }
            .card-body {
                padding: 1rem;
            }
            .page-title-box {
                flex-direction: column;
                align-items: flex-start !important;
            }
            .page-title-box .btn {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <!-- Sidebar - Your component handles its own styling -->
        @include('components.sidebar')

        <!-- Page Content -->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Client</h4>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <!-- Alert for Validation Errors -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Edit Client Form -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('clients.update', $client->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <!-- First Name -->
                                        <div class="col-md-4 mb-3">
                                            <label for="firstName" class="form-label">First Name</label>
                                            <input type="text" 
                                                   class="form-control @error('firstName') is-invalid @enderror" 
                                                   id="firstName" 
                                                   name="firstName" 
                                                   value="{{ old('firstName', $client->firstName) }}" 
                                                   required>
                                            @error('firstName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Middle Name -->
                                        <div class="col-md-4 mb-3">
                                            <label for="middleName" class="form-label">Middle Name</label>
                                            <input type="text" 
                                                   class="form-control @error('middleName') is-invalid @enderror" 
                                                   id="middleName" 
                                                   name="middleName" 
                                                   value="{{ old('middleName', $client->middleName) }}">
                                            @error('middleName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-md-4 mb-3">
                                            <label for="lastName" class="form-label">Last Name</label>
                                            <input type="text" 
                                                   class="form-control @error('lastName') is-invalid @enderror" 
                                                   id="lastName" 
                                                   name="lastName" 
                                                   value="{{ old('lastName', $client->lastName) }}" 
                                                   required>
                                            @error('lastName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- TIN -->
                                        <div class="col-md-12 mb-3">
                                            <label for="tin" class="form-label">TIN (Tax Identification Number)</label>
                                            <input type="text" 
                                                   class="form-control @error('tin') is-invalid @enderror" 
                                                   id="tin" 
                                                   name="tin" 
                                                   value="{{ old('tin', $client->tin) }}">
                                            @error('tin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $client->email) }}" 
                                                   required>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Phone -->
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone', $client->phone) }}" 
                                                   required>
                                            @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Address -->
                                        <div class="col-md-12 mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" 
                                                   class="form-control @error('address') is-invalid @enderror" 
                                                   id="address" 
                                                   name="address" 
                                                   value="{{ old('address', $client->address) }}" 
                                                   required>
                                            @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- City -->
                                        <div class="col-md-4 mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" 
                                                   class="form-control @error('city') is-invalid @enderror" 
                                                   id="city" 
                                                   name="city" 
                                                   value="{{ old('city', $client->city) }}" 
                                                   required>
                                            @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Province -->
                                        <div class="col-md-4 mb-3">
                                            <label for="province" class="form-label">Province</label>
                                            <input type="text" 
                                                   class="form-control @error('province') is-invalid @enderror" 
                                                   id="province" 
                                                   name="province" 
                                                   value="{{ old('province', $client->province) }}" 
                                                   required>
                                            @error('province')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Postal Code -->
                                        <div class="col-md-4 mb-3">
                                            <label for="postalCode" class="form-label">Postal Code</label>
                                            <input type="text" 
                                                   class="form-control @error('postalCode') is-invalid @enderror" 
                                                   id="postalCode" 
                                                   name="postalCode" 
                                                   value="{{ old('postalCode', $client->postalCode) }}" 
                                                   required>
                                            @error('postalCode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Birth Date -->
                                        <div class="col-md-6 mb-3">
                                            <label for="birthDate" class="form-label">Birth Date</label>
                                            <input type="date" 
                                                   class="form-control @error('birthDate') is-invalid @enderror" 
                                                   id="birthDate" 
                                                   name="birthDate" 
                                                   value="{{ old('birthDate', $client->birthDate) }}" 
                                                   required>
                                            @error('birthDate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Occupation -->
                                        <div class="col-md-6 mb-3">
                                            <label for="occupation" class="form-label">Occupation</label>
                                            <input type="text" 
                                                   class="form-control @error('occupation') is-invalid @enderror" 
                                                   id="occupation" 
                                                   name="occupation" 
                                                   value="{{ old('occupation', $client->occupation) }}" 
                                                   required>
                                            @error('occupation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Make Model -->
                                        <div class="col-md-6 mb-3">
                                            <label for="make_model" class="form-label">Make Model</label>
                                            <input type="text" 
                                                   class="form-control @error('make_model') is-invalid @enderror" 
                                                   id="make_model" 
                                                   name="make_model" 
                                                   value="{{ old('make_model', $client->make_model) }}">
                                            @error('make_model')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Plate Number -->
                                        <div class="col-md-6 mb-3">
                                            <label for="plate_no" class="form-label">Plate Number</label>
                                            <input type="text" 
                                                   class="form-control @error('plate_no') is-invalid @enderror" 
                                                   id="plate_no" 
                                                   name="plate_no" 
                                                   value="{{ old('plate_no', $client->plate_no) }}">
                                            @error('plate_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Model Year -->
                                        <div class="col-md-6 mb-3">
                                            <label for="model_year" class="form-label">Model Year</label>
                                            <input type="number" 
                                                   class="form-control @error('model_year') is-invalid @enderror" 
                                                   id="model_year" 
                                                   name="model_year" 
                                                   value="{{ old('model_year', $client->model_year) }}"
                                                   min="1900"
                                                   max="2100">
                                            @error('model_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Color -->
                                        <div class="col-md-6 mb-3">
                                            <label for="color" class="form-label">Color</label>
                                            <input type="text" 
                                                   class="form-control @error('color') is-invalid @enderror" 
                                                   id="color" 
                                                   name="color" 
                                                   value="{{ old('color', $client->color) }}">
                                            @error('color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Vehicle Management Section -->
                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <h6 style="color: #495057; font-weight: 600; margin-bottom: 1rem;">
                                                Client Vehicles
                                                <button type="button" class="btn btn-sm btn-success float-end" id="addCarBtn">
                                                    <i class="fas fa-plus me-2"></i>Add Car
                                                </button>
                                            </h6>
                                            <div id="vehiclesContainer">
                                                <!-- Vehicle rows will be added here -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end mt-4">
                                        <a href="{{ route('clients.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update Client</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

        // Initialize with existing vehicles and one empty row for adding new vehicles
        window.addEventListener('load', function() {
            @if($client->vehicles->count() > 0)
                @foreach($client->vehicles as $vehicle)
                    addVehicleRow('{{ $vehicle->make_model }}', '{{ $vehicle->plate_number }}', '{{ $vehicle->model_year }}', '{{ $vehicle->color }}');
                @endforeach
            @else
                addVehicleRow();
            @endif
        });
    </script>
</body>
</html>