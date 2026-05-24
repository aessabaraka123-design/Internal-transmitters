<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
 
class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::latest()->paginate(15);
        return view('tenants.index', compact('tenants'));
    }
 
    public function registerForm()
    {
        $plans = Tenant::plans();
        return view('register', compact('plans'));
    }
 
    public function register(Request $request)
    {
        $validated = $request->validate([
            'company_name'   => 'required|string|max:100',
            'email'          => 'required|email|unique:tenants,email',
            'plan'           => 'required|in:basic,pro,enterprise',
            'subdomain'      => [
                'required',
                'alpha_dash',
                function ($attribute, $value, $fail) {
                    $domain = $value . '.saas-messaging.test';
                    if (\Stancl\Tenancy\Database\Models\Domain::where('domain', $domain)->exists()) {
                        $fail('هذا النطاق الفرعي مستخدم مسبقاً، اختر اسماً آخر.');
                    }
                },
            ],
            'admin_name'     => 'required|string|max:100',
            'admin_email'    => 'required|email',
            'admin_password' => 'required|min:6|confirmed',
        ], [
            'email.unique'        => 'هذا الإيميل مسجّل لشركة أخرى',
            'company_name.required' => 'اسم الشركة مطلوب',
            'admin_password.min'  => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
            'admin_password.confirmed' => 'كلمة المرور غير متطابقة',
        ]);
 
        $plans = Tenant::plans();
        $plan  = $plans[$validated['plan']];
 
        $tenant = new Tenant();
        $tenant->id                   = Str::slug($validated['company_name']) . '-' . Str::random(4);
        $tenant->company_name         = $validated['company_name'];
        $tenant->email                = $validated['email'];
        $tenant->plan                 = $validated['plan'];
        $tenant->is_active            = true;
        $tenant->max_users            = $plan['max_users'];
        $tenant->trial_ends_at        = now()->addDays(14);
        $tenant->subscription_ends_at = now()->addMonth();
        $tenant->saveQuietly();
 
        $domain = $validated['subdomain'] . '.saas-messaging.test';
        $tenant->domains()->create(['domain' => $domain]);
 
        $dbName = 'tenant_' . $tenant->id;
        DB::statement("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
 
        config(['database.connections.tenant_temp' => array_merge(
            config('database.connections.mysql'),
            ['database' => $dbName]
        )]);
 
        Artisan::call('migrate', [
            '--database' => 'tenant_temp',
            '--path'     => 'database/migrations/tenant',
            '--force'    => true,
        ]);
 
        DB::connection('tenant_temp')->table('users')->insert([
            'name'       => $validated['admin_name'],
            'email'      => $validated['admin_email'],
            'password'   => bcrypt($validated['admin_password']),
            'role'       => 'admin',
            'is_active'  => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::firstOrCreate(
            ['email' => $validated['admin_email']],
            [
                'name'      => $validated['admin_name'],
                'password'  => bcrypt($validated['admin_password']),
                'is_active' => true,
            ]
        );
 
        return redirect()->route('tenant.login')
            ->with('success', "✅ تم إنشاء شركة {$validated['company_name']} بنجاح! يمكنك تسجيل الدخول الآن.");
    }
 
    public function show(Tenant $tenant)
    {
        return view('admin.tenants.show', compact('tenant'));
    }
 
    public function create()
    {
        $plans = Tenant::plans();
        return view('tenants.create', compact('plans'));
    }
 
    public function store(Request $request)
    {
        return $this->register($request);
    }
 
    public function edit(Tenant $tenant)
    {
        $plans = Tenant::plans();
        return view('admin.tenants.edit', compact('tenant', 'plans'));
    }
 
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'company_name'         => 'required|string|max:100',
            'plan'                 => 'required|in:basic,pro,enterprise',
            'subscription_ends_at' => 'required|date',
        ]);
 
        $tenant->update($validated);
 
        return redirect()->route('super-admin.tenants.index')
            ->with('success', 'تم تحديث بيانات الشركة بنجاح');
    }
 
    public function destroy(Tenant $tenant)
    {
        $dbName = 'tenant_' . $tenant->id;
        DB::statement("DROP DATABASE IF EXISTS `{$dbName}`");
 
        $tenant->domains()->delete();
        $tenant->delete();
 
        return redirect()->route('super-admin.tenants.index')
            ->with('success', 'تم حذف الشركة بنجاح');
    }
 
    public function toggleStatus(Tenant $tenant)
    {
        $tenant->update(['is_active' => !$tenant->is_active]);
        $status = $tenant->is_active ? 'تفعيل' : 'إيقاف';
        return back()->with('success', "تم {$status} الشركة بنجاح");
    }
 
    public function extendSubscription(Request $request, Tenant $tenant)
    {
        $request->validate(['months' => 'required|integer|min:1|max:12']);
 
        $tenant->update([
            'subscription_ends_at' => now()->addMonths($request->months),
        ]);
 
        return back()->with('success', "تم تمديد الاشتراك لمدة {$request->months} شهر");
    }
}