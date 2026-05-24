@extends('layouts.tenant')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">📤 الرسائل المُرسَلة</h4>
        <a href="{{ route('messaging.compose') }}" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i> رسالة جديدة
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="list-group list-group-flush">
            @forelse($messages as $message)
            <a href="{{ route('messaging.conversation', $message->receiver) }}"
               class="list-group-item list-group-item-action py-3 text-decoration-none">
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">إلى: {{ $message->receiver->name ?? 'محذوف' }}</span>
                    <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-0 text-muted small">{{ Str::limit($message->body, 100) }}</p>
                @if($message->attachment)
                    <small class="text-primary"><i class="bi bi-paperclip me-1"></i>مرفق</small>
                @endif
            </a>
            @empty
            <div class="list-group-item text-center text-muted py-5">
                لا توجد رسائل مُرسَلة
            </div>
            @endforelse
        </div>
    </div>

    <div class="mt-3">{{ $messages->links() }}</div>
</div>
@endsection