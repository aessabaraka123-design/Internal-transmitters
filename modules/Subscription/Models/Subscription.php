<?php

namespace Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * نموذج الاشتراك داخل كل شركة
 * يسجّل تاريخ الاشتراكات والتجديدات
 */
class Subscription extends Model
{
    protected $fillable = [
        'plan',
        'price',
        'starts_at',
        'ends_at',
        'status',
        'payment_reference',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'price'     => 'decimal:2',
    ];

    /**
     * هل الاشتراك نشط حالياً؟
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->ends_at->isFuture();
    }

    /**
     * الاشتراك الحالي النشط
     */
    public static function current()
    {
        return static::where('status', 'active')
                     ->where('ends_at', '>', now())
                     ->latest()
                     ->first();
    }

    /**
     * اسم الخطة بالعربي
     */
    public function getPlanNameAttribute(): string
    {
        return Tenant::plans()[$this->plan]['name'] ?? $this->plan;
    }
}
