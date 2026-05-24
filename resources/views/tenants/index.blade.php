<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الشركات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4">
    <span class="navbar-brand">🏢 لوحة السوبر أدمن</span>
    <form method="POST" action="{{ route('super-admin.logout') }}">
        @csrf
        <button class="btn btn-outline-light btn-sm">خروج</button>
    </form>
</nav>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>قائمة الشركات</h4>
        <a href="{{ route('super-admin.tenants.create') }}" class="btn btn-primary">+ إضافة شركة</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>الشركة</th>
                    <th>الإيميل</th>
                    <th>الخطة</th>
                    <th>الحالة</th>
                    <th>انتهاء الاشتراك</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr>
                    <td>{{ $tenant->company_name }}</td>
                    <td>{{ $tenant->email }}</td>
                    <td>{{ $tenant->plan }}</td>
                    <td>
                        @if($tenant->is_active)
                            <span class="badge bg-success">نشط</span>
                        @else
                            <span class="badge bg-danger">موقوف</span>
                        @endif
                    </td>
                    <td>{{ $tenant->subscription_ends_at?->format('Y-m-d') ?? '-' }}</td>
                    <td>
                        <form method="POST" action="{{ route('super-admin.tenants.toggle-status', $tenant) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-warning">تبديل</button>
                        </form>
                        <form method="POST" action="{{ route('super-admin.tenants.destroy', $tenant) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('حذف؟')">حذف</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">لا توجد شركات بعد</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $tenants->links() }}</div>
</div>

</body>
</html>