@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="page-title">Policy Details</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('policies.edit', $policy->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('policies.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Policy Information</h5>
                </div>
                <div class="card-body">
                    @include('pages.policies._view', ['policy' => $policy])
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Button -->
    <div class="row mt-4">
        <div class="col-md-12">
            <form action="{{ route('policies.destroy', $policy->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this policy?')">
                    <i class="fas fa-trash"></i> Delete Policy
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .page-title {
        font-size: 2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }

    .card {
        border: 1px solid #dee2e6;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-header {
        border-bottom: 1px solid #dee2e6;
    }
</style>
@endsection
