@extends('layouts.app')
@section('title', 'Pending Issues')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 text-black">Pending Issues</h1>
</div>

<!-- Flash messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($requests->isEmpty())
    <div class="alert alert-secondary">No requests to issue.</div>
@else
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Requested By</th>
                <th>Authorized?</th>
                <th>Items</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->requester->name ?? 'N/A' }}</td>
                    <td>
                        @if($request->status === 'authorized')
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-warning text-dark">No</span>
                        @endif
                    </td>
                    <td>
                        @foreach($request->items as $item)
                            <span class="badge bg-orange text-white me-1">{{ $item->item->name }} ({{ $item->quantity_requested }})</span>
                        @endforeach
                    </td>
                    <td>
                        <form method="POST" action="{{ route('issues.issue', $request) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-black">Issue</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
