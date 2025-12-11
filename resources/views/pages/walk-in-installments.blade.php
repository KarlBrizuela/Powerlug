<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installments - {{ $walkIn->walkin_number }}</title>
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

        .stat-card {
            padding: 1.5rem;
            border-radius: 0.375rem;
            text-align: center;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 600;
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
                    <p class="text-muted">Walk-in <strong>{{ $walkIn->walkin_number }}</strong></p>
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInstallmentModal">
                        <i class="fas fa-plus"></i> Add Payment
                    </button>
                    <a href="{{ route('walk-in.index') }}" class="btn btn-secondary">
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
                    <div class="card stat-card">
                        <div class="stat-label">Total Amount Due</div>
                        <div class="stat-value text-primary">₱ {{ number_format($walkIn->total_amount ?? 0, 2) }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="stat-label">Total Paid</div>
                        <div class="stat-value text-success">₱ {{ number_format($walkIn->paid_amount ?? 0, 2) }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="stat-label">Outstanding</div>
                        <div class="stat-value text-warning">₱ {{ number_format(($walkIn->total_amount ?? 0) - ($walkIn->paid_amount ?? 0), 2) }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="stat-label">Total Payments</div>
                        <div class="stat-value text-info">{{ $installments->total() }}</div>
                    </div>
                </div>
            </div>

            <!-- Payment Status Badge -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-light border-left-primary" role="alert" style="border-left: 4px solid #0d6efd;">
                        <strong>Status:</strong>
                        @if($walkIn->status === 'completed')
                            <span class="badge bg-success ms-2">Fully Paid</span>
                        @elseif($walkIn->status === 'pending')
                            <span class="badge bg-warning ms-2">Pending Payment</span>
                        @else
                            <span class="badge bg-secondary ms-2">{{ ucfirst($walkIn->status) }}</span>
                        @endif
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
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Payment Date</th>
                                        <th>Method</th>
                                        <th>Reference #</th>
                                        <th>Remarks</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($installments as $inst)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="fw-bold text-primary">
                                                    ₱ {{ number_format($inst->amount, 2) }}
                                                </span>
                                            </td>
                                            <td>{{ optional($inst->payment_date)->format('F d, Y') ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $inst->payment_method)) }}</span>
                                            </td>
                                            <td>{{ $inst->reference_number ?? '-' }}</td>
                                            <td>{{ $inst->remarks ?? '-' }}</td>
                                            <td>{{ $inst->creator->name ?? 'System' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                            <p>No payment records yet. <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#addInstallmentModal">Record your first payment</button></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Installment Modal -->
    <div class="modal fade" id="addInstallmentModal" tabindex="-1" aria-labelledby="addInstallmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInstallmentModalLabel">Record Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('walk-in.storeInstallment', $walkIn->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                       id="amount" name="amount" step="0.01" min="0.01" 
                                       value="{{ old('amount') }}" required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                                   id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                            @error('payment_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" 
                                    id="payment_method" name="payment_method" required>
                                <option value="">-- Select Method --</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="reference_number" class="form-label">Reference Number</label>
                            <input type="text" class="form-control @error('reference_number') is-invalid @enderror" 
                                   id="reference_number" name="reference_number" value="{{ old('reference_number') }}">
                            @error('reference_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Record Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
