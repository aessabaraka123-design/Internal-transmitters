<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

/**
 * نموذج الشركة (المستأجر)
 * كل شركة تشترك في النظام تُعامَل كـ Tenant منفصل
 * مع قاعدة بيانات خاصة بها
 */
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    /**
     * الحقول القابلة للتعبئة
     */
    protected $fillable = [
        'id',
        'company_name',
        'email',
        'plan',
        'is_active',
        'max_users',
        'trial_ends_at',
        'subscription_ends_at',
    ];

    /**
     * تحويل الأنواع تلقائياً
     */
    protected $casts = [
        'is_active'            => 'boolean',
        'trial_ends_at'        => 'datetime',
        'subscription_ends_at' => 'datetime',
        'data'                 => 'array',
    ];

    /**
     * الحقول المخزنة داخل عمود data (JSON)
     */
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'company_name',
            'email',
            'plan',
            'is_active',
            'max_users',
            'trial_ends_at',
            'subscription_ends_at',
        ];
    }

    /**
     * هل الاشتراك نشط؟
     */
    public function isSubscriptionActive(): bool
    {
        return $this->is_active &&
               $this->subscription_ends_at &&
               $this->subscription_ends_at->isFuture();
    }

    /**
     * هل في فترة التجربة؟
     */
    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * خطط الاشتراك المتاحة
     */
    public static function plans(): array
    {
        return [
            'basic'      => ['name' => 'أساسي',    'max_users' => 10,  'price' => 29],
            'pro'        => ['name' => 'احترافي',   'max_users' => 50,  'price' => 79],
            'enterprise' => ['name' => 'مؤسسي',     'max_users' => 500, 'price' => 199],
        ];
    }
}
