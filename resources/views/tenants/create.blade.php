<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة شركة جديدة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand">🏢 لوحة السوبر أدمن</span>
    <a href="{{ route('super-admin.tenants.index') }}" class="btn btn-outline-light btn-sm">رجوع</a>
</nav>

<div class="container py-4" style="max-width:600px">
    <h4 class="mb-4">إضافة شركة جديدة</h4>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card shadow-sm p-4">
        <form method="POST" action="{{ route('super-admin.tenants.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">اسم الشركة</label>
                <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني للشركة</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">الدومين (subdomain)</label>
                <input type="text" name="subdomain" class="form-control" placeholder="acme" value="{{ old('subdomain') }}" required>
                <small class="text-muted">مثال: acme → acme.saas-messaging.test</small>
            </div>

            <div class="mb-3">
                <label class="form-label">خطة الاشتراك</label>
                <select name="plan" class="form-select">
                    @foreach($plans as $key => $plan)
                        <option value="{{ $key }}">{{ $plan['name'] }} - ${{ $plan['price'] }}/شهر</option>
                    @endforeach
                </select>
            </div>

            <hr>
            <p class="text-muted small">معلومات مدير الشركة</p>

            <div class="mb-3">
                <label class="form-label">اسم المدير</label>
                <input type="text" name="admin_name" class="form-control" value="{{ old('admin_name', 'مدير الشركة') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">إيميل المدير</label>
                <input type="email" name="admin_email" class="form-control" value="{{ old('admin_email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">كلمة مرور المدير</label>
                <input type="password" name="admin_password" class="form-control" value="password" required>
            </div>

            <div class="mb-3">
    <label class="form-label">تأكيد كلمة المرور</label>
    <input type="password" name="admin_password_confirmation" class="form-control" value="password" required>
</div>

            <button type="submit" class="btn btn-primary w-100">إنشاء الشركة</button>
        </form>
    </div>
</div>

</body>
</html>