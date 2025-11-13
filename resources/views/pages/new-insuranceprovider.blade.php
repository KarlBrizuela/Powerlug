<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Insurance Provider - Powerlug</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .main-content-wrapper {
            margin-left: 250px;
            min-height: 100vh;
            background-color: #f8f9fa;
            transition: margin-left 0.3s;
        }

        .page-content {
            padding: 20px;
            min-height: calc(100vh - 120px);
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .main-content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="main-content-wrapper">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">New Insurance Provider</h1>
                    <a href="{{ route('insurance-providers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('insurance-providers.store') }}" method="POST">
                                    @csrf
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Provider Code*</label>
                                            <input type="text" 
                                                   class="form-control @error('code') is-invalid @enderror" 
                                                   name="code" 
                                                   value="{{ old('code') }}" 
                                                   placeholder="e.g., HGI-001"
                                                   required>
                                            @error('code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Provider Name*</label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   name="name" 
                                                   value="{{ old('name') }}" 
                                                   placeholder="e.g., Standard Insurance"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       name="is_active" 
                                                       id="is_active" 
                                                       value="1" 
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Active Status
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Banks (one per line or comma separated)</label>
                                            <textarea name="banks" class="form-control" rows="4" placeholder="e.g. BDO, Metrobank, BPI">{{ old('banks') }}</textarea>
                                            <div class="form-text">Enter banks associated with this provider. These will be used to populate bank transfer options.</div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <a href="{{ route('insurance-providers.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Save Provider
                                        </button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>