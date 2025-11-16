<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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

        .card-header {
            border-bottom: 1px solid #dee2e6;
        }

        /* Sidebar layout adjustments */
        .main-content {
            margin-left: 250px; /* Adjust based on your sidebar width */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }

        /* Ensure content doesn't overflow */
        .container-fluid {
            padding-left: 0;
            padding-right: 0;
        }
    </style>
</head>
<body>
    @include('components.sidebar')
    
    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h2 class="page-title">Policy Details</h2>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('policies.edit', $policy->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('policies.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Policy Information</h5>
                        </div>
                        <div class="card-body">
                            @include('pages.policies._view', ['policy' => $policy])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Button -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <form action="{{ route('policies.destroy', $policy->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this policy?')">
                            <i class="fas fa-trash"></i> Delete Policy
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Optional: Add sidebar toggle functionality if needed
        document.addEventListener('DOMContentLoaded', function() {
            // You can add sidebar toggle logic here if your sidebar is collapsible
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    mainContent.classList.toggle('sidebar-collapsed');
                });
            }
        });
    </script>
</body>
</html>