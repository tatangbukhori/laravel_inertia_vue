<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return inertia('Home', [
        'users' => User::when($request->search, function ($query) use ($request) {
            $query
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        })->paginate(5)->withQueryString(),

        'searchTerm' => $request->search,

        'can' => [
            'delete_user' => Auth::user() ? Auth::user()->can('delete', User::class) : null
        ]
    ]);
})->name('home');

Route::middleware('auth')->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::inertia('/register', 'Auth/NewAdmin')->name('register');
    Route::post('/register', [AuthController::class, 'new_admin']);

    // Process
    // Route::inertia('/new-admin', 'Auth/NewAdmin')->name('register');
    // Route::post('/new-admin', [AuthController::class, 'new_admin']);

    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
