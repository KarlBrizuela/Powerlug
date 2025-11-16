<div class="row">
    <div class="col-md-6">
        <h5>Collection Information</h5>
        <table class="table table-sm">
            <tr>
                <th>Collection #</th>
                <td>{{ $collection->collection_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Invoice #</th>
                <td>{{ $collection->invoice_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Client</th>
                <td>{{ optional($collection->client)->lastName }}, {{ optional($collection->client)->firstName }} {{ optional($collection->client)->middleName }}</td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>₱{{ number_format($collection->collection_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td>{{ ucfirst(str_replace('_', ' ', $collection->payment_method)) }}</td>
            </tr>
            <tr>
                <th>Collection Status</th>
                <td>{{ ucfirst($collection->collection_status) }}</td>
            </tr>
            <tr>
                <th>Billing Status</th>
                <td>{{ ucfirst($collection->billing_status) }}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h5>Additional Details</h5>
        <table class="table table-sm">
            <tr>
                <th>Date</th>
                <td>{{ optional($collection->collection_date)->format('Y-m-d') }}</td>
            </tr>
            <tr>
                <th>Bank</th>
                <td>{{ $collection->bank_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>LOA</th>
                <td>{{ $collection->loa ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $collection->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $collection->updated_at->format('Y-m-d H:i') }}</td>
            </tr>
        </table>
    </div>
</div>
