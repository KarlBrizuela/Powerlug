<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walk-in Details - Powerlug</title>
    <style>
        :root {
            --sidebar-width: 250px;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .page-content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
        }

        .page-content {
            padding: 20px;
            min-height: calc(100vh - 70px);
        }

        .page-title-box {
            margin-bottom: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
        }

        @media (max-width: 768px) {
            .page-content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
@include('components.sidebar')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Walk-in Details</h4>
                        <div>
                            <a href="{{ route('walk-in.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Basic Information</h6>
                                    <dl class="row mb-4">
                                        <dt class="col-sm-4">Walk-in No.</dt>
                                        <dd class="col-sm-8">{{ $walkIn->walkin_number }}</dd>

                                        <dt class="col-sm-4">Name</dt>
                                        <dd class="col-sm-8">{{ $walkIn->insured_name }}</dd>

                                        <dt class="col-sm-4">Unit</dt>
                                        <dd class="col-sm-8">{{ $walkIn->unit }}</dd>

                                        <dt class="col-sm-4">Plate Number</dt>
                                        <dd class="col-sm-8">{{ $walkIn->plate_number }}</dd>

                                        <dt class="col-sm-4">Address</dt>
                                        <dd class="col-sm-8">{{ $walkIn->address }}</dd>

                                        <dt class="col-sm-4">Contact</dt>
                                        <dd class="col-sm-8">{{ $walkIn->contact_number }}</dd>

                                        <dt class="col-sm-4">Email</dt>
                                        <dd class="col-sm-8">{{ $walkIn->email }}</dd>
                                    </dl>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Cost Details</h6>
                                    <dl class="row mb-4">
                                        <dt class="col-sm-4">Parts</dt>
                                        <dd class="col-sm-8">{{ number_format($walkIn->parts_amount ?? 0, 2) }}</dd>

                                        <dt class="col-sm-4">Labor Cost</dt>
                                        <dd class="col-sm-8">{{ number_format($walkIn->labor_cost ?? 0, 2) }}</dd>

                                        <dt class="col-sm-4">Materials</dt>
                                        <dd class="col-sm-8">{{ number_format($walkIn->materials_cost ?? 0, 2) }}</dd>

                                        <dt class="col-sm-4">VAT</dt>
                                        <dd class="col-sm-8">{{ number_format($walkIn->vat_amount ?? 0, 2) }}</dd>

                                        <dt class="col-sm-4">Total</dt>
                                        <dd class="col-sm-8"><strong>{{ number_format($walkIn->total_amount ?? 0, 2) }}</strong></dd>

                                        <dt class="col-sm-4">Payment Type</dt>
                                        <dd class="col-sm-8">{{ ucfirst(str_replace('_', ' ', $walkIn->payment_type ?? 'N/A')) }}</dd>
                                    </dl>
                                </div>
                            </div>

                            <hr>

                            <h6 class="text-muted mb-3">File</h6>
                            <div class="d-flex gap-2 align-items-center">
                                @if($walkIn->file_path)
                                    <a href="{{ route('walk-in.download', $walkIn) }}" class="btn btn-primary">
                                        <i class="fas fa-download me-1"></i> Download File
                                    </a>
                                    <form action="{{ route('walk-in.deleteFile', $walkIn->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this file?')">
                                            <i class="fas fa-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted"><i class="fas fa-inbox me-2"></i>No file uploaded</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
