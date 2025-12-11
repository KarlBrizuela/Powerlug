<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <!-- Main Layout Wrapper - assuming your sidebar component handles the flex layout -->
    @include('components.sidebar')
    
    <!-- Main Content Area - this will be positioned by your sidebar component -->
    <div class="main-content">
        <div class="container-fluid p-3">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 text-primary mb-0">Services Management</h1>
                <div>
                    <a href="{{ route('services.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Service
                    </a>
                    <a href="{{ route('services.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Export to Excel
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Services Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">All Services</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Services Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 py-3 fw-semibold text-dark">Service Name</th>
                                    <th class="py-3 fw-semibold text-dark">Price</th>
                                    <th class="py-3 fw-semibold text-dark">Duration</th>
                                    <th class="pe-4 py-3 fw-semibold text-dark text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                    <tr class="border-top">
                                        <td class="ps-4 py-3">
                                            <div class="fw-medium text-dark">{{ $service->name }}</div>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-success fw-semibold">₱{{ number_format($service->price, 2) }}</span>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-muted">{{ $service->duration ?? '0' }} min</span>
                                        </td>
                                        <td class="pe-4 py-3">
                                            <div class="d-flex justify-content-end gap-2">
                                                <!-- Edit Button -->
                                                <a href="{{ route('services.edit', $service) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil-square me-1"></i>
                                                    Edit
                                                </a>
                                                
                                                <!-- Delete Form -->
                                                <form action="{{ route('services.destroy', $service) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete {{ $service->name }}? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash me-1"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                                <h5 class="fw-semibold">No Services Found</h5>
                                                <p class="mb-0">Get started by adding your first service.</p>
                                                <a href="{{ route('services.create') }}" class="btn btn-primary mt-3">
                                                    Add Your First Service
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if($services->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    <nav aria-label="Services pagination">
                        {{ $services->links() }}
                    </nav>
                </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Optional: Add confirmation for delete actions
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading state to buttons
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitButton = this.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.innerHTML = '<i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-1"></i> Processing...';
                        submitButton.disabled = true;
                    }
                });
            });
        });
    </script>
</body>
</html>