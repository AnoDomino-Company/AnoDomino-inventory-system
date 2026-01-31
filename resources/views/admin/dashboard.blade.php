@extends('layouts.app')
@section('title','Admin Dashboard')
@section('content')
<div class="container py-4">
    <h2 class="mb-3" style="color:#333;">Welcome, {{ auth()->user()->name }}!</h2>
    <p style="font-size:1.1rem;">You are in control of the Inventory System. Manage everything with authority.</p>

    <div class="row my-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <i class="bi bi-people-fill" style="font-size:3rem; color:#0d6efd;"></i>
                <h5 class="mt-3">Users</h5>
                <a href="{{ route('users.index') }}" class="btn btn-primary mt-2">Manage Users</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <i class="bi bi-box-seam" style="font-size:3rem; color:#0d6efd;"></i>
                <h5 class="mt-3">Items</h5>
                <a href="{{ route('items.index') }}" class="btn btn-primary mt-2">Manage Items</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <i class="bi bi-card-checklist" style="font-size:3rem; color:#0d6efd;"></i>
                <h5 class="mt-3">Requests</h5>
                <a href="{{ route('requests.index') }}" class="btn btn-primary mt-2">View Requests</a>
            </div>
        </div>
    </div>

    <h4 class="mt-5">Quick Actions</h4>
    <div class="d-flex gap-3 flex-wrap">
        <a href="{{ route('users.create') }}" class="btn btn-outline-primary btn-lg">➕ Add New User</a>
        <a href="{{ route('items.index') }}" class="btn btn-outline-primary btn-lg">📦 Add / Restock Items</a>
    </div>

    <p class="mt-5" style="font-style:italic; color:#555;">Remember: As the admin, the system bends to your will. Use wisely.</p>
</div>

<style>
.card {
    border-radius: 12px;
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
.card h5 {
    font-weight: 600;
    margin-top: 10px;
}
</style>

<!-- Include Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
