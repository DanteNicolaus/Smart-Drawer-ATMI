<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\LaciController;
use App\Http\Controllers\Admin\LabController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\KatalogController;
use App\Http\Controllers\UserAdmin\UserManagementController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// About & Contact Pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Dashboard route (redirect based on role)
Route::get('/dashboard', function () {
    if (auth()->check()) {
        $user = auth()->user();
        
        if ($user->isSuperAdmin()) {
            return redirect()->route('super-admin.dashboard');
        }
        
        if ($user->isUserAdmin()) {
            return redirect()->route('user-admin.dashboard');
        }
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/peminjaman/export', [SuperAdminController::class, 'export'])->name('peminjaman.export');
    Route::get('/peminjaman/export-pdf', [SuperAdminController::class, 'exportPDF'])->name('peminjaman.export-pdf');
    
    Route::get('/admins', [SuperAdminController::class, 'adminIndex'])->name('admins.index');
    Route::get('/admins/create', [SuperAdminController::class, 'adminCreate'])->name('admins.create');
    Route::post('/admins', [SuperAdminController::class, 'adminStore'])->name('admins.store');
    Route::get('/admins/{admin}/edit', [SuperAdminController::class, 'adminEdit'])->name('admins.edit');
    Route::put('/admins/{admin}', [SuperAdminController::class, 'adminUpdate'])->name('admins.update');
    Route::delete('/admins/{admin}', [SuperAdminController::class, 'adminDestroy'])->name('admins.destroy');
    
    Route::get('/users', [SuperAdminController::class, 'userIndex'])->name('users.index');
    Route::get('/users/create', [SuperAdminController::class, 'userCreate'])->name('users.create');
    Route::post('/users', [SuperAdminController::class, 'userStore'])->name('users.store');
    Route::get('/users/{user}/edit', [SuperAdminController::class, 'userEdit'])->name('users.edit');
    Route::put('/users/{user}', [SuperAdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{user}', [SuperAdminController::class, 'userDestroy'])->name('users.destroy');
    
    Route::get('/alat', [SuperAdminController::class, 'alatIndex'])->name('alat.index');
    Route::get('/alat/create', [SuperAdminController::class, 'alatCreate'])->name('alat.create');
    Route::post('/alat', [SuperAdminController::class, 'alatStore'])->name('alat.store');
    Route::get('/alat/{alat}', [SuperAdminController::class, 'alatShow'])->name('alat.show');
    Route::get('/alat/{alat}/edit', [SuperAdminController::class, 'alatEdit'])->name('alat.edit');
    Route::put('/alat/{alat}', [SuperAdminController::class, 'alatUpdate'])->name('alat.update');
    Route::delete('/alat/{alat}', [SuperAdminController::class, 'alatDestroy'])->name('alat.destroy');
    Route::post('/alat/{alat}/toggle-status', [SuperAdminController::class, 'alatToggleStatus'])->name('alat.toggle-status');
    
    Route::get('/peminjaman', [SuperAdminController::class, 'peminjamanIndex'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [SuperAdminController::class, 'peminjamanCreate'])->name('peminjaman.create');
    Route::post('/peminjaman', [SuperAdminController::class, 'peminjamanStore'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}', [SuperAdminController::class, 'peminjamanShow'])->name('peminjaman.show');
    Route::put('/peminjaman/{peminjaman}/approve', [SuperAdminController::class, 'peminjamanApprove'])->name('peminjaman.approve');
    Route::put('/peminjaman/{peminjaman}/reject', [SuperAdminController::class, 'peminjamanReject'])->name('peminjaman.reject');
    Route::put('/peminjaman/{peminjaman}/process', [SuperAdminController::class, 'peminjamanProcess'])->name('peminjaman.process');
    Route::put('/peminjaman/{peminjaman}/return', [SuperAdminController::class, 'peminjamanReturn'])->name('peminjaman.return');
    Route::delete('/peminjaman/{peminjaman}', [SuperAdminController::class, 'peminjamanDestroy'])->name('peminjaman.destroy');
    
    Route::get('/riwayat-peminjaman', [SuperAdminController::class, 'riwayatPeminjaman'])->name('riwayat-peminjaman');
});

/*
|--------------------------------------------------------------------------
| User Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user_admin'])->prefix('user-admin')->name('user-admin.')->group(function () {
    
    Route::get('/dashboard', [UserManagementController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/export/excel', [UserManagementController::class, 'exportExcel'])->name('users.export-excel');
    Route::get('/users/export/pdf', [UserManagementController::class, 'exportPdf'])->name('users.export-pdf');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Admin Lab)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [AdminDashboardController::class, 'getDashboardData'])->name('dashboard.data');
    
    // Alat Management
    Route::resource('alat', AlatController::class);
    Route::post('alat/{alat}/toggle-status', [AlatController::class, 'toggleStatus'])->name('alat.toggle-status');

    // Laci Management
    Route::resource('laci', LaciController::class);

    // Lab Management
    Route::resource('lab', LabController::class);
    
    // Peminjaman Management
    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::put('peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::put('peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::put('peminjaman/{peminjaman}/process', [PeminjamanController::class, 'process'])->name('peminjaman.process');
    Route::put('peminjaman/{peminjaman}/return', [PeminjamanController::class, 'return'])->name('peminjaman.return');
    Route::delete('peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    Route::get('/peminjaman/export/excel', [PeminjamanController::class, 'exportExcel'])->name('peminjaman.export-excel');
    Route::get('/peminjaman/export/pdf', [PeminjamanController::class, 'exportPdf'])->name('peminjaman.export-pdf');
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Katalog
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
    Route::get('/katalog/{lab}', [KatalogController::class, 'byLab'])->name('katalog.lab');
    Route::get('/katalog/{lab}/{laci}', [KatalogController::class, 'byLaci'])->name('katalog.laci');
    Route::get('/alat/{alat}', [UserDashboardController::class, 'detailAlat'])->name('alat.detail');
    
    // Riwayat Peminjaman
    Route::get('/riwayat', [UserDashboardController::class, 'riwayat'])->name('riwayat');
    Route::get('/peminjaman/{peminjaman}', [UserDashboardController::class, 'detailPeminjaman'])->name('peminjaman.detail');
    
    // Setting Profile
    Route::get('/settings', [UserDashboardController::class, 'settings'])->name('settings');
    Route::put('/update-profile', [UserDashboardController::class, 'updateProfile'])->name('update-profile');
    Route::post('/toggle-google-login', [UserDashboardController::class, 'toggleGoogleLogin'])->name('toggle-google-login');
    Route::put('/update-password', [UserDashboardController::class, 'updatePassword'])->name('update-password');
    Route::get('/riwayat/export-pdf', [UserDashboardController::class, 'exportPdf'])->name('riwayat.export-pdf');
    Route::get('/riwayat/export-excel', [UserDashboardController::class, 'exportExcel'])->name('riwayat.export-excel');
});

/*
|--------------------------------------------------------------------------
| Redirect Route
|--------------------------------------------------------------------------
*/

Route::get('/redirect', function () {
    $user = auth()->user();
    
    if ($user->isSuperAdmin()) {
        return redirect()->route('super-admin.dashboard');
    }
    
    if ($user->isUserAdmin()) {
        return redirect()->route('user-admin.dashboard');
    }
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('redirect');

Route::get('/check-session-status', function () {
    if (!auth()->check()) {
        return response()->json(['authenticated' => false]);
    }
 
    $loginTime = session('login_time');
    if (!$loginTime) {
        session(['login_time' => time()]);
        return response()->json(['authenticated' => true]);
    }
 
    $lifetimeSeconds = config('session.lifetime') * 60;
    $elapsed = time() - $loginTime;
 
    if ($elapsed >= $lifetimeSeconds) {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return response()->json(['authenticated' => false]);
    }
 
    return response()->json(['authenticated' => true]);
});