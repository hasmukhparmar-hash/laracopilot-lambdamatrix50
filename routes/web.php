<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\VisitorController;

Route::get('/', function () { return view('welcome'); });

// Admin Auth
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/send-otp', [AdminAuthController::class, 'sendOtp'])->name('admin.send.otp');
Route::post('/admin/verify-otp', [AdminAuthController::class, 'verifyOtp'])->name('admin.verify.otp');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Floors
Route::get('/admin/floors', [FloorController::class, 'index'])->name('admin.floors.index');
Route::get('/admin/floors/create', [FloorController::class, 'create'])->name('admin.floors.create');
Route::post('/admin/floors', [FloorController::class, 'store'])->name('admin.floors.store');
Route::get('/admin/floors/{id}', [FloorController::class, 'show'])->name('admin.floors.show');
Route::get('/admin/floors/{id}/edit', [FloorController::class, 'edit'])->name('admin.floors.edit');
Route::put('/admin/floors/{id}', [FloorController::class, 'update'])->name('admin.floors.update');
Route::delete('/admin/floors/{id}', [FloorController::class, 'destroy'])->name('admin.floors.destroy');

// Rooms
Route::get('/admin/rooms', [RoomController::class, 'index'])->name('admin.rooms.index');
Route::get('/admin/rooms/create', [RoomController::class, 'create'])->name('admin.rooms.create');
Route::post('/admin/rooms', [RoomController::class, 'store'])->name('admin.rooms.store');
Route::get('/admin/rooms/{id}', [RoomController::class, 'show'])->name('admin.rooms.show');
Route::get('/admin/rooms/{id}/edit', [RoomController::class, 'edit'])->name('admin.rooms.edit');
Route::put('/admin/rooms/{id}', [RoomController::class, 'update'])->name('admin.rooms.update');
Route::delete('/admin/rooms/{id}', [RoomController::class, 'destroy'])->name('admin.rooms.destroy');

// Residents
Route::get('/admin/residents', [ResidentController::class, 'index'])->name('admin.residents.index');
Route::get('/admin/residents/create', [ResidentController::class, 'create'])->name('admin.residents.create');
Route::post('/admin/residents', [ResidentController::class, 'store'])->name('admin.residents.store');
Route::get('/admin/residents/{id}', [ResidentController::class, 'show'])->name('admin.residents.show');
Route::get('/admin/residents/{id}/edit', [ResidentController::class, 'edit'])->name('admin.residents.edit');
Route::put('/admin/residents/{id}', [ResidentController::class, 'update'])->name('admin.residents.update');
Route::delete('/admin/residents/{id}', [ResidentController::class, 'destroy'])->name('admin.residents.destroy');

// Maintenance
Route::get('/admin/maintenance', [MaintenanceController::class, 'index'])->name('admin.maintenance.index');
Route::get('/admin/maintenance/create', [MaintenanceController::class, 'create'])->name('admin.maintenance.create');
Route::post('/admin/maintenance', [MaintenanceController::class, 'store'])->name('admin.maintenance.store');
Route::get('/admin/maintenance/{id}/edit', [MaintenanceController::class, 'edit'])->name('admin.maintenance.edit');
Route::put('/admin/maintenance/{id}', [MaintenanceController::class, 'update'])->name('admin.maintenance.update');
Route::delete('/admin/maintenance/{id}', [MaintenanceController::class, 'destroy'])->name('admin.maintenance.destroy');

// Complaints
Route::get('/admin/complaints', [ComplaintController::class, 'index'])->name('admin.complaints.index');
Route::get('/admin/complaints/create', [ComplaintController::class, 'create'])->name('admin.complaints.create');
Route::post('/admin/complaints', [ComplaintController::class, 'store'])->name('admin.complaints.store');
Route::get('/admin/complaints/{id}/edit', [ComplaintController::class, 'edit'])->name('admin.complaints.edit');
Route::put('/admin/complaints/{id}', [ComplaintController::class, 'update'])->name('admin.complaints.update');
Route::delete('/admin/complaints/{id}', [ComplaintController::class, 'destroy'])->name('admin.complaints.destroy');

// Notices
Route::get('/admin/notices', [NoticeController::class, 'index'])->name('admin.notices.index');
Route::get('/admin/notices/create', [NoticeController::class, 'create'])->name('admin.notices.create');
Route::post('/admin/notices', [NoticeController::class, 'store'])->name('admin.notices.store');
Route::get('/admin/notices/{id}/edit', [NoticeController::class, 'edit'])->name('admin.notices.edit');
Route::put('/admin/notices/{id}', [NoticeController::class, 'update'])->name('admin.notices.update');
Route::delete('/admin/notices/{id}', [NoticeController::class, 'destroy'])->name('admin.notices.destroy');

// Visitors
Route::get('/admin/visitors', [VisitorController::class, 'index'])->name('admin.visitors.index');
Route::get('/admin/visitors/create', [VisitorController::class, 'create'])->name('admin.visitors.create');
Route::post('/admin/visitors', [VisitorController::class, 'store'])->name('admin.visitors.store');
Route::get('/admin/visitors/{id}/edit', [VisitorController::class, 'edit'])->name('admin.visitors.edit');
Route::put('/admin/visitors/{id}', [VisitorController::class, 'update'])->name('admin.visitors.update');
Route::delete('/admin/visitors/{id}', [VisitorController::class, 'destroy'])->name('admin.visitors.destroy');