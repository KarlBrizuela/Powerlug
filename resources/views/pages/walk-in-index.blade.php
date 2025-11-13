<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Walk-ins List - Powerlug</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Powerlug" name="description" />
    <meta content="Powerlug" name="author" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .vertical-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            z-index: 1001;
            background: #ffffff;
            border-right: 1px solid #e9ecef;
            padding-top: 0;
        }

        #layout-wrapper {
            margin-left: 250px;
            min-height: 100vh;
            width: calc(100% - 250px);
        }

        .page-content {
            padding: 30px;
            margin: 0;
            width: 100%;
        }

        @media (max-width: 992px) {
            .vertical-menu {
                display: none;
            }
            #layout-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }

        .page-title-box {
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
            border-radius: 8px;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
        }

        .table td {
            vertical-align: middle;
            padding: 12px;
        }

        .btn {
            border-radius: 4px;
            padding: 8px 16px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .btn-group {
            gap: 5px;
        }

        .text-muted {
            color: #6c757d;
        }
    </style>
</head>
<body>
@include('components.sidebar')

<div id="layout-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Walk-ins</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('walk-in.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> New Walk-in
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Walk-in No.</th>
                                            <th>Name</th>
                                            <th>Unit</th>
                                            <th>Plate Number</th>
                                            <th>Total Amount</th>
                                            <th>Payment Type</th>
                                            <th>Actions</th>
                                            <th>Date Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($walkIns as $walkIn)
                                            <tr>
                                                <td>{{ $walkIn->id }}</td>
                                                <td>{{ $walkIn->walkin_number }}</td>
                                                <td>{{ $walkIn->insured_name }}</td>
                                                <td>{{ $walkIn->unit }}</td>
                                                <td>{{ $walkIn->plate_number }}</td>
                                                <td>{{ number_format($walkIn->total_amount ?? 0, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $walkIn->payment_type ?? 'N/A')) }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Actions">
                                                        <a href="{{ route('walk-in.show', $walkIn) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                            <i class="bi bi-eye"></i>
                                                        </a>

                                                        @if($walkIn->file_path)
                                                            <a href="{{ route('walk-in.download', $walkIn) }}" class="btn btn-sm btn-outline-success" title="Download">
                                                                <i class="bi bi-download"></i>
                                                            </a>
                                                        @endif

                                                        <form action="{{ route('walk-in.destroy', $walkIn) }}" method="POST" onsubmit="return confirm('Delete this walk-in?');" style="display:inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>{{ $walkIn->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    No walk-ins found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($walkIns->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $walkIns->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
