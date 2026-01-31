@extends('layouts.app')
@section('title', 'Register - AnoDomino Company Inventory System')

@section('content')
<div class="vh-100 d-flex justify-content-center align-items-center bg-light" style="font-family: 'Lato', sans-serif;">
    <div class="card shadow p-4" style="width: 100%; max-width: 450px; border-radius: 15px;">
        <div class="text-center mb-4">
            <h2 class="text-black">AnoDomino Company</h2>
            <p class="text-muted">AnoDomino Inventory System</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="d-flex flex-column gap-3">
            @csrf
            <input type="text" name="name" placeholder="Full Name" class="form-control" required>
            <input type="email" name="email" placeholder="Email" class="form-control" required>
            <input type="password" name="password" placeholder="Password" class="form-control" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" required>
            <input type="hidden" name="role" value="user">

            <button type="submit" class="btn btn-orange text-white fw-bold">Register</button>
        </form>

        <div class="text-center mt-3">
            <span class="text-muted">Already have an account? </span>
            <a href="/login" class="text-orange fw-bold">Login</a>
        </div>
    </div>
</div>

<style>
    .btn-orange {
        background-color: #CB8F2F;
        border: none;
    }
    .btn-orange:hover {
        background-color: #B47D28;
    }
    .text-orange {
        color: #CB8F2F;
    }
</style>
@endsection
