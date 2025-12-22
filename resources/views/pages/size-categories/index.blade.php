<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Size Categories Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    @include('components.sidebar')
    
    <!-- Main Content Area -->
    <div class="main-content">
        <div class="container-fluid p-3">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 text-primary mb-0">Size Categories Management</h1>
                <a href="{{ route('size-categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Size Category
                </a>
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

            <!-- Size Categories Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 text-dark">All Size Categories</h5>
                </div>
                <div class="card-body p-0">
                    <!-- Size Categories Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 py-3 fw-semibold text-dark">Category Name</th>
                                    <th class="py-3 fw-semibold text-dark">Description</th>
                                    <th class="py-3 fw-semibold text-dark text-center">Services Count</th>
                                    <th class="pe-4 py-3 fw-semibold text-dark text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sizeCategories as $category)
                                    <tr class="border-top">
                                        <td class="ps-4 py-3">
                                            <div class="fw-medium text-dark">{{ $category->name }}</div>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-muted">{{ $category->description ?? 'N/A' }}</span>
                                        </td>
                                        <td class="py-3 text-center">
                                            <span class="badge bg-info">{{ $category->services()->count() }}</span>
                                        </td>
                                        <td class="pe-4 py-3">
                                            <div class="d-flex justify-content-end gap-2">
                                                <!-- Edit Button -->
                                                <a href="{{ route('size-categories.edit', $category) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil-square me-1"></i>
                                                    Edit
                                                </a>
                                                
                                                <!-- Delete Form -->
                                                <form action="{{ route('size-categories.destroy', $category) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete {{ $category->name }}?');">
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
                                                <h5 class="fw-semibold">No Size Categories Found</h5>
                                                <p class="mb-0">Get started by adding your first size category.</p>
                                                <a href="{{ route('size-categories.create') }}" class="btn btn-primary mt-3">
                                                    Add Your First Size Category
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
            @if($sizeCategories->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    <nav aria-label="Size categories pagination">
                        {{ $sizeCategories->links() }}
                    </nav>
                </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
