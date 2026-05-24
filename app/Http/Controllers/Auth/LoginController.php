<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * التحكم في تسجيل الدخول
 * يدير دخول السوبر أدمن ومستخدمي الشركات
 */
class LoginController extends Controller
{
    // ===== السوبر أدمن =====

    public function showSuperAdminLogin()
    {
        return view('auth.super-admin-login');
    }

    public function superAdminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('super_admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('super-admin.dashboard');
        }

        return back()->withErrors(['email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'])->onlyInput('email');
    }

    public function superAdminLogout(Request $request)
    {
        Auth::guard('super_admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('super-admin.login');
    }

    public function showTenantLogin()
    {
        return view('auth.tenant-login');
    }

   public function tenantLogin(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended(route('tenant.dashboard'));
    }

    return back()->withErrors(['email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'])->onlyInput('email');
}

    public function tenantLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('tenant.login');
    }
}
