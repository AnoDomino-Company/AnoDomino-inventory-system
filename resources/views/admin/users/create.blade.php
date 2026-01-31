@extends('layouts.app')
@section('title','Create User')
@section('content')
<div class="container py-4" style="font-family: 'Lato', sans-serif;">
    <h3 class="mb-4">Create User</h3>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="user">User</option>
                <option value="supervisor">Supervisor</option>
                <option value="storekeeper">Storekeeper</option>
                <option value="authoriser">authoriser</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button class="btn btn-orange text-white">Create</button>
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
