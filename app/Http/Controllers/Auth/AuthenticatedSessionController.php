<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the public user login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Display the internal login page.
     */
    public function createInternal(): View
    {
        return view('auth.login-internal');
    }

    /**
     * Handle login for public users only.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(['pengguna']);
        $request->session()->regenerate();

        return redirect()->intended(
            route('dashboard', absolute: false)
        )->withCookie(cookie()->forget('login_type'));
    }

    /**
     * Handle login for internal users.
     */
    public function storeInternal(LoginRequest $request): RedirectResponse
    {
        $request->authenticate([
            'cc_room',
            'manager_keuangan',
            'manager_operasional',
        ]);

        $request->session()->regenerate();

        return redirect()->intended(
            route('dashboard', absolute: false)
        )->withCookie(cookie('login_type', 'internal', 43200));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $isInternal = $request->cookie('login_type') === 'internal';

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $response = redirect(
            $isInternal ? route('internal.login') : route('login')
        );

        return $response->withCookie(cookie()->forget('login_type'));
    }
}
