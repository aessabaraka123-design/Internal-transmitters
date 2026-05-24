<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <form method="POST" action="{{ route('tenant.login') }}">
        @csrf

        @if ($errors->any())
            <div>{{ $errors->first() }}</div>
        @endif

        <input type="email" name="email" placeholder="البريد الإلكتروني" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="كلمة المرور" required>
        <label>
            <input type="checkbox" name="remember"> تذكرني
        </label>
        <button type="submit">دخول</button>
    </form>
</body>
</html>