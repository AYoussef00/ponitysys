@extends('layouts.auth')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="text-center mb-4">
            <img src="{{ asset('images/customer-loyalty-program-gold-vector-600nw-1038375271.webp') }}" alt="Logo" class="auth-logo mb-3">
            <h4 class="auth-title">تسجيل الدخول</h4>
            <p class="auth-subtitle text-muted">أدخل بيانات حسابك للمتابعة</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">كلمة المرور</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">تذكرني</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none">نسيت كلمة المرور؟</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="bi bi-box-arrow-in-left me-2"></i>تسجيل الدخول
            </button>
        </form>
    </div>
</div>

<style>
.auth-container {
    width: 100%;
    max-width: 420px;
    margin: 0 auto;
}

.auth-card {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

.auth-logo {
    height: 60px;
    width: auto;
    margin-bottom: 20px;
}

.auth-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.auth-subtitle {
    font-size: 0.875rem;
}

.auth-form .input-group-text {
    background-color: transparent;
    border-left: 0;
}

.auth-form .form-control {
    border-right: 0;
}

.auth-form .form-control:focus {
    border-color: #dee2e6;
    box-shadow: none;
}

.auth-form .form-control:focus + .input-group-text {
    border-color: #dee2e6;
}

.btn-primary {
    padding: 0.75rem 1rem;
}
</style>
@endsection
