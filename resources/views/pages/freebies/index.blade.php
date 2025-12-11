<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freebies Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .main-content {
            margin-left: 280px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('components.sidebar')
        
        <!-- Main content -->
        <main class="main-content flex-grow-1">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Freebies</h2>
                    <div>
                        <a href="{{ route('freebies.create') }}" class="btn btn-primary">Create Freebie</a>
                        <a href="{{ route('freebies.export') }}" class="btn btn-success">
                            <i class="fas fa-download"></i> Export to Excel
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Unit</th>
                                        <th>Service</th>
                                        <th>Schedule</th>
                                        <th>Active</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($freebies as $f)
                                        <tr>
                                            <td>{{ $f->name }}</td>
                                            <td>{{ $f->unit }}</td>
                                            <td>{{ $f->service }}</td>
                                            <td>
                                                {{ $f->schedule_type }}
                                                @if(is_array($f->schedule_value))
                                                    <div class="text-muted small">{{ implode(', ', $f->schedule_value) }}</div>
                                                @endif
                                                @if($f->start_date || $f->end_date)
                                                    <div class="text-muted small">
                                                        {{ optional($f->start_date)->toDateString() }} 
                                                        @if($f->end_date)
                                                            → {{ optional($f->end_date)->toDateString() }}
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $f->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $f->is_active ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('freebies.edit', $f->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                    <form action="{{ route('freebies.destroy', $f->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this freebie?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if($freebies->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $freebies->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>