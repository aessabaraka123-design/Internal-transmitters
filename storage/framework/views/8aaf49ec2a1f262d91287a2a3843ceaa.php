<?php $__env->startSection('title', 'لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-speedometer2 text-primary me-2"></i>لوحة التحكم
    </h4>
    <span class="text-muted"><?php echo e(now()->format('l، d F Y')); ?></span>
</div>

<!-- بطاقات الإحصائيات -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                        <i class="bi bi-inbox fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold"><?php echo e($stats['unread']); ?></div>
                        <div class="text-muted small">رسائل غير مقروءة</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                        <i class="bi bi-send fs-4 text-success"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold"><?php echo e($stats['sent_today']); ?></div>
                        <div class="text-muted small">أُرسلت اليوم</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                        <i class="bi bi-people fs-4 text-info"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold"><?php echo e($stats['total_users']); ?></div>
                        <div class="text-muted small">موظفون نشطون</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                        <i class="bi bi-chat-dots fs-4 text-warning"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold"><?php echo e($stats['total_messages']); ?></div>
                        <div class="text-muted small">إجمالي الرسائل</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- آخر الرسائل -->
<div class="row g-3">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between">
                <h6 class="mb-0 fw-bold">آخر الرسائل الواردة</h6>
                <a href="<?php echo e(route('messaging.inbox')); ?>" class="btn btn-sm btn-outline-primary">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <?php $__empty_1 = true; $__currentLoopData = $recentMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex align-items-start p-3 border-bottom <?php echo e(!$message->is_read ? 'bg-primary bg-opacity-5' : ''); ?>">
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                         style="width:40px;height:40px;color:white;font-weight:bold">
                        <?php echo e(mb_substr($message->sender->name, 0, 1)); ?>

                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <strong><?php echo e($message->sender->name); ?></strong>
                            <small class="text-muted"><?php echo e($message->created_at->diffForHumans()); ?></small>
                        </div>
                        <p class="mb-0 text-muted small"><?php echo e(Str::limit($message->body, 80)); ?></p>
                    </div>
                    <?php if(!$message->is_read): ?>
                        <span class="badge bg-primary ms-2">جديد</span>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    لا توجد رسائل بعد
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- معلومات الاشتراك -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-bold"><i class="bi bi-star me-2 text-warning"></i>الاشتراك الحالي</h6>
            </div>
            <div class="card-body">
                <?php $plans = \App\Models\Tenant::plans(); $currentPlan = tenant('plan') ?? 'basic'; ?>
                <div class="text-center mb-3">
                    <span class="badge bg-primary fs-5 px-4 py-2"><?php echo e($plans[$currentPlan]['name'] ?? $currentPlan); ?></span>
                </div>
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="bi bi-people text-primary me-2"></i>
                        حتى <strong><?php echo e($plans[$currentPlan]['max_users']); ?></strong> مستخدم
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-calendar text-success me-2"></i>
                        ينتهي: <strong><?php echo e(\Carbon\Carbon::parse(tenant('subscription_ends_at'))->format('Y/m/d')); ?></strong>
                    </li>
                    <li>
                        <i class="bi bi-currency-dollar text-warning me-2"></i>
                        السعر: <strong>$<?php echo e($plans[$currentPlan]['price']); ?>/شهر</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tenant', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\saas-messaging-complete\project\resources\views/tenants/dashboard.blade.php ENDPATH**/ ?>