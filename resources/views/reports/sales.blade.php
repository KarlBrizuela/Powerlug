@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Sales Report</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Walk-in Sales</h5>
                                    <p class="card-text">₱{{ number_format($walkInSales, 2) }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Add more cards for insurance policy and claim sales once implemented -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection