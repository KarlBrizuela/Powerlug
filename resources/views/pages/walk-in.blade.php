@extends('layouts.app')

@section('title', 'Walk-Ins List - Powerlug')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Walk-Ins List</h4>
                    <a href="{{ route('walk-in.create') }}" class="btn btn-primary">New Walk-In</a>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Walk-In Number</th>
                                        <th>Insured Name</th>
                                        <th>Plate Number</th>
                                        <th>Contact Number</th>
                                        <th>Total Amount</th>
                                        <th>Payment Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($walkIns as $walkIn)
                                        <tr>
                                            <td>{{ $walkIn->walkin_number }}</td>
                                            <td>{{ $walkIn->insured_name }}</td>
                                            <td>{{ $walkIn->plate_number }}</td>
                                            <td>{{ $walkIn->contact_number }}</td>
                                            <td>₱{{ number_format($walkIn->total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $walkIn->payment_type == 'full_payment' ? 'success' : 'warning' }}">
                                                    {{ $walkIn->formatted_payment_type }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $walkIn->status == 'completed' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($walkIn->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $walkIn->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('walk-ins.show', $walkIn) }}" class="btn btn-sm btn-info">View</a>
                                                    <a href="{{ route('walk-ins.edit', $walkIn) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('walk-ins.destroy', $walkIn) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No walk-ins found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $walkIns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © Powerlug.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by <a href="#!" class="text-decoration-underline">Intracode</a>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection