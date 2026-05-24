<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * نموذج المستخدم داخل كل شركة
 * يُخزَّن في قاعدة بيانات الشركة المنفصلة
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',         // admin | employee
        'department',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
        'password'          => 'hashed',
    ];

    /**
     * هل المستخدم مدير الشركة؟
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * الرسائل التي أرسلها هذا المستخدم
     */
    public function sentMessages()
    {
        return $this->hasMany(\Modules\Messaging\Models\Message::class, 'sender_id');
    }

    /**
     * الرسائل التي استقبلها هذا المستخدم
     */
    public function receivedMessages()
    {
        return $this->hasMany(\Modules\Messaging\Models\Message::class, 'receiver_id');
    }
}
