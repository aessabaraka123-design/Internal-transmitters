@extends('layouts.tenant')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4 gap-3">
        <a href="{{ route('messaging.inbox') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-right"></i> رجوع
        </a>
        <h4 class="fw-bold mb-0">💬 محادثة مع {{ $user->name }}</h4>
    </div>

    <div class="card shadow-sm mb-3" style="max-height:500px; overflow-y:auto;" id="chat-box">
        <div class="card-body">
            @forelse($messages as $message)
            <div class="d-flex mb-3 {{ $message->sender_id == auth()->id() ? 'justify-content-end' : '' }}">
                <div class="p-3 rounded-3 {{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }}"
                     style="max-width:70%">
                    <p class="mb-1">{{ $message->body }}</p>

                    @if($message->attachment)
                    <div class="mt-2">
                        <a href="{{ url('tenant-files/' . $message->attachment) }}"
                           target="_blank"
                           class="btn btn-sm {{ $message->sender_id == auth()->id() ? 'btn-light' : 'btn-outline-primary' }}">
                            <i class="bi bi-paperclip me-1"></i> تحميل المرفق
                        </a>
                    </div>
                    @endif

                    <small class="opacity-75 d-block mt-1">{{ $message->created_at->diffForHumans() }}</small>
                </div>
            </div>
            @empty
            <p class="text-center text-muted">لا توجد رسائل بعد</p>
            @endforelse
        </div>
    </div>

    <form method="POST" action="{{ route('messaging.send') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
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
@endsection