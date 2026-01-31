@extends('layouts.app')
@section('title','Users')
@section('content')
<div class="container py-4" style="font-family: 'Lato', sans-serif;">
    <h3 class="mb-4">Users</h3>

    <a href="{{ route('users.create') }}" class="btn btn-orange text-white mb-3">Add New User</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                    <a href="{{ route('users.edit',$user) }}" class="btn btn-sm btn-dark-grey text-white">Edit</a>
                    <a href="{{ route('users.reset-password-form',$user) }}" class="btn btn-sm btn-warning-black">Reset Password</a>
                    <form action="{{ route('users.destroy',$user) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
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

.btn-dark-grey {
    background-color: #8c8882; /* darker grey for better contrast */
    border: none;
}
.btn-dark-grey:hover {
    background-color: #6f6b65;
}

.btn-warning-black {
    background-color: #ffc107; /* Bootstrap warning yellow */
    color: #000; /* black text */
    border: none;
}
.btn-warning-black:hover {
    background-color: #e0a800;
    color: #000;
}
</style>
@endsection
