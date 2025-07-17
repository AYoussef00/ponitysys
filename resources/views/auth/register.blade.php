@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-4" width="120">
                            <h4 class="mb-1">إنشاء حساب جديد</h4>
                            <p class="text-muted mb-0">أدخل بياناتك لإنشاء حساب جديد</p>
                        </div>

                        <!-- Register Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label">الاسم</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-person text-muted"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror"
                                        placeholder="أدخل اسمك" value="{{ old('name') }}" required autofocus>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                        placeholder="أدخل بريدك الإلكتروني" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                                        placeholder="أدخل كلمة المرور" required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label">تأكيد كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-lock-fill text-muted"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" class="form-control border-start-0 ps-0"
                                        placeholder="أعد إدخال كلمة المرور" required>
                                </div>
                            </div>

                            <!-- Terms -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="terms" class="form-check-input @error('terms') is-invalid @enderror" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        أوافق على <a href="#" class="text-primary text-decoration-none">الشروط والأحكام</a>
                                    </label>
                                    @error('terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-person-plus me-2"></i>
                                إنشاء حساب
                            </button>

                            <!-- Login Link -->
                            <div class="text-center">
                                <span class="text-muted">لديك حساب بالفعل؟</span>
                                <a href="{{ route('login') }}" class="text-primary text-decoration-none">
                                    تسجيل الدخول
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Additional Links -->
                <div class="text-center mt-4">
                    <a href="#" class="text-muted text-decoration-none mx-2">سياسة الخصوصية</a>
                    <span class="text-muted">•</span>
                    <a href="#" class="text-muted text-decoration-none mx-2">الشروط والأحكام</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:focus,
.form-check-input:focus {
    box-shadow: none;
    border-color: #0d6efd;
}
.input-group-text {
    color: #6c757d;
}
.btn-primary {
    padding: 0.6rem 1rem;
}
</style>
@endsection
