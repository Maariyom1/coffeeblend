@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-lg" style="width: 400px;">
        <div class="card-header bg-primary text-white text-center">
            <h4>Coffee Blend Admin Login</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.login') }}" method="POST">
                @csrf <!-- Add CSRF protection -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
        <div class="card-footer text-center">
            <small>© {{ date('Y') }} Coffee Blend. All rights reserved.</small>
        </div>
    </div>
</div>
@endsection
