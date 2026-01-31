@extends('layouts.app')
@section('title','Reset Password')
@section('content')
<div class="container py-4" style="max-width: 500px;">
    <h3 class="mb-4" style="color:#333;">Reset Password for {{ $user->name }}</h3>

    <form action="{{ route('users.reset-password', $user) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter new password" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required>
        </div>
        <button class="btn btn-warning-black w-100">Reset Password</button>
    </form>

    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3 w-100">Back to Users</a>
</div>

<style>
.btn-warning-black {
    background-color: #ffc107;
    color: #000;
    border: none;
}
.btn-warning-black:hover {
    background-color: #e0a800;
    color: #000;
}
</style>
@endsection
