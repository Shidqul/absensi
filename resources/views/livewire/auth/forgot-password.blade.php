<?php

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $username = '';

    /**
     * Send a password reset link to the email found by username.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'username' => ['required', 'string'],
        ]);

        $user = User::where('username', $this->username)->first();

        if ($user && $user->email) {
            Password::sendResetLink(['email' => $user->email]);
        }

        session()->flash('status', __('Link reset akan dikirim jika akun ditemukan.'));
    }
}; ?>

<style>
    body {
        min-height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(180deg, #c7eafd 0%, #6e9edc 100%);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .recovery-container {
        background: white;
        padding: 2.5rem 2rem;
        border-radius: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.10);
        width: 370px;
        margin: 40px auto;
        text-align: center;
    }

    .recovery-container h2 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.3rem;
        color: #222;
    }

    .recovery-container p.subtitle {
        color: #555;
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.3rem;
        text-align: left;
        font-size: 0.95rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        color: #000000;
    }

    .form-group input[type="text"] {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid #000000;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #333;
        outline: none;
        box-sizing: border-box;
        background: #fff;
    }

    .btn-primary {
        width: 100%;
        padding: 12px 0;
        background: #4459AB;
        color: white;
        font-size: 1.05rem;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        margin-bottom: 1rem;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background: #354888;
    }

    .btn-outline {
        width: 100%;
        padding: 12px 0;
        background: #fff;
        color: #222;
        font-size: 1.05rem;
        border: 1.5px solid #222;
        border-radius: 12px;
        cursor: pointer;
        transition: background 0.3s, color 0.3s;
    }

    .btn-outline:hover {
        background: #f2f3f7;
        color: #4459AB;
        border-color: #4459AB;
    }

    .status-message {
        color: #4459AB;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        text-align: center;
    }
</style>

<div class="recovery-container">
    <h2>Pemulihan Akun</h2>
    <p class="subtitle">Silahkan masukkan username akun Anda.</p>

    @if (session('status'))
        <div class="status-message">{{ session('status') }}</div>
    @endif

    <form method="POST" wire:submit="sendPasswordResetLink">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" wire:model.defer="username" required autofocus
                placeholder="example4455">
            @error('username')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <div class="text-center text-sm text-zinc-500 dark:text-zinc-400">
                <button type="submit" class="btn-primary mt-3">Selanjutnya</button>
                <span>ingin kembali ke,</span>
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">
                    login
                </a>
            </div>

    </form>
</div>
