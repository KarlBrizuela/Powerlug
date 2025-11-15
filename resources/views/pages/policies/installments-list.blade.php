<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installments - {{ $policy->policy_number }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* Sidebar compatibility styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }

        .badge {
            font-size: 0.75em;
        }

        .payment-card {
            border-left: 4px solid #0d6efd;
            transition: all 0.3s;
        }

        .payment-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .amount-large {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    @include('components.sidebar')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h2 class="page-title">Installment Payments</h2>
                    <p class="text-muted">Policy <strong>{{ $policy->policy_number }}</strong></p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('policies.installment', $policy->id) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Installment
                    </a>
                    <a href="{{ route('policies.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Payment Summary -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-muted small">Total Paid</div>
                            <div class="amount-large">₱ {{ number_format($policy->paid_amount ?? 0, 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-muted small">Amount Due</div>
                            <div class="amount-large text-danger">₱ {{ number_format($policy->amount_due ?? 0, 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-muted small">Outstanding</div>
                            <div class="amount-large text-warning">₱ {{ number_format(($policy->amount_due ?? 0) - ($policy->paid_amount ?? 0), 2) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-muted small">Total Installments</div>
                            <div class="amount-large text-info">{{ $installments->total() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Installments List -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Payment Records</h5>
                </div>
                <div class="card-body">
                    @if ($installments->count() > 0)
                        <div class="row">
                            @foreach ($installments as $inst)
                                <div class="col-md-6 mb-3">
                                    <div class="card payment-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h5 class="card-title mb-0">₱ {{ number_format($inst->amount, 2) }}</h5>
                                                    <small class="text-muted">{{ optional($inst->payment_date)->format('F d, Y') }}</small>
                                                </div>
                                                <span class="badge bg-primary">{{ $inst->payment_method }}</span>
                                            </div>

                                            @if($inst->reference_number)
                                                <div class="mb-2">
                                                    <strong>Reference:</strong> {{ $inst->reference_number }}
                                                </div>
                                            @endif

                                            @if($inst->remarks)
                                                <div class="mb-2">
                                                    <strong>Remarks:</strong>
                                                    <p class="text-muted small mb-0">{{ $inst->remarks }}</p>
                                                </div>
                                            @endif

                                            <div class="border-top pt-2 mt-3">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i> {{ optional($inst->created_at)->diffForHumans() }}
                                                    @if($inst->creator)
                                                        <br>
                                                        <i class="fas fa-user"></i> Recorded by {{ $inst->creator->name ?? 'N/A' }}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($installments->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $installments->links() }}
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info text-center py-5">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <p class="mb-0">No installments recorded yet. <a href="{{ route('policies.installment', $policy->id) }}">Add one now</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
