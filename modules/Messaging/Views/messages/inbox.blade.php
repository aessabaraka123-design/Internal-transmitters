@extends('layouts.tenant')
@section('title', 'صندوق الوارد')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-inbox text-primary me-2"></i>
        صندوق الوارد
        @if($unreadCount > 0)
            <span class="badge bg-danger">{{ $unreadCount }}</span>
        @endif
    </h4>
    <a href="{{ route('messaging.compose') }}" class="btn btn-primary">
        <i class="bi bi-pencil-square me-2"></i>رسالة جديدة
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @forelse($messages as $message)
        <div class="d-flex align-items-start p-3 border-bottom {{ !$message->is_read ? 'bg-primary bg-opacity-10' : '' }}"
             style="transition: background .2s">

            <a href="{{ route('messaging.conversation', $message->sender) }}"
               class="d-flex align-items-start flex-grow-1 text-decoration-none text-dark">

                <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                     style="width:45px;height:45px;background:#6c757d;color:white;font-size:18px;font-weight:bold">
                    {{ mb_substr($message->sender->name, 0, 1) }}
                </div>

                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="{{ !$message->is_read ? 'fw-bold' : '' }}">{{ $message->sender->name }}</span>
                            <small class="text-muted ms-2">{{ $message->sender->department }}</small>
                        </div>
                        <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-0 text-muted mt-1">{{ Str::limit($message->body, 120) }}</p>
                    @if($message->attachment)
                        <small class="text-primary"><i class="bi bi-paperclip me-1"></i>مرفق</small>
                    @endif
                </div>
            </a>

            <div class="d-flex gap-2 ms-3 align-items-center">
                @if(!$message->is_read)
                    <span class="badge bg-primary">جديد</span>
                @endif
                <form method="POST" action="{{ route('messaging.destroy', $message) }}"
                      onsubmit="return confirm('حذف الرسالة؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center text-muted py-5">
            <i class="bi bi-inbox fs-1 d-block mb-3 text-primary"></i>
            <h5>صندوق الوارد فارغ</h5>
            <p>لا توجد رسائل واردة حتى الآن</p>
        </div>
        @endforelse
    </div>

    @if($messages->hasPages())
    <div class="card-footer bg-white">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection