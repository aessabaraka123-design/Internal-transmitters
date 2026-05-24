<?php

namespace Database\Seeders;

use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء السوبر أدمن فقط
        SuperAdmin::firstOrCreate(
            ['email' => 'admin@saas-messaging.com'],
            [
                'name'     => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );

        $this->command->info('✅ تم إنشاء السوبر أدمن: admin@saas-messaging.com / password');
        $this->command->info('💡 سجّل دخول وأنشئ الشركات من لوحة التحكم');
    }
}