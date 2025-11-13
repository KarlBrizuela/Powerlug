@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Freebies</h2>
        <a href="{{ route('freebies.create') }}" class="btn btn-primary">Create Freebie</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
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
                                    <div class="text-muted small">{{ optional($f->start_date)->toDateString() }} → {{ optional($f->end_date)->toDateString() }}</div>
                                @endif
                            </td>
                            <td>{{ $f->is_active ? 'Yes' : 'No' }}</td>
                            <td class="text-end">
                                <a href="{{ route('freebies.edit', $f->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('freebies.destroy', $f->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete freebie?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $freebies->links() }}
        </div>
    </div>
</div>

@endsection
