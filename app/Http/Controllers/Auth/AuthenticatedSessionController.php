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
     *
     * Internal users:
     * - CC Room
     * - Manager Keuangan
     * - Manager Operasional
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
        $request->authenticate([
            'pengguna',
        ]);

        $request->session()->regenerate();

        return redirect()->intended(
            route('dashboard', absolute: false)
        );
    }

    /**
     * Handle login for internal users.
     *
     * Allowed roles:
     * - CC Room
     * - Manager Keuangan
     * - Manager Operasional
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
        );
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
