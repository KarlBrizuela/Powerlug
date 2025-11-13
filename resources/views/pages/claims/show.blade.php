@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Claim #{{ $claim->id }}</h4>
        <a href="{{ route('claims.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>

    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Date of Claim</dt>
                <dd class="col-sm-9">{{ $claim->date_of_claim?->format('Y-m-d') }}</dd>

                <dt class="col-sm-3">Client</dt>
                <dd class="col-sm-9">{{ $claim->client_name }}</dd>

                <dt class="col-sm-3">Claim Number</dt>
                <dd class="col-sm-9">{{ $claim->claim_number }}</dd>

                <dt class="col-sm-3">LOA Amount</dt>
                <dd class="col-sm-9">{{ number_format($claim->loa_amount ?? 0, 2) }}</dd>

                <dt class="col-sm-3">Participation</dt>
                <dd class="col-sm-9">{{ number_format($claim->participation_amount ?? 0, 2) }}</dd>

                <dt class="col-sm-3">Deductible</dt>
                <dd class="col-sm-9">{{ number_format($claim->deductible ?? 0, 2) }}</dd>

                <dt class="col-sm-3">Parts</dt>
                <dd class="col-sm-9">{{ number_format($claim->parts ?? 0, 2) }}</dd>

                <dt class="col-sm-3">Labor Cost</dt>
                <dd class="col-sm-9">{{ number_format($claim->labor_cost ?? 0, 2) }}</dd>

                <dt class="col-sm-3">Materials</dt>
                <dd class="col-sm-9">{{ number_format($claim->materials ?? 0, 2) }}</dd>

                <dt class="col-sm-3">VAT</dt>
                <dd class="col-sm-9">{{ number_format($claim->vat ?? 0, 2) }}</dd>

                <dt class="col-sm-3">Total</dt>
                <dd class="col-sm-9">{{ number_format($claim->total_amount ?? 0, 2) }}</dd>

                <dt class="col-sm-3">File</dt>
                <dd class="col-sm-9">
                    @if($claim->file_path)
                        <a href="{{ route('claims.download', $claim) }}">Download file</a>
                    @else
                        <span class="text-muted">No file uploaded</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
</div>
@endsection
