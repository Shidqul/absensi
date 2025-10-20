<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $first_name = '';
    public string $last_name = '';
    public string $school = '';
    public string $supervisor = '';
    public string $intern_period = '';
    public $cv;
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $agree = false;

    protected function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'school' => ['required', 'string', 'max:255'],
            'supervisor' => ['required', 'string', 'max:255'],
            'intern_period' => ['required', 'string', 'max:255'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'agree' => ['accepted'],
        ];
    }

    public function register(): void
    {
        $validated = $this->validate();

        if ($this->cv) {
            $validated['cv'] = $this->cv->store('cv', 'public');
        }

        $validated['name'] = $validated['first_name'] . ' ' . $validated['last_name'];
        $validated['password'] = Hash::make($validated['password']);

        unset($validated['first_name'], $validated['last_name'], $validated['password_confirmation'], $validated['agree']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
    html,
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        overflow-y: auto;
    }

    body {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
        background: linear-gradient(180deg, #A8D5F0 0%, #5B8BC5 100%);
        padding: 40px 20px;
        box-sizing: border-box;
    }

    .register-container {
        background: #ffffff;
        padding: 3rem 3.5rem;
        border-radius: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        width: 200%;
        max-width: 780px;
        box-sizing: border-box;
    }

    .register-header {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.5rem;
    }

    .register-header img {
        height: 45px;
    }

    .register-title {
        text-align: center;
        margin-bottom: 0.3rem;
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        letter-spacing: -0.02em;
    }

    .register-subtitle {
        text-align: center;
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 2rem;
        font-weight: 400;
    }

    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 8px;
        color: #1a1a1a;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"],
    .form-group input[type="tel"],
    .form-group input[type="date"] {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #D1D5DB;
        border-radius: 12px;
        font-size: 0.95rem;
        color: #333;
        outline: none;
        box-sizing: border-box;
        background: #fff;
        transition: all 0.2s ease;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="email"]:focus,
    .form-group input[type="password"]:focus,
    .form-group input[type="tel"]:focus {
        border: 1.5px solid #5B8BC5;
        box-shadow: 0 0 0 3px rgba(91, 139, 197, 0.1);
    }

    .form-group input::placeholder {
        color: #9CA3AF;
        font-weight: 400;
    }

    .input-file-wrapper {
        position: relative;
    }

    .input-file-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #E8ECF1;
        border-radius: 12px;
        padding: 12px 16px;
        cursor: pointer;
        border: 1.5px solid #D1D5DB;
        font-size: 0.875rem;
        color: #6B7280;
        transition: all 0.2s ease;
        width: 100%;
        box-sizing: border-box;
    }

    .input-file-label:hover {
        border: 1.5px solid #5B8BC5;
        background: #DDE4ED;
    }

    .input-file-label svg {
        width: 20px;
        height: 20px;
    }

    input[type="file"] {
        display: none;
    }

    .period-wrapper input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0;
        width: 100%;
        height: 100%;
        position: absolute;
        right: 0;
        top: 0;
        cursor: pointer;
    }

    .period-wrapper {
        position: relative;
    }

    .period-icon {
        pointer-events: none;
    }

    /* Tombol ikon mata */
    .password-toggle-btn {
        position: absolute;
        right: 15px;
        top: 40px;
        background: transparent;
        border: none;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0;
        transition: opacity 0.2s;
    }

    .password-toggle-btn:hover {
        opacity: 0.7;
    }

    .password-toggle-btn svg {
        width: 20px;
        height: 20px;
    }

    .input-password-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .checkbox-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 1.5rem;
        margin-top: 0.5rem;
    }

    .checkbox-row input[type="checkbox"] {
        accent-color: #0574fc;
        width: 18px;
        height: 18px;
        border-radius: 4px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .checkbox-row label {
        color: #4B5563;
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1.5;
        margin-bottom: 0;
    }

    .checkbox-row a {
        color: #3B82F6;
        text-decoration: none;
        font-weight: 500;
    }

    .checkbox-row a:hover {
        text-decoration: underline;
    }

    button.register-btn {
        width: 100%;
        padding: 14px 0;
        background: #5B6FB8;
        color: white;
        font-size: 1rem;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        margin-bottom: 1rem;
        transition: background 0.3s ease;
        font-weight: 600;
        letter-spacing: 0.01em;
    }

    button.register-btn:hover {
        background: #4A5C98;
    }

    .register-footer {
        text-align: center;
        font-size: 0.9rem;
        color: #4B5563;
        margin-top: 0.5rem;
    }

    .register-footer a {
        color: #3B82F6;
        text-decoration: none;
        font-weight: 500;
    }

    .register-footer a:hover {
        text-decoration: underline;
    }

    .error-message {
        color: #DC2626;
        font-size: 0.8rem;
        margin-top: 4px;
    }

    @media (max-width: 900px) {
        .register-container {
            padding: 2rem 1.5rem;
            max-width: 95%;
        }

        .register-title {
            font-size: 1.75rem;
        }

        .form-row {
            gap: 0.8rem;
        }
    }

    @media (max-width: 768px) {
        body {
            padding: 20px 10px;
            align-items: flex-start;
        }

        .register-container {
            width: 100%;
            max-width: 100%;
            border-radius: 24px;
            padding: 1.5rem 1.2rem;
        }

        .form-row {
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .register-title {
            font-size: 1.5rem;
        }

        .register-header img {
            height: 35px;
        }

        .form-group input,
        .input-file-label {
            font-size: 0.9rem;
            padding: 11px 14px;
        }

        button.register-btn {
            font-size: 0.95rem;
            padding: 13px 0;
        }
    }

    @media (max-width: 480px) {
        .register-container {
            padding: 1.2rem 1rem;
        }

        .register-title {
            font-size: 1.3rem;
        }

        .register-header img {
            height: 30px;
        }

        .checkbox-row label {
            font-size: 0.8rem;
        }
    }

    .flatpickr-calendar {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
    }

    .flatpickr-day {
        color: #4a5568;
    }

    .flatpickr-day.selected {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .flatpickr-day:hover {
        background: #dbeafe;
    }

    .flatpickr-months .flatpickr-month {
        color: #111827;
    }

    .flatpickr-current-month .numInputWrapper {
        color: #111827;
    }

    .flatpickr-weekdays {
        color: #111827;
    }
</style>

<div class="register-container">
    <div class="register-header">
        <img src="{{ asset('assets/img/Logo PT Pelindo (Symbol Only).png') }}" alt="Polindo Logo">
        <img src="{{ asset('assets/img/Combination Mark Logo - AMPEL.png') }}" alt="AMPEL Logo">
    </div>
    <div class="register-title">Register Account</div>
    <div class="register-subtitle">Hello there, register to continue</div>

    <form method="POST" wire:submit="register" enctype="multipart/form-data" autocomplete="off">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="first_name">Nama Depan</label>
                <input type="text" id="first_name" name="first_name" wire:model.defer="first_name"
                    placeholder="Masukkan Nama Depan" required>
                @error('first_name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="last_name">Nama Belakang</label>
                <input type="text" id="last_name" name="last_name" wire:model.defer="last_name"
                    placeholder="Masukkan Nama Belakang" required>
                @error('last_name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="school">Sekolah/ Universitas</label>
                <input type="text" id="school" name="school" wire:model.defer="school"
                    placeholder="Asal Sekolah atau Universitas" required>
                @error('school')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="supervisor">Nama Pembimbing</label>
                <input type="text" id="supervisor" name="supervisor" wire:model.defer="supervisor"
                    placeholder="Masukkan Nama Pembimbing" required>
                @error('supervisor')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group period-wrapper">
                <label for="intern_period">Periode Magang</label>
                <input type="date" id="intern_period" name="intern_period" wire:model.defer="intern_period"
                    placeholder="Masukkan Periode Magang" required style="padding-right: 45px;">

                @error('intern_period')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group input-file-wrapper">
                <label for="cv">Upload CV</label>
                <label class="input-file-label">
                    <svg fill="none" stroke="#6B7280" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <span id="cv-label-text">Upload CV Anda disini</span>
                    <input type="file" id="cv" name="cv" wire:model="cv" accept=".pdf,.doc,.docx">
                </label>
                @error('cv')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" wire:model.defer="email"
                    placeholder="Masukkan Email Anda" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input type="tel" id="phone" name="phone" wire:model.defer="phone"
                    placeholder="Masukkan Nomor Telepon Anda" required>
                @error('phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group input-password-wrapper">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" wire:model.defer="password"
                    placeholder="Masukkan Password" required>
                <button type="button" id="togglePassword" class="password-toggle-btn" tabindex="-1"
                    aria-label="Show password">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group input-password-wrapper">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    wire:model.defer="password_confirmation" placeholder="Konfirmasi Password" required>
                <button type="button" id="togglePasswordConfirm" class="password-toggle-btn" tabindex="-1"
                    aria-label="Show password">
                    <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="checkbox-row">
            <input type="checkbox" id="agree" name="agree" wire:model.defer="agree" required>
            <label for="agree">
                Saya menyetujui
                <a href="#" target="_blank">Syarat dan Ketentuan</a>
                serta
                <a href="#" target="_blank">Kebijakan Privasi</a>
                yang berlaku di situs ini.
            </label>
        </div>
        @error('agree')
            <div class="error-message" style="margin-top: -12px; margin-bottom: 12px;">{{ $message }}</div>
        @enderror

        <button type="submit" class="register-btn">Register</button>
    </form>

    <div class="register-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </div>
</div>

<script>
    // Password toggle for password
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        if (type === 'password') {
            eyeIcon.innerHTML = `
                <path stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        } else {
            eyeIcon.innerHTML = `
                <path stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        }
    });

    // Password toggle for confirmation
    const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
    const passwordConfirm = document.querySelector('#password_confirmation');
    const eyeIconConfirm = document.querySelector('#eyeIconConfirm');

    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirm.setAttribute('type', type);

        if (type === 'password') {
            eyeIconConfirm.innerHTML = `
                <path stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        } else {
            eyeIconConfirm.innerHTML = `
                <path stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        }
    });

    // Show selected file name for CV
    const cvInput = document.querySelector('#cv');
    const cvLabelText = document.querySelector('#cv-label-text');
    if (cvInput && cvLabelText) {
        cvInput.addEventListener('change', function() {
            if (cvInput.files.length > 0) {
                cvLabelText.textContent = cvInput.files[0].name;
            } else {
                cvLabelText.textContent = 'Upload CV Anda disini';
            }
        });
    }

    flatpickr("#intern_period", {
        mode: "range",
        dateFormat: "d-m-Y",

    });
</script>
