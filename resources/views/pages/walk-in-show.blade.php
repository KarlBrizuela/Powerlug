@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Walk-in Details</h5>
                    <div>
                        <a href="{{ route('walk-in.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <dl class="row">
                        <dt class="col-sm-3">Walk-in No.</dt>
                        <dd class="col-sm-9">{{ $walkIn->walkin_number }}</dd>

                        <dt class="col-sm-3">Name</dt>
                        <dd class="col-sm-9">{{ $walkIn->insured_name }}</dd>

                        <dt class="col-sm-3">Unit</dt>
                        <dd class="col-sm-9">{{ $walkIn->unit }}</dd>

                        <dt class="col-sm-3">Plate Number</dt>
                        <dd class="col-sm-9">{{ $walkIn->plate_number }}</dd>

                        <dt class="col-sm-3">Address</dt>
                        <dd class="col-sm-9">{{ $walkIn->address }}</dd>

                        <dt class="col-sm-3">Contact</dt>
                        <dd class="col-sm-9">{{ $walkIn->contact_number }}</dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">{{ $walkIn->email }}</dd>

                        <dt class="col-sm-3">Parts</dt>
                        <dd class="col-sm-9">{{ number_format($walkIn->parts_amount ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">Labor Cost</dt>
                        <dd class="col-sm-9">{{ number_format($walkIn->labor_cost ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">Materials</dt>
                        <dd class="col-sm-9">{{ number_format($walkIn->materials_cost ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">VAT</dt>
                        <dd class="col-sm-9">{{ number_format($walkIn->vat_amount ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">Total</dt>
                        <dd class="col-sm-9">{{ number_format($walkIn->total_amount ?? 0, 2) }}</dd>

                        <dt class="col-sm-3">Payment Type</dt>
                        <dd class="col-sm-9">{{ ucfirst(str_replace('_', ' ', $walkIn->payment_type ?? 'N/A')) }}</dd>

                        <dt class="col-sm-3">File</dt>
                        <dd class="col-sm-9">
                            @if($walkIn->file_path)
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="{{ route('walk-in.download', $walkIn) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-download"></i> Download File
                                    </a>
                                    <form action="{{ route('walk-in.deleteFile', $walkIn->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this file?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted">No file uploaded</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
