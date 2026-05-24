

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="<?php echo e(route('messaging.inbox')); ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-right"></i> رجوع
        </a>
        <h4 class="fw-bold mb-0">💬 محادثة مع <?php echo e($user->name); ?></h4>
    </div>

    <div class="card shadow-sm mb-3" style="max-height:500px; overflow-y:auto;" id="chat-box">
        <div class="card-body">
            <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="d-flex mb-3 <?php echo e($message->sender_id == auth()->id() ? 'justify-content-end' : ''); ?>">
                <div class="p-3 rounded-3 <?php echo e($message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light'); ?>"
                     style="max-width:70%">
                    <p class="mb-1"><?php echo e($message->body); ?></p>

                    <?php if($message->attachment): ?>
                    <div class="mt-2">
                        <a href="<?php echo e(url('tenant-files/' . $message->attachment)); ?>"
                           target="_blank"
                           class="btn btn-sm <?php echo e($message->sender_id == auth()->id() ? 'btn-light' : 'btn-outline-primary'); ?>">
                            <i class="bi bi-paperclip me-1"></i> تحميل المرفق
                        </a>
                    </div>
                    <?php endif; ?>

                    <small class="opacity-75 d-block mt-1"><?php echo e($message->created_at->diffForHumans()); ?></small>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center text-muted">لا توجد رسائل بعد</p>
            <?php endif; ?>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('messaging.send')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="receiver_id" value="<?php echo e($user->id); ?>">
        <div class="card shadow-sm">
            <div class="card-body">
                <textarea name="body" class="form-control mb-2" rows="2" placeholder="اكتب رسالتك..." required></textarea>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <label class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-paperclip"></i> إرفاق ملف
                            <input type="file" name="attachment" class="d-none">
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i> إرسال
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.tenant', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\saas-messaging-complete\project\modules/Messaging/Views/messages/conversation.blade.php ENDPATH**/ ?>