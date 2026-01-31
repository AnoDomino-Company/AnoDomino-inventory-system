@extends('layouts.app')

@section('title', 'Request Details')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-black text-white">
        <h2 class="mb-0">Request Details</h2>
    </div>
    <div class="card-body">
        <p><strong>Requested By:</strong> {{ $request->requestedBy->name ?? 'N/A' }}</p>
        <p><strong>Supervisor:</strong> {{ $request->supervisor->name ?? 'N/A' }}</p>
        <p>
            <strong>Status:</strong>
            @if($request->status === 'approved')
                <span class="badge bg-success">Approved</span>
            @elseif($request->status === 'pending')
                <span class="badge bg-orange">Pending</span>
            @elseif($request->status === 'rejected')
                <span class="badge bg-danger">Rejected</span>
            @else
                <span class="badge bg-secondary">{{ $request->status }}</span>
            @endif
        </p>
        <p><strong>Remarks:</strong> {{ $request->remarks ?? 'None' }}</p>

        <h3 class="mt-4">Requested Items:</h3>
        <ul class="list-group mb-3">
            @foreach($request->items as $ri)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $ri->item->name }}
                    <span class="badge bg-black text-white rounded-pill">Qty: {{ $ri->quantity_requested }}</span>
                </li>
            @endforeach
        </ul>

        <a href="{{ route('requests.index') }}" class="btn btn-outline-dark">Back to Requests</a>
    </div>
</div>
@endsection
