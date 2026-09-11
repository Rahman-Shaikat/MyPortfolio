<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function showLoginForm(Request $request): View|RedirectResponse
    {
        if ($this->isAuthenticated($request)) {
            return to_route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(AdminLoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $adminEmail = (string) config('admin.email');
        $adminPasswordHash = (string) config('admin.password_hash');

        if (
            $adminEmail === ''
            || $adminPasswordHash === ''
            || ! hash_equals(mb_strtolower($adminEmail), mb_strtolower($credentials['email']))
            || ! Hash::check($credentials['password'], $adminPasswordHash)
        ) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are invalid.',
            ]);
        }

        $request->session()->regenerate();
        $request->session()->put('admin_authenticated', true);

        return to_route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('admin.login');
    }

    private function isAuthenticated(Request $request): bool
    {
        return (bool) $request->session()->get('admin_authenticated', false);
    }
}
