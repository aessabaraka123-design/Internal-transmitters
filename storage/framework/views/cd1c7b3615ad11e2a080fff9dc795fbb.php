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
    <form method="POST" action="<?php echo e(route('super-admin.logout')); ?>">
        <?php echo csrf_field(); ?>
        <button class="btn btn-outline-light btn-sm">خروج</button>
    </form>
</nav>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>قائمة الشركات</h4>
        <a href="<?php echo e(route('super-admin.tenants.create')); ?>" class="btn btn-primary">+ إضافة شركة</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

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
                <?php $__empty_1 = true; $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($tenant->company_name); ?></td>
                    <td><?php echo e($tenant->email); ?></td>
                    <td><?php echo e($tenant->plan); ?></td>
                    <td>
                        <?php if($tenant->is_active): ?>
                            <span class="badge bg-success">نشط</span>
                        <?php else: ?>
                            <span class="badge bg-danger">موقوف</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($tenant->subscription_ends_at?->format('Y-m-d') ?? '-'); ?></td>
                    <td>
                        <form method="POST" action="<?php echo e(route('super-admin.tenants.toggle-status', $tenant)); ?>" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-sm btn-warning">تبديل</button>
                        </form>
                        <form method="POST" action="<?php echo e(route('super-admin.tenants.destroy', $tenant)); ?>" class="d-inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger" onclick="return confirm('حذف؟')">حذف</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">لا توجد شركات بعد</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3"><?php echo e($tenants->links()); ?></div>
</div>

</body>
</html><?php /**PATH C:\saas-messaging-complete\project\resources\views/tenants/index.blade.php ENDPATH**/ ?>