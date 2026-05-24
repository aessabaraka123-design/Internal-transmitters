

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">📤 الرسائل المُرسَلة</h4>
        <a href="<?php echo e(route('messaging.compose')); ?>" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i> رسالة جديدة
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="list-group list-group-flush">
            <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('messaging.conversation', $message->receiver)); ?>"
               class="list-group-item list-group-item-action py-3 text-decoration-none">
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">إلى: <?php echo e($message->receiver->name ?? 'محذوف'); ?></span>
                    <small class="text-muted"><?php echo e($message->created_at->diffForHumans()); ?></small>
                </div>
                <p class="mb-0 text-muted small"><?php echo e(Str::limit($message->body, 100)); ?></p>
                <?php if($message->attachment): ?>
                    <small class="text-primary"><i class="bi bi-paperclip me-1"></i>مرفق</small>
                <?php endif; ?>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="list-group-item text-center text-muted py-5">
                لا توجد رسائل مُرسَلة
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-3"><?php echo e($messages->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.tenant', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\saas-messaging-complete\project\modules/Messaging/Views/messages/sent.blade.php ENDPATH**/ ?>