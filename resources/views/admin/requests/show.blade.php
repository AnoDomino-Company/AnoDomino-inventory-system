@extends('layouts.app')
@section('title','Request Details')
@section('content')
<div class="container py-4" style="font-family: 'Lato', sans-serif;">
    <h3 class="mb-4">Request #{{ $requestModel->id }} Details</h3>

    <p><strong>Requested By:</strong> {{ $requestModel->requester->name ?? 'N/A' }}</p>
    <p><strong>Supervisor:</strong> {{ $requestModel->supervisor->name ?? 'N/A' }}</p>
    <p><strong>Status:</strong> 
        <span class="badge 
            @if($requestModel->status == 'approved') bg-success
            @elseif($requestModel->status == 'rejected') bg-danger
            @elseif($requestModel->status == 'issued') bg-primary
            @else bg-secondary
            @endif">
            {{ ucfirst($requestModel->status) }}
        </span>
    </p>

    <h4 class="mt-4">Items</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Item</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requestModel->items as $ri)
            <tr>
                <td>{{ $ri->item->name }}</td>
                <td>{{ $ri->quantity_requested }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="mt-4">Decide / Override</h4>
    <form action="{{ route('admin.requests.decide',$requestModel) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="pending" @if($requestModel->status=='pending') selected @endif>Pending</option>
                <option value="approved" @if($requestModel->status=='approved') selected @endif>Approved</option>
                <option value="authorized" @if($requestModel->status=='authorized') selected @endif>Authorized</option>
                <option value="rejected" @if($requestModel->status=='rejected') selected @endif>Rejected</option>
                <option value="issued" @if($requestModel->status=='issued') selected @endif>Issued</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control">{{ $requestModel->remarks ?? '' }}</textarea>
        </div>
        <button class="btn btn-orange text-white">Save</button>
    </form>
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
