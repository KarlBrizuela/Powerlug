<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service - Services Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
        }
        .main-content {
            flex: 1;
            margin-left: 250px; /* Adjust based on your sidebar width */
            padding: 20px;
            transition: margin-left 0.3s;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    @include('components.Sidebar')
    
    <!-- Main Content Area -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 text-primary mb-0">Edit Service</h1>
                <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">Service Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('services.update', $service) }}" id="editServiceForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Name *</label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name', $service->name) }}" 
                                       class="form-control" 
                                       required
                                       placeholder="Enter service name">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" 
                                           step="0.01" 
                                           name="price" 
                                           value="{{ old('price', $service->price) }}" 
                                           class="form-control"
                                           placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Duration</label>
                                <input type="text" 
                                       name="duration" 
                                       value="{{ old('duration', $service->duration) }}" 
                                       class="form-control" 
                                       placeholder="e.g. 30 mins, 1 hour, Custom text">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" 
                                      class="form-control" 
                                      rows="4"
                                      placeholder="Enter service description">{{ old('description', $service->description) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Service</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form submission handling
            const form = document.getElementById('editServiceForm');
            const submitButton = form.querySelector('button[type="submit"]');
            
            form.addEventListener('submit', function(e) {
                // Show loading state
                if (submitButton) {
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
                    submitButton.disabled = true;
                }
            });

            // Price input formatting
            const priceInput = form.querySelector('input[name="price"]');
            if (priceInput) {
                priceInput.addEventListener('blur', function() {
                    if (this.value && !isNaN(this.value)) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });
            }
        });
    </script>
</body>
</html>