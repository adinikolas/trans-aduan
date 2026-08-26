<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @param array<string>|null $allowedRoles
     *
     * @throws ValidationException
     */
    public function authenticate(?array $allowedRoles = null): void
    {
        $this->ensureIsNotRateLimited();

        /*
         * Coba autentikasi menggunakan email dan password.
         */
        if (! Auth::attempt(
            $this->only('email', 'password'),
            $this->boolean('remember')
        )) {
            RateLimiter::hit($this->throttleKey());

            /*
             * Error kredensial ditampilkan di bawah Password.
             */
            throw ValidationException::withMessages([
                'password' => trans('auth.failed'),
            ]);
        }

        /*
         * Batasi role berdasarkan halaman login.
         *
         * Login Pengguna:
         *     ['pengguna']
         *
         * Login Internal:
         *     [
         *         'cc_room',
         *         'manager_keuangan',
         *         'manager_operasional',
         *     ]
         */
        if (
            $allowedRoles !== null &&
            ! in_array(Auth::user()->role, $allowedRoles, true)
        ) {
            Auth::logout();

            throw ValidationException::withMessages([
                'password' => 'Akun tidak memiliki akses ke halaman login ini.',
            ]);
        }

        /*
         * Login berhasil, reset rate limiter.
         */
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'password' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the login throttle key.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->string('email')) . '|' . $this->ip()
        );
    }
}
