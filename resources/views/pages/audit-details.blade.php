<div>
    <h5>Activity Details</h5>
    <hr />
    <div class="mb-2"><strong>User:</strong> {{ $audit->user->name ?? 'System' }}</div>
    <div class="mb-2"><strong>Action:</strong> {{ ucfirst($audit->action) }}</div>
    <div class="mb-2"><strong>Module:</strong> {{ $audit->module }}</div>
    <div class="mb-2"><strong>Description:</strong> {{ $audit->description }}</div>
    <div class="mb-2"><strong>IP Address:</strong> {{ $audit->ip_address ?? '-' }}</div>
    <div class="mb-2"><strong>Date & Time:</strong> {{ $audit->created_at->format('F d, Y h:i A') }}</div>

    @if($audit->old_values)
        <hr />
        <div><strong>Old Values</strong></div>
        <pre class="small bg-light p-2">{{ $audit->old_values }}</pre>
    @endif

    @if($audit->new_values)
        <div class="mt-2"><strong>New Values</strong></div>
        <pre class="small bg-light p-2">{{ $audit->new_values }}</pre>
    @endif
</div>
