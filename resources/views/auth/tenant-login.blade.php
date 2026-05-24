<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #0f3460 0%, #533483 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { border-radius: 20px; border: none; max-width: 420px; }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="card shadow-lg login-card p-4 w-100">
            <div class="text-center mb-4">
                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                     style="width:70px;height:70px">
                    <i class="bi bi-chat-dots-fill text-white fs-2"></i>
                </div>
                <h5 class="fw-bold">نظام المراسلات</h5>
                <p class="text-muted small">تسجيل دخول الموظفين</p>
            </div>

@if (isset($errors) && $errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-x-circle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('tenant.login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control" placeholder="user@company.com" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">كلمة المرور</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">تذكرني</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                    <i class="bi bi-box-arrow-in-right me-2"></i>دخول
                </button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>