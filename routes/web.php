<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('admin.login'));

Route::redirect('/admin', '/admin/dashboard');

Route::view('/admin/login',     'admin.login');
Route::view('/admin/dashboard', 'admin.dashboard');
Route::view('/admin/user',      'admin.user');
Route::view('/admin/role',      'admin.role');
Route::view('/admin/audit-log', 'admin.audit-log');