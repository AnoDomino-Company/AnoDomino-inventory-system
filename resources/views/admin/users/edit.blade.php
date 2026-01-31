@extends('layouts.app')
@section('title','Edit User')
@section('content')
<div class="container py-4" style="font-family: 'Lato', sans-serif;">
    <h3 class="mb-4">Edit User</h3>

    <form action="{{ route('users.update',$user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="user" @if($user->role=='user') selected @endif>User</option>
                <option value="supervisor" @if($user->role=='supervisor') selected @endif>Supervisor</option>
                <option value="authoriser" @if($user->role=='authoriser') selected @endif>authoriser</option>
                <option value="storekeeper" @if($user->role=='storekeeper') selected @endif>Storekeeper</option>
                <option value="admin" @if($user->role=='admin') selected @endif>Admin</option>
            </select>
        </div>

        <button class="btn btn-orange text-white">Update</button>
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
