<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Details - Powerlug</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        
        /* Text styling */
        p {
            margin-bottom: 0.75rem;
            line-height: 1.5;
        }
        
        strong {
            color: #495057;
        }
        
        .text-muted.small {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
        }
        
        /* Button styling */
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
    </style>
</head>
<body>
    @include('components.sidebar')
    
    <div class="main-content">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Client Details</h3>
                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back to List</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $client->firstName }} {{ $client->middleName }} {{ $client->lastName }}</h5>
                    <p class="mb-1"><strong>Email:</strong> {{ $client->email }}</p>
                    <p class="mb-1"><strong>Phone:</strong> {{ $client->phone }}</p>
                    <p class="mb-1"><strong>Address:</strong> {{ $client->address }}, {{ $client->city }}, {{ $client->province }} {{ $client->postalCode }}</p>
                    <p class="mb-1"><strong>Birth Date:</strong> {{ optional($client->birthDate)->format('Y-m-d') ?? $client->birthDate }}</p>
                    <p class="mb-1"><strong>Occupation:</strong> {{ $client->occupation }}</p>
                    <p class="text-muted small">Created at: {{ $client->created_at }} | Updated at: {{ $client->updated_at }}</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>