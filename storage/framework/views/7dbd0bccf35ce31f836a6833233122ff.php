<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'نظام المراسلات'); ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .sidebar { min-height: 100vh; background: #1a1a2e; color: white; width: 250px; position: fixed; right: 0; top: 0; }
        .sidebar .nav-link { color: rgba(255,255,255,.7); padding: 10px 20px; border-radius: 8px; margin: 2px 10px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,.15); color: white; }
        .main-content { margin-right: 250px; padding: 20px; }
        .navbar-brand-logo { font-size: 1.4rem; font-weight: 700; padding: 20px; border-bottom: 1px solid rgba(255,255,255,.1); }
        .unread-badge { animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column">
    <div class="navbar-brand-logo">
        <i class="bi bi-chat-dots-fill text-primary"></i>
        نظام المراسلات
    </div>

    <nav class="nav flex-column mt-3 flex-grow-1">
        <a class="nav-link <?php echo e(request()->routeIs('tenant.dashboard') ? 'active' : ''); ?>"
           href="<?php echo e(route('tenant.dashboard')); ?>">
            <i class="bi bi-speedometer2 me-2"></i> لوحة التحكم
        </a>
        <a class="nav-link <?php echo e(request()->routeIs('messaging.inbox') ? 'active' : ''); ?>"
           href="<?php echo e(route('messaging.inbox')); ?>">
            <i class="bi bi-inbox me-2"></i> الوارد
            <?php
                $unread = 0;
                try {
                    $unread = \Modules\Messaging\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count();
                } catch (\Exception $e) {}
            ?>
            <?php if($unread > 0): ?>
                <span class="badge bg-danger unread-badge"><?php echo e($unread); ?></span>
            <?php endif; ?>
        </a>
        <a class="nav-link <?php echo e(request()->routeIs('messaging.sent') ? 'active' : ''); ?>"
           href="<?php echo e(route('messaging.sent')); ?>">
            <i class="bi bi-send me-2"></i> المُرسَلة
        </a>
        <a class="nav-link <?php echo e(request()->routeIs('messaging.compose') ? 'active' : ''); ?>"
           href="<?php echo e(route('messaging.compose')); ?>">
            <i class="bi bi-pencil-square me-2"></i> رسالة جديدة
        </a>

        <?php if(auth()->user()->isAdmin()): ?>
        <hr class="text-white-50">
        <a class="nav-link <?php echo e(request()->routeIs('tenant.users.*') ? 'active' : ''); ?>"
           href="<?php echo e(route('tenant.users.index')); ?>">
            <i class="bi bi-people me-2"></i> إدارة المستخدمين
        </a>
        <?php endif; ?>
    </nav>

    <div class="p-3 border-top border-secondary">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                 style="width:36px;height:36px;font-weight:bold;font-size:14px">
                <?php echo e(mb_substr(auth()->user()->name, 0, 1)); ?>

            </div>
            <div class="me-2">
                <div class="text-white small fw-bold"><?php echo e(auth()->user()->name); ?></div>
                <div class="text-white-50" style="font-size:11px"><?php echo e(auth()->user()->role === 'admin' ? 'مدير' : 'موظف'); ?></div>
            </div>
        </div>
        <form method="POST" action="<?php echo e(route('tenant.logout')); ?>" class="mt-2">
            <?php echo csrf_field(); ?>
            <button class="btn btn-sm btn-outline-light w-100">
                <i class="bi bi-box-arrow-left me-1"></i> تسجيل الخروج
            </button>
        </form>
    </div>
</div>

<main class="main-content">
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-x-circle me-2"></i><?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\saas-messaging-complete\project\resources\views/layouts/tenant.blade.php ENDPATH**/ ?>