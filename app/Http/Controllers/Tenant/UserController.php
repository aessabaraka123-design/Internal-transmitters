<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        $maxUsers = tenant('max_users') ?? 10;
        return view('tenant.users.index', compact('users', 'maxUsers'));
    }

    public function create()
    {
        $currentCount = User::count();
        $maxUsers     = tenant('max_users') ?? 10;

        if ($currentCount >= $maxUsers) {
            return redirect()->route('tenant.users.index')
                ->with('error', "وصلت للحد الأقصى ({$maxUsers} مستخدمين). يرجى ترقية الخطة.");
        }

        return view('tenant.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:8|confirmed',
            'role'       => 'required|in:admin,employee',
            'department' => 'nullable|string|max:100',
        ]);

        User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'password'   => bcrypt($validated['password']),
            'role'       => $validated['role'],
            'department' => $validated['department'],
        ]);

        return redirect()->route('tenant.users.index')
                         ->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function edit(User $user)
    {
        return view('tenant.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'role'       => 'required|in:admin,employee',
            'department' => 'nullable|string|max:100',
            'is_active'  => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('tenant.users.index')
                         ->with('success', 'تم تحديث بيانات المستخدم');
    }

    public function destroy(User $user)
    {
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف حسابك الخاص');
        }

        $user->delete();
        return redirect()->route('tenant.users.index')
                         ->with('success', 'تم حذف المستخدم');
    }
}
