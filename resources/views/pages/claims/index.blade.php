@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Claims</h4>
        <a href="{{ route('claims.create') }}" class="btn btn-primary">New Claim</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Claim No.</th>
                            <th>Total</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($claims as $claim)
                            <tr>
                                <td>{{ $claim->id }}</td>
                                <td>{{ $claim->date_of_claim?->format('Y-m-d') }}</td>
                                <td>{{ $claim->client_name }}</td>
                                <td>{{ $claim->claim_number }}</td>
                                <td>{{ number_format($claim->total_amount ?? 0, 2) }}</td>
                                <td>{{ $claim->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="actions">
                                        <a href="{{ route('claims.show', $claim) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        @if($claim->file_path)
                                            <a href="{{ route('claims.download', $claim) }}" class="btn btn-sm btn-outline-secondary">Download</a>
                                        @endif
                                        <form method="POST" action="{{ route('claims.destroy', $claim) }}" style="display:inline" onsubmit="return confirm('Delete this claim?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $claims->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
