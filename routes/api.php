<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
            'roles' => $request->user()->getRoleNames(),
            'permissions' => $request->user()->getAllPermissions()->pluck('name'),
        ]);
    });

    Route::middleware('role:admin')->get('/admin/dashboard', function () {
        return response()->json(['message' => 'Welcome Admin']);
    });

    Route::middleware('role:hr')->get('/hr/dashboard', function () {
        return response()->json(['message' => 'Welcome HR']);
    });

    Route::middleware('permission:manage_users')->get('/users', function () {
        return response()->json(['message' => 'You can manage users']);
    });

});