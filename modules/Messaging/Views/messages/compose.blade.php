@extends('layouts.tenant')
@section('title', 'رسالة جديدة')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-pencil-square text-primary me-2"></i>رسالة جديدة
    </h4>
</div>

<div class="card border-0 shadow-sm" style="max-width: 700px">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('messaging.send') }}" enctype="multipart/form-data">
            @csrf

            <!-- المُستقبِل -->
            <div class="mb-3">
                <label class="form-label fw-bold">إرسال إلى <span class="text-danger">*</span></label>
                <select name="receiver_id" class="form-select @error('receiver_id') is-invalid @enderror" required>
                    <option value="">-- اختر موظفاً --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->department ?? 'بدون قسم' }})
                        </option>
                    @endforeach
                </select>
                @error('receiver_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- نص الرسالة -->
            <div class="mb-3">
                <label class="form-label fw-bold">الرسالة <span class="text-danger">*</span></label>
                <textarea name="body" rows="6"
                          class="form-control @error('body') is-invalid @enderror"
                          placeholder="اكتب رسالتك هنا..."
                          required>{{ old('body') }}</textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- مرفق -->
            <div class="mb-4">
                <label class="form-label fw-bold">مرفق (اختياري)</label>
                <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror">
                <div class="form-text">الحجم الأقصى: 5MB</div>
                @error('attachment')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-send me-2"></i>إرسال
                </button>
                <a href="{{ route('messaging.inbox') }}" class="btn btn-outline-secondary">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
