@extends('layouts.app')
@section('title', 'Welcome')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100" style="background-color: #f8f9fa;">
    <div class="card p-4 shadow-sm position-relative" style="min-width: 350px; max-width: 400px; border-radius: 10px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #CB8F2F; font-family: 'Lato', sans-serif;">AnoDomino Company</h2>
            <p class="text-muted">AnoDomino Inventory System</p>
            <p class="text-muted">Welcome! Please login to continue.</p>
        </div>

        <form action="/login" method="POST" class="d-flex flex-column gap-3">
            @csrf
            <input type="email" name="email" placeholder="Email" class="form-control form-control-lg" required>
            <input type="password" name="password" placeholder="Password" class="form-control form-control-lg" required>
            <button type="submit" class="btn btn-lg" style="background-color: #CB8F2F; color: white;">Login</button>
        </form>

        <div class="mt-3 text-center">
            <span class="text-muted">Don't have an account? </span>
            <a href="/register" style="color: #CB8F2F; font-weight: 500;">Register</a>
        </div>

        <!-- Subtle watermark -->
        <div style="position:absolute; bottom:8px; right:8px; font-size: 10px; color: rgba(0,0,0,0.2);">
            AnoDomino Technologies © 2025
        </div>
    </div>
</div>
@endsection
