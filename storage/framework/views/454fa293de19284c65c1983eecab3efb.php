<?php $__env->startSection('title', 'صندوق الوارد'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-inbox text-primary me-2"></i>
        صندوق الوارد
        <?php if($unreadCount > 0): ?>
            <span class="badge bg-danger"><?php echo e($unreadCount); ?></span>
        <?php endif; ?>
    </h4>
    <a href="<?php echo e(route('messaging.compose')); ?>" class="btn btn-primary">
        <i class="bi bi-pencil-square me-2"></i>رسالة جديدة
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="d-flex align-items-start p-3 border-bottom <?php echo e(!$message->is_read ? 'bg-primary bg-opacity-10' : ''); ?>"
             style="transition: background .2s">

            <a href="<?php echo e(route('messaging.conversation', $message->sender)); ?>"
               class="d-flex align-items-start flex-grow-1 text-decoration-none text-dark">

                <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                     style="width:45px;height:45px;background:#6c757d;color:white;font-size:18px;font-weight:bold">
                    <?php echo e(mb_substr($message->sender->name, 0, 1)); ?>

                </div>

                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="<?php echo e(!$message->is_read ? 'fw-bold' : ''); ?>"><?php echo e($message->sender->name); ?></span>
                            <small class="text-muted ms-2"><?php echo e($message->sender->department); ?></small>
                        </div>
                        <small class="text-muted"><?php echo e($message->created_at->diffForHumans()); ?></small>
                    </div>
                    <p class="mb-0 text-muted mt-1"><?php echo e(Str::limit($message->body, 120)); ?></p>
                    <?php if($message->attachment): ?>
                        <small class="text-primary"><i class="bi bi-paperclip me-1"></i>مرفق</small>
                    <?php endif; ?>
                </div>
            </a>

            <div class="d-flex gap-2 ms-3 align-items-center">
                <?php if(!$message->is_read): ?>
                    <span class="badge bg-primary">جديد</span>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('messaging.destroy', $message)); ?>"
                      onsubmit="return confirm('حذف الرسالة؟')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center text-muted py-5">
            <i class="bi bi-inbox fs-1 d-block mb-3 text-primary"></i>
            <h5>صندوق الوارد فارغ</h5>
            <p>لا توجد رسائل واردة حتى الآن</p>
        </div>
        <?php endif; ?>
    </div>

    <?php if($messages->hasPages()): ?>
    <div class="card-footer bg-white">
        <?php echo e($messages->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.tenant', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\saas-messaging-complete\project\modules/Messaging/Views/messages/inbox.blade.php ENDPATH**/ ?>