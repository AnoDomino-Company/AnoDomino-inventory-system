@extends('layouts.app')
@section('title','All Requests')
@section('content')
<div class="container py-4" style="font-family: 'Lato', sans-serif;">
    <h3 class="mb-4">All Requests</h3>
    <table class="table table-bordered table-striped align-middle">
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
        @foreach($requests as $req)
            <tr>
                <td>{{ $req->id }}</td>
                <td>{{ $req->requester->name ?? 'N/A' }}</td>
                <td>{{ $req->supervisor->name ?? 'N/A' }}</td>
                <td>
                    <span class="badge 
                        @if($req->status === 'approved') bg-success
                        @elseif($req->status === 'rejected') bg-danger
                        @else bg-secondary
                        @endif">
                        {{ ucfirst($req->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.requests.show',$req) }}" class="btn btn-sm btn-orange text-white">View</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<style>
.btn-orange {
    background-color: #CB8F2F;
    border: none;
}
.btn-orange:hover {
    background-color: #B47D28;
}
</style>
@endsection
