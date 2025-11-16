<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Details - Powerlug</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }

        .page-content {
            padding: 20px 0;
            margin-left: 250px;
            background-color: #f8f9fa;
        }

        /* Page Header */
        .page-title-box {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
        }
        
        .page-title-box h4 {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            background: #fff;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #007bff;
            display: inline-block;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .info-value {
            margin-bottom: 1.25rem;
            color: #6c757d;
        }

        /* JSON Viewer */
        .json-viewer {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            max-height: 400px;
            overflow-y: auto;
        }

        /* Data Table */
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .data-table {
            margin-bottom: 0;
            border: none;
        }

        .data-table thead th {
            background-color: #fff;
            font-weight: 600;
            text-transform: capitalize;
            width: 30%;
            color: #495057;
            border: none;
            padding: 1rem;
            font-size: 0.875rem;
        }

        .data-table tbody td,
        .data-table tbody th {
            word-break: break-word;
            border-top: 1px solid #f0f0f0;
            padding: 1rem;
            color: #495057;
        }
        
        .data-table tbody tr {
            transition: background-color 0.2s;
        }
        
        .data-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Diff Styling */
        .diff-removed {
            background-color: #ffebe9;
            color: #d73a49;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 500;
        }

        .diff-added {
            background-color: #e6ffec;
            color: #22863a;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 500;
        }

        .null-value {
            color: #999;
            font-style: italic;
        }

        .json-string {
            color: #22863a;
        }

        .json-number {
            color: #005cc5;
        }

        .json-boolean {
            color: #d73a49;
        }

        /* Badge Styling */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* Button Styling */
        .btn {
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
            border: none;
        }
        
        .btn-primary {
            background: #007bff;
        }
        
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,123,255,0.3);
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }

        /* Divider */
        hr {
            margin: 2rem 0;
            border-top: 2px solid #e9ecef;
        }

        @media (max-width: 768px) {
            .page-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    @include('components.sidebar')
    
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Audit Trail Details</h4>
                        <a href="{{ route('audit-trail.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Audit Trail
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Activity Information</h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-label">User</div>
                                    <div class="info-value">
                                        <i class="fas fa-user me-2"></i>{{ $audit->user->name ?? 'System' }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Action</div>
                                    <div class="info-value">
                                        <span class="badge bg-{{ $audit->getActionColor() }} px-3 py-2">
                                            {{ ucfirst($audit->action) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-label">Module/Table</div>
                                    <div class="info-value">
                                        <span class="badge bg-secondary px-3 py-2">{{ $audit->module }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Record ID</div>
                                    <div class="info-value">
                                        <code>{{ $audit->record_id ?? 'N/A' }}</code>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="info-label">Description</div>
                                    <div class="info-value">{{ $audit->description }}</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-label">IP Address</div>
                                    <div class="info-value">
                                        <i class="fas fa-network-wired me-2"></i>{{ $audit->ip_address ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Date & Time</div>
                                    <div class="info-value">
                                        <i class="fas fa-clock me-2"></i>{{ $audit->created_at->format('F d, Y h:i:s A') }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="info-label">User Agent</div>
                                    <div class="info-value">
                                        <small class="text-muted">{{ $audit->user_agent ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            @if($audit->action === 'updated')
                                <h5 class="card-title mb-4">Changes Made</h5>
                                
                                @php
                                    $oldValues = json_decode($audit->old_values, true) ?? [];
                                    $newValues = json_decode($audit->new_values, true) ?? [];
                                    $allKeys = array_unique(array_merge(array_keys($oldValues), array_keys($newValues)));
                                @endphp
                                
                                <div class="table-responsive">
                                    <table class="table data-table">
                                        <thead>
                                            <tr>
                                                <th>Field</th>
                                                <th><i class="fas fa-minus-circle text-danger me-2"></i>Old Value</th>
                                                <th><i class="fas fa-plus-circle text-success me-2"></i>New Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($allKeys as $key)
                                                @php
                                                    $oldVal = $oldValues[$key] ?? null;
                                                    $newVal = $newValues[$key] ?? null;
                                                    $changed = $oldVal != $newVal;
                                                @endphp
                                                @if($changed)
                                                    <tr>
                                                        <th>{{ str_replace('_', ' ', $key) }}</th>
                                                        <td>
                                                            @if(is_null($oldVal))
                                                                <span class="null-value">null</span>
                                                            @elseif(is_array($oldVal))
                                                                <code>{{ json_encode($oldVal) }}</code>
                                                            @elseif(is_bool($oldVal))
                                                                <span class="json-boolean">{{ $oldVal ? 'true' : 'false' }}</span>
                                                            @elseif(is_numeric($oldVal))
                                                                <span class="json-number">{{ $oldVal }}</span>
                                                            @else
                                                                <span class="diff-removed">{{ $oldVal }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(is_null($newVal))
                                                                <span class="null-value">null</span>
                                                            @elseif(is_array($newVal))
                                                                <code>{{ json_encode($newVal) }}</code>
                                                            @elseif(is_bool($newVal))
                                                                <span class="json-boolean">{{ $newVal ? 'true' : 'false' }}</span>
                                                            @elseif(is_numeric($newVal))
                                                                <span class="json-number">{{ $newVal }}</span>
                                                            @else
                                                                <span class="diff-added">{{ $newVal }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <h5 class="card-title mb-4">Data Snapshot</h5>
                                
                                @php
                                    $dataSnapshot = json_decode($audit->new_values, true) ?? [];
                                @endphp
                                
                                <div class="table-responsive">
                                    <table class="table data-table">
                                        <thead>
                                            <tr>
                                                <th>Field</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dataSnapshot as $key => $value)
                                                <tr>
                                                    <th>{{ str_replace('_', ' ', $key) }}</th>
                                                    <td>
                                                        @if(is_null($value))
                                                            <span class="null-value">null</span>
                                                        @elseif(is_array($value))
                                                            <code class="json-string">{{ json_encode($value) }}</code>
                                                        @elseif(is_bool($value))
                                                            <span class="json-boolean">{{ $value ? 'true' : 'false' }}</span>
                                                        @elseif(is_numeric($value))
                                                            <span class="json-number">{{ $value }}</span>
                                                        @elseif(filter_var($value, FILTER_VALIDATE_URL))
                                                            <a href="{{ $value }}" target="_blank" class="text-primary">{{ $value }}</a>
                                                        @elseif(filter_var($value, FILTER_VALIDATE_EMAIL))
                                                            <a href="mailto:{{ $value }}" class="text-primary">{{ $value }}</a>
                                                        @elseif(preg_match('/^\d{4}-\d{2}-\d{2}/', $value))
                                                            <span class="text-muted">
                                                                <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($value)->format('F d, Y') }}
                                                            </span>
                                                        @else
                                                            {{ $value }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('audit-trail.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to List
                                </a>
                                @if($audit->module && $audit->record_id)
                                    <a href="{{ route('audit-trail.index', ['module' => $audit->module, 'record_id' => $audit->record_id]) }}" class="btn btn-primary">
                                        <i class="fas fa-filter me-1"></i> View All Changes for This Record
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

