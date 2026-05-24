<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل شركة جديدة - SaaS Messaging</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .card { border-radius: 20px; border: none; }
        .plan-card { cursor: pointer; transition: all .3s; border: 2px solid #dee2e6; border-radius: 12px; }
        .plan-card:hover, .plan-card.selected { border-color: #0d6efd; background: #f0f4ff; }
        .plan-card input[type=radio]:checked ~ * { color: #0d6efd; }
    </style>
</head>
<body class="py-5">
<div class="container">
    <div class="text-center text-white mb-4">
        <i class="bi bi-chat-dots-fill fs-1"></i>
        <h2 class="fw-bold mt-2">SaaS Messaging</h2>
        <p class="opacity-75">نظام المراسلات الداخلي السحابي</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center mb-4">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg p-4" style="max-width: 700px; margin: 0 auto">
        <h4 class="fw-bold mb-4 text-center">
            <i class="bi bi-building me-2 text-primary"></i>تسجيل شركة جديدة
        </h4>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <!-- اختيار الخطة -->
            <h6 class="fw-bold mb-3">اختر خطة الاشتراك</h6>
            <div class="row g-2 mb-4">
                @foreach($plans as $key => $plan)
                <div class="col-md-4">
                    <label class="plan-card p-3 d-block text-center {{ old('plan') == $key ? 'selected' : '' }}">
                        <input type="radio" name="plan" value="{{ $key }}" class="d-none" {{ old('plan') == $key ? 'checked' : '' }} required>
                        <div class="fw-bold fs-5">{{ $plan['name'] }}</div>
                        <div class="text-primary fs-4 fw-bold">${{ $plan['price'] }}<small class="fs-6 text-muted">/شهر</small></div>
                        <div class="text-muted small">حتى {{ $plan['max_users'] }} مستخدم</div>
                        <div class="badge bg-success mt-1">14 يوم مجاناً</div>
                    </label>
                </div>
                @endforeach
            </div>
            @error('plan')<div class="text-danger small mb-3">{{ $message }}</div>@enderror

            <div class="row g-3">
                <!-- بيانات الشركة -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">اسم الشركة *</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                           class="form-control @error('company_name') is-invalid @enderror" required>
                    @error('company_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">النطاق الفرعي *</label>
                    <div class="input-group">
                        <input type="text" name="subdomain" value="{{ old('subdomain') }}"
                               class="form-control @error('subdomain') is-invalid @enderror"
                               placeholder="company-name" required>
                        <span class="input-group-text">.saas-messaging.com</span>
                    </div>
                    @error('subdomain')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">البريد الإلكتروني للشركة *</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <!-- بيانات المدير -->
                <div class="col-12"><hr><h6 class="fw-bold">بيانات مدير الشركة</h6></div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">الاسم الكامل *</label>
                    <input type="text" name="admin_name" value="{{ old('admin_name') }}"
                           class="form-control @error('admin_name') is-invalid @enderror" required>
                    @error('admin_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">البريد الإلكتروني *</label>
                    <input type="email" name="admin_email" value="{{ old('admin_email') }}"
                           class="form-control @error('admin_email') is-invalid @enderror" required>
                    @error('admin_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">كلمة المرور *</label>
                    <input type="password" name="admin_password"
                           class="form-control @error('admin_password') is-invalid @enderror" required>
                    @error('admin_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">تأكيد كلمة المرور *</label>
                    <input type="password" name="admin_password_confirmation" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4 py-2 fw-bold">
                <i class="bi bi-rocket-takeoff me-2"></i>ابدأ الآن - 14 يوم مجاناً
            </button>

            <div class="text-center mt-3">
                <a href="{{ route('tenant.login') }}" class="text-muted small">لديك حساب بالفعل؟ تسجيل الدخول</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // تحديث مظهر بطاقات الخطط عند الاختيار
    document.querySelectorAll('.plan-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            this.querySelector('input[type=radio]').checked = true;
        });
    });
</script>
</body>
</html>
