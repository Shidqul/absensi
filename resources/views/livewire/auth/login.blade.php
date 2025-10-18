<?php

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        $user = $this->validateCredentials();

        if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
            Session::put([
                'login.id' => $user->getKey(),
                'login.remember' => $this->remember,
            ]);

            $this->redirect(route('two-factor.login'), navigate: true);

            return;
        }

        Auth::login($user, $this->remember);

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        //$this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);

        if (!$user || !Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return $user;
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}; ?>

<link rel="icon" type="image/png" href="{{ asset('assets/img/Pictorial Mark Logo - AMPEL.png') }}" sizes="32x32">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login AMPEL</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/Pictorial Mark Logo - AMPEL.png') }}" sizes="32x32">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        /* ...CSS Anda di sini... */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(180deg, #3BA1F9 0%, #4259AA 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-x: hidden;
        }

        .login-container {
            background: white;
            padding: 3rem 2rem;
            border-radius: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 18px;
            margin-bottom: 1.2rem;
        }

        .logo-row img {
            height: 38px;
            width: auto;
        }

        .welcome-text h2 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.3rem;
        }

        .welcome-text p {
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.3rem;
            text-align: left;
            font-size: 0.85rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #000000;
            font-weight: 500;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #3BA1F9;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #333;
            outline: none;
            background: #fff;
        }

        .input-password-wrapper {
            position: relative;
            width: 100%;
        }

        /* Style input password */
        .input-password-wrapper input[type="password"],
        .input-password-wrapper input[type="text"] {
            width: 100%;
            padding: 10px 42px 10px 12px;
            /* ruang kanan untuk ikon */
            border: 1.5px solid #3BA1F9;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #333;
            outline: none;
            box-sizing: border-box;
            background: #fff;
            transition: border-color 0.2s ease;
            line-height: 1.4;
        }

        .input-password-wrapper input:focus {
            border-color: #6671A6;
        }

        /* Tombol ikon mata */
        .password-toggle-btn {
            position: absolute;
            top: 65%;
            right: 14px;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            padding: 0;
            margin: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 24px;
            width: 24px;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        /* Saat hover */
        .password-toggle-btn:hover svg {
            opacity: 0.8;
            transform: scale(1.05);
        }

        /* SVG ikon mata */
        .password-toggle-btn svg {
            width: 20px;
            height: 20px;
            stroke: #6671A6;
            transition: all 0.2s ease;
        }

        a.forgot-password {
            font-size: 0.85rem;
            text-decoration: none;
            color: #3BA1F9;
            display: block;
            text-align: right;
            margin-top: 0.5rem;
            margin-bottom: 1.5rem;
        }

        a.forgot-password:hover {
            text-decoration: underline;
        }

        .captcha-wrapper {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: center;
        }

        button.login-btn {
            width: 100%;
            padding: 12px 0;
            background: #4459AB;
            color: white;
            font-size: 1.05rem;
            font-weight: 500;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button.login-btn:hover {
            background: #354888;
        }

        .register-text {
            margin-top: 1.3rem;
            font-size: 0.9rem;
            color: #666;
        }

        .register-text a {
            color: #3BA1F9;
            text-decoration: none;
            font-weight: 500;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        /* Responsif untuk tablet */
        @media screen and (max-width: 768px) {
            .login-container {
                padding: 2.5rem 1.5rem;
                border-radius: 25px;
                max-width: 380px;
            }

            .welcome-text h2 {
                font-size: 1.6rem;
            }

            .welcome-text p {
                font-size: 0.9rem;
            }
        }

        /* Responsif untuk mobile */
        @media screen and (max-width: 480px) {
            body {
                padding: 15px;
            }

            .login-container {
                padding: 2rem 1.5rem;
                border-radius: 20px;
                max-width: 100%;
            }

            .logo-row {
                gap: 12px;
                margin-bottom: 1rem;
            }

            .logo-row img {
                height: 32px;
            }

            .welcome-text h2 {
                font-size: 1.5rem;
                margin-bottom: 0.25rem;
            }

            .welcome-text p {
                font-size: 0.85rem;
                margin-bottom: 1.2rem;
            }

            .form-group {
                margin-bottom: 1.1rem;
            }

            .form-group label {
                font-size: 0.8rem;
                margin-bottom: 5px;
            }

            .form-group input[type="text"],
            .form-group input[type="password"] {
                padding: 9px 10px;
                font-size: 0.9rem;
            }

            .password-toggle-btn {
                width: 26px;
                height: 26px;
            }

            .password-toggle-btn svg {
                width: 18px;
                height: 18px;
            }

            a.forgot-password {
                font-size: 0.8rem;
            }

            button.login-btn {
                padding: 11px 0;
                font-size: 1rem;
                border-radius: 10px;
            }

            .register-text {
                font-size: 0.85rem;
                margin-top: 1.2rem;
            }

            .captcha-wrapper {
                margin-bottom: 1.2rem;
                transform: scale(0.9);
            }
        }

        /* Responsif untuk mobile sangat kecil */
        @media screen and (max-width: 360px) {
            .login-container {
                padding: 1.5rem 1.2rem;
            }

            .welcome-text h2 {
                font-size: 1.3rem;
            }

            .logo-row img {
                height: 28px;
            }

            .captcha-wrapper {
                transform: scale(0.85);
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Logo Row -->
        <div class="logo-row">
            <img src="{{ asset('assets/img/Logo PT Pelindo (Symbol Only).png') }}" alt="Polindo Logo">
            <img src="{{ asset('assets/img/Combination Mark Logo - AMPEL.png') }}" alt="AMPEL Logo">
        </div>


        <!-- Welcome Text -->
        <div class="welcome-text">
            <h2>Welcome Back</h2>
            <p>Hello there, login to continue</p>
        </div>


        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                    style="width:100%;padding:10px 12px;border:1.5px solid #3BA1F9;border-radius:8px;font-size:0.95rem;color:#333;outline:none;box-sizing:border-box;background:#fff;"
                    placeholder="example4455">
                @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group input-password-wrapper" style="position:relative;">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required
                    style="width:100%;padding:10px 40px 10px 12px;border:1.5px solid #3BA1F9;border-radius:8px;font-size:0.95rem;color:#333;outline:none;box-sizing:border-box;background:#fff;"
                    placeholder="Password">
                <button type="button" id="togglePassword" class="password-toggle-btn" tabindex="-1"
                    aria-label="Show password">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="#6671A6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" />
                        <circle cx="12" cy="12" r="3" stroke="#6671A6" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>


            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password mt-3">Lupa Password ?</a>
            @endif

            <form action="?" method="POST">
                <div class="g-recaptcha" data-sitekey="6LdzltsrAAAAAKGkeTCnMentVy2IOvSd4SctwftE"></div>
                <br />
                <input type="submit" value="Submit">

                <button type="submit" class="login-btn">Login</button>
            </form>


            <div class="text-center text-sm text-zinc-500 dark:text-zinc-400 mt-3">
                <span>Belum punya akun?</span>
                <a href="{{ route('register') }}" class="ml-1 font-medium text-blue-600 hover:underline">
                    Daftar
                </a>
            </div>


    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Ganti icon open/close
            if (type === 'password') {
                eyeIcon.innerHTML = `
                <path stroke="#6671A6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
                <circle cx="12" cy="12" r="3" stroke="#6671A6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            `;
            } else {
                eyeIcon.innerHTML = `
                <path stroke="#6671A6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.77 21.77 0 0 1 5.06-6.06M1 1l22 22"/>
                <path stroke="#6671A6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M9.53 9.53A3 3 0 0 0 12 15a3 3 0 0 0 2.47-5.47"/>
            `;
            }
        });
    </script>


</body>

</html>
