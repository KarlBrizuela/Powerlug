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
    
    <style>
        .page-content {
            padding: 20px 0;
            margin-left: 250px;
        }
        .card {
            border: none;
            box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 5px;
        }
        .info-value {
            margin-bottom: 15px;
        }
        .json-viewer {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            max-height: 400px;
            overflow-y: auto;
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
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">
                                            <i class="fas fa-minus-circle text-danger me-2"></i>Old Values
                                        </div>
                                        <div class="json-viewer">
                                            <pre class="mb-0"><code>{{ json_encode(json_decode($audit->old_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">
                                            <i class="fas fa-plus-circle text-success me-2"></i>New Values
                                        </div>
                                        <div class="json-viewer">
                                            <pre class="mb-0"><code>{{ json_encode(json_decode($audit->new_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <h5 class="card-title mb-4">Data Snapshot</h5>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="json-viewer">
                                            <pre class="mb-0"><code>{{ json_encode(json_decode($audit->new_values), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                        </div>
                                    </div>
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

