<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim #{{ $claim->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }
        .card-body {
            padding: 2rem;
        }
        dt {
            font-weight: 600;
            color: #495057;
        }
        dd {
            color: #6c757d;
        }
        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    @include('components.sidebar')
    
    <div class="main-content">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Claim #{{ $claim->id }}</h4>
                <a href="{{ route('claims.index') }}" class="btn btn-outline-secondary">Back to list</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Date of Claim</dt>
                        <dd class="col-sm-9">{{ $claim->date_of_claim?->format('Y-m-d') }}</dd>

                        <dt class="col-sm-3">Client</dt>
                        <dd class="col-sm-9">{{ $claim->client_name }}</dd>

                        <dt class="col-sm-3">Claim Number</dt>
                        <dd class="col-sm-9">{{ $claim->claim_number }}</dd>

                        <dt class="col-sm-3">LOA Amount</dt>
                        <dd class="col-sm-9">{{ number_format($claim->loa_amount ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">Participation</dt>
                        <dd class="col-sm-9">{{ number_format($claim->participation_amount ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">Deductible</dt>
                        <dd class="col-sm-9">{{ number_format($claim->deductible ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">Parts</dt>
                        <dd class="col-sm-9">{{ number_format($claim->parts ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">Labor Cost</dt>
                        <dd class="col-sm-9">{{ number_format($claim->labor_cost ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">Materials</dt>
                        <dd class="col-sm-9">{{ number_format($claim->materials ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">VAT</dt>
                        <dd class="col-sm-9">{{ number_format($claim->vat ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">Total</dt>
                        <dd class="col-sm-9">{{ number_format($claim->total_amount ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">File</dt>
                        <dd class="col-sm-9">
                            @if($claim->file_path)
                                <a href="{{ route('claims.download', $claim) }}">Download file</a>
                            @else
                                <span class="text-muted">No file uploaded</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>