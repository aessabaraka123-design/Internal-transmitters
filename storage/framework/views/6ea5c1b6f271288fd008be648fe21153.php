<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دخول السوبر أدمن</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { border-radius: 20px; border: none; max-width: 400px; }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="card shadow-lg login-card p-4 w-100">
            <div class="text-center mb-4">
                <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center mb-3"
                     style="width:70px;height:70px">
                    <i class="bi bi-shield-check text-dark fs-2"></i>
                </div>
                <h5 class="fw-bold">لوحة السوبر أدمن</h5>
                <p class="text-muted small">دخول مشرفي النظام فقط</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-x-circle me-2"></i><?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('super-admin.login.post')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>"
                           class="form-control" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning w-100 py-2 fw-bold text-dark">
                    <i class="bi bi-shield-lock me-2"></i>دخول آمن
                </button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\saas-messaging-complete\project\resources\views/auth/super-admin-login.blade.php ENDPATH**/ ?>