<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clinic\AuthController;
use App\Http\Controllers\Clinic\DashboardController;
use App\Http\Controllers\Clinic\PatientController;
use App\Http\Controllers\Clinic\DoctorController;
use App\Http\Controllers\Clinic\NurseController;
use App\Http\Controllers\Clinic\MedicineController;
use App\Http\Controllers\Clinic\InspectionController;
use App\Http\Controllers\Clinic\BillController;
use App\Http\Controllers\Clinic\InvoiceController;
use App\Http\Controllers\Clinic\ReportController;
use App\Http\Controllers\Clinic\StockController;

Route::get('/', function () { return view('welcome'); });

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Patients
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');

// Doctors
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
Route::get('/doctors/{id}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('doctors.update');
Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

// Nurses
Route::get('/nurses', [NurseController::class, 'index'])->name('nurses.index');
Route::get('/nurses/create', [NurseController::class, 'create'])->name('nurses.create');
Route::post('/nurses', [NurseController::class, 'store'])->name('nurses.store');
Route::get('/nurses/{id}/edit', [NurseController::class, 'edit'])->name('nurses.edit');
Route::put('/nurses/{id}', [NurseController::class, 'update'])->name('nurses.update');
Route::delete('/nurses/{id}', [NurseController::class, 'destroy'])->name('nurses.destroy');

// Medicines
Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
Route::get('/medicines/{id}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
Route::put('/medicines/{id}', [MedicineController::class, 'update'])->name('medicines.update');
Route::delete('/medicines/{id}', [MedicineController::class, 'destroy'])->name('medicines.destroy');

// Stock
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/stock/create', [StockController::class, 'create'])->name('stock.create');
Route::post('/stock', [StockController::class, 'store'])->name('stock.store');
Route::get('/stock/{id}/edit', [StockController::class, 'edit'])->name('stock.edit');
Route::put('/stock/{id}', [StockController::class, 'update'])->name('stock.update');

// Inspections
Route::get('/inspections', [InspectionController::class, 'index'])->name('inspections.index');
Route::get('/inspections/create', [InspectionController::class, 'create'])->name('inspections.create');
Route::post('/inspections', [InspectionController::class, 'store'])->name('inspections.store');
Route::get('/inspections/{id}', [InspectionController::class, 'show'])->name('inspections.show');
Route::get('/inspections/{id}/edit', [InspectionController::class, 'edit'])->name('inspections.edit');
Route::put('/inspections/{id}', [InspectionController::class, 'update'])->name('inspections.update');
Route::delete('/inspections/{id}', [InspectionController::class, 'destroy'])->name('inspections.destroy');

// Bills
Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
Route::get('/bills/create', [BillController::class, 'create'])->name('bills.create');
Route::post('/bills', [BillController::class, 'store'])->name('bills.store');
Route::get('/bills/{id}', [BillController::class, 'show'])->name('bills.show');
Route::get('/bills/{id}/edit', [BillController::class, 'edit'])->name('bills.edit');
Route::put('/bills/{id}', [BillController::class, 'update'])->name('bills.update');
Route::delete('/bills/{id}', [BillController::class, 'destroy'])->name('bills.destroy');

// Invoices
Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/invoices/{id}/print', [InvoiceController::class, 'print'])->name('invoices.print');

// Reports
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
Route::get('/reports/patient/{id}', [ReportController::class, 'patientReport'])->name('reports.patient');
Route::get('/reports/income', [ReportController::class, 'income'])->name('reports.income');
Route::get('/reports/repeated-patients', [ReportController::class, 'repeatedPatients'])->name('reports.repeated');