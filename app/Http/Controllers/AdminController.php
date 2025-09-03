<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller
{
        public function showLogin()
    {
        // التحقق من وجود الأدمن الافتراضي وإنشاؤه إذا لم يكن موجوداً
        if (!Admin::where('email', 'admin@admin.com')->exists()) {
            Admin::create([
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
            ]);
        }

        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'بيانات تسجيل الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

        public function dashboard()
    {
        $totalCompanies = User::count();
        $recentCompanies = User::latest()->get(); // عرض جميع الشركات بدلاً من آخر 5

        return view('admin.dashboard', compact('totalCompanies', 'recentCompanies'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function storeCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'تم إضافة الشركة بنجاح');
    }

    public function deleteCompany(User $company)
    {
        try {
            // حذف جميع البيانات المرتبطة بالشركة
            $company->delete();

            return redirect()->route('admin.dashboard')
                ->with('success', 'تم حذف الشركة بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'حدث خطأ أثناء حذف الشركة');
        }
    }

    public function changeCompanyPassword(Request $request, User $company)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $company->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->route('admin.dashboard')
                ->with('success', "تم تغيير كلمة مرور شركة {$company->name} بنجاح");
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'حدث خطأ أثناء تغيير كلمة المرور');
        }
    }
}
