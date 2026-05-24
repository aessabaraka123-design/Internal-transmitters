<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * نموذج السوبر أدمن
 * يتحكم في جميع الشركات المشتركة
 * يُخزَّن في قاعدة البيانات الرئيسية (landlord)
 */
class SuperAdmin extends Authenticatable
{
    use Notifiable;

    protected $table = 'super_admins';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}
