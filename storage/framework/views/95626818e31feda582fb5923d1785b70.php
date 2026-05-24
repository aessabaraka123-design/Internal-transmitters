<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة السوبر أدمن - SaaS Messaging</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background: #f0f2f5; }
        .sidebar { background: linear-gradient(135deg, #1a1a2e, #16213e); min-height: 100vh; width: 260px; position: fixed; right: 0; }
        .sidebar .nav-link { color: rgba(255,255,255,.7); padding: 12px 20px; border-radius: 8px; margin: 2px 10px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,.15); color: white; }
        .main { margin-right: 260px; padding: 24px; }
        .stat-card { border-radius: 16px; border: none; }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column">
    <div class="p-4 text-white border-bottom border-secondary">
        <i class="bi bi-shield-check fs-4 text-warning me-2"></i>
        <strong>لوحة السوبر أدمن</strong>
    </div>
    <nav class="nav flex-column mt-3">
        <a class="nav-link active" href="<?php echo e(route('super-admin.dashboard')); ?>">
            <i class="bi bi-speedometer2 me-2"></i>الرئيسية
        </a>
        <a class="nav-link" href="<?php echo e(route('super-admin.tenants.index')); ?>">
            <i class="bi bi-buildings me-2"></i>الشركات
        </a>
        <a class="nav-link" href="<?php echo e(route('super-admin.tenants.create')); ?>">
            <i class="bi bi-plus-circle me-2"></i>إضافة شركة
        </a>
    </nav>
    <div class="mt-auto p-3">
        <form method="POST" action="<?php echo e(route('super-admin.logout')); ?>">
            <?php echo csrf_field(); ?>
            <button class="btn btn-sm btn-outline-light w-100">
                <i class="bi bi-box-arrow-left me-1"></i>تسجيل الخروج
            </button>
        </form>
    </div>
</div>

<main class="main">
    <h4 class="fw-bold mb-4">
        <i class="bi bi-graph-up text-primary me-2"></i>نظرة عامة على النظام
    </h4>

    <!-- إحصائيات عامة -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="bi bi-buildings fs-1 text-primary mb-2 d-block"></i>
                    <h2 class="fw-bold"><?php echo e($stats['total_tenants']); ?></h2>
                    <p class="text-muted mb-0">إجمالي الشركات</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="bi bi-check-circle fs-1 text-success mb-2 d-block"></i>
                    <h2 class="fw-bold"><?php echo e($stats['active_tenants']); ?></h2>
                    <p class="text-muted mb-0">شركات نشطة</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="bi bi-currency-dollar fs-1 text-warning mb-2 d-block"></i>
                    <h2 class="fw-bold">$<?php echo e(number_format($stats['total_revenue'])); ?></h2>
                    <p class="text-muted mb-0">الإيرادات الشهرية</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm">
                <div class="card-body text-center py-4">
                    <i class="bi bi-bar-chart fs-1 text-info mb-2 d-block"></i>
                    <h2 class="fw-bold"><?php echo e($stats['plans']['enterprise']); ?></h2>
                    <p class="text-muted mb-0">خطة مؤسسية</p>
                </div>
            </div>
        </div>
    </div>

    <!-- توزيع الخطط -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">توزيع خطط الاشتراك</div>
                <div class="card-body">
                    <?php $plans = \App\Models\Tenant::plans(); ?>
                    <?php $__currentLoopData = ['basic' => 'primary', 'pro' => 'success', 'enterprise' => 'warning']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><?php echo e($plans[$plan]['name']); ?></span>
                            <span class="badge bg-<?php echo e($color); ?>"><?php echo e($stats['plans'][$plan]); ?> شركة</span>
                        </div>
                        <div class="progress" style="height: 8px">
                            <div class="progress-bar bg-<?php echo e($color); ?>"
                                 style="width: <?php echo e($stats['total_tenants'] > 0 ? ($stats['plans'][$plan] / $stats['total_tenants'] * 100) : 0); ?>%">
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- آخر الشركات -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between">
                    <span class="fw-bold">آخر الشركات المسجلة</span>
                    <a href="<?php echo e(route('super-admin.tenants.index')); ?>" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>الشركة</th>
                                <th>الخطة</th>
                                <th>الحالة</th>
                                <th>تاريخ التسجيل</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentTenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($tenant->data['company_name'] ?? $tenant->id); ?></strong><br>
                                    <small class="text-muted"><?php echo e($tenant->data['email'] ?? ''); ?></small>
                                </td>
                                <td>
                                    <?php $plan = $tenant->data['plan'] ?? 'basic'; ?>
                                    <span class="badge bg-<?php echo e(['basic'=>'secondary','pro'=>'primary','enterprise'=>'warning'][$plan] ?? 'secondary'); ?>">
                                        <?php echo e($plans[$plan]['name'] ?? $plan); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($tenant->data['is_active'] ?? false): ?>
                                        <span class="badge bg-success">نشط</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">موقوف</span>
                                    <?php endif; ?>
                                </td>
                                <td><small><?php echo e($tenant->created_at ? $tenant->created_at->format('Y/m/d') : '-'); ?></small></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">لا توجد شركات بعد</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\saas-messaging-complete\project\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>