<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\AuthController;

//Route::get('/', function () {
//return view('welcome');
//})->name('home');

// Ganti route '/' menjadi redirect ke /login
Route::redirect('/', '/login');

Route::get('/dashboardadmin', function () {
    return view('admin.admin-dashboard');
});

Route::get('/persetamagang', function () {
    return view('admin.perserta-magang');
});

Route::get('/laporan', function () {
    return view('admin.laporan-izin');
});
route::get('/laporanmagang', function () {
    return view('admin.laporan-magang');
});

Route::get('/dataabsensi', function () {
    return view('admin.data-absensi');
});

Route::get('/dashboard', function () {
    return view('dasboarduser.dasboard-home');
});

//Route::view('dashboard', 'dashboard')
//->middleware(['auth', 'verified'])
//->name('dashboard');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
//Route::middleware(['auth'])->group(function () {
//Route::redirect('settings', 'settings/profile');

//Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
//Volt::route('settings/password', 'settings.password')->name('password.edit');
//Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

//Volt::route('settings/two-factor', 'settings.two-factor')
//->middleware(
//when(
//Features::canManageTwoFactorAuthentication()
//&& Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
//['password.confirm'],
//[],
// ),
// )
// ->name('two-factor.show');
//});

require __DIR__ . '/auth.php';
