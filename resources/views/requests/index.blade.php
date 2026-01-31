@extends('layouts.app')

@section('title', 'Requests List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 text-black">Requests</h1>
    <a href="{{ route('requests.create') }}" class="btn btn-orange">+ Create New Request</a>
</div>

<table class="table table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Requested By</th>
            <th>Supervisor</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->requester->name }}</td>
                <td>{{ $request->supervisor->name }}</td>
                <td>
                    @if($request->status === 'approved')
                        <span class="badge bg-success">Approved</span>
                    @elseif($request->status === 'pending')
                        <span class="badge bg-orange">Pending</span>
                    @elseif($request->status === 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-secondary">{{ $request->status }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('requests.show', $request->id) }}" class="btn btn-sm btn-outline-dark">View</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
