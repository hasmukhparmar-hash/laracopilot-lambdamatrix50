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
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\VisitorController;

// ─── Welcome ────────────────────────────────────────────
Route::get('/', function () { return view('welcome'); });

// ─── Project ZIP Download ────────────────────────────────
Route::get('/download-project', function () {
    if (!extension_loaded('zip')) {
        return response('ZIP extension not available. Run: php create-zip.php from terminal instead.', 500);
    }

    $projectName = 'clinic-society-management';
    $zipFileName = $projectName . '-' . date('Ymd-His') . '.zip';
    $outputPath  = storage_path('app/' . $zipFileName);

    $excludeFolders = [
        'vendor', 'node_modules', '.git',
        'storage/logs', 'storage/framework/cache',
        'storage/framework/sessions', 'storage/framework/views',
        'bootstrap/cache',
    ];
    $excludeFiles = ['.env', 'create-zip.php', $zipFileName];

    $zip      = new ZipArchive();
    $rootPath = base_path();

    if ($zip->open($outputPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        return response('Cannot create ZIP. Check storage permissions.', 500);
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file) {
        if (!$file->isFile()) continue;
        $filePath     = $file->getRealPath();
        $relativePath = str_replace('\\', '/', substr($filePath, strlen($rootPath) + 1));

        $skip = false;
        foreach ($excludeFiles as $ef) {
            if (basename($relativePath) === $ef) { $skip = true; break; }
        }
        if ($skip) continue;

        foreach ($excludeFolders as $ef) {
            if (strpos($relativePath, $ef . '/') === 0) { $skip = true; break; }
        }
        if ($skip) continue;

        $zip->addFile($filePath, $projectName . '/' . $relativePath);
    }

    // Add .env.example as .env so it works immediately after extract
    if (file_exists(base_path('.env.example'))) {
        $zip->addFile(base_path('.env.example'), $projectName . '/.env');
    }

    $zip->close();

    return response()->download($outputPath, $zipFileName, [
        'Content-Type'        => 'application/zip',
        'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
    ])->deleteFileAfterSend(true);
});

// ─── Clinic Auth ────────────────────────────────────────
Route::get('/login',       [AuthController::class, 'showLogin'])->name('login');
Route::post('/send-otp',   [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/logout',     [AuthController::class, 'logout'])->name('logout');

// ─── Clinic Dashboard ───────────────────────────────────
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ─── Patients ───────────────────────────────────────────
Route::get('/patients',             [PatientController::class, 'index'])->name('patients.index');
Route::get('/patients/create',      [PatientController::class, 'create'])->name('patients.create');
Route::post('/patients',            [PatientController::class, 'store'])->name('patients.store');
Route::get('/patients/{id}',        [PatientController::class, 'show'])->name('patients.show');
Route::get('/patients/{id}/edit',   [PatientController::class, 'edit'])->name('patients.edit');
Route::put('/patients/{id}',        [PatientController::class, 'update'])->name('patients.update');
Route::delete('/patients/{id}',     [PatientController::class, 'destroy'])->name('patients.destroy');

// ─── Doctors ────────────────────────────────────────────
Route::get('/doctors',           [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/create',    [DoctorController::class, 'create'])->name('doctors.create');
Route::post('/doctors',          [DoctorController::class, 'store'])->name('doctors.store');
Route::get('/doctors/{id}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
Route::put('/doctors/{id}',      [DoctorController::class, 'update'])->name('doctors.update');
Route::delete('/doctors/{id}',   [DoctorController::class, 'destroy'])->name('doctors.destroy');

// ─── Nurses ─────────────────────────────────────────────
Route::get('/nurses',           [NurseController::class, 'index'])->name('nurses.index');
Route::get('/nurses/create',    [NurseController::class, 'create'])->name('nurses.create');
Route::post('/nurses',          [NurseController::class, 'store'])->name('nurses.store');
Route::get('/nurses/{id}/edit', [NurseController::class, 'edit'])->name('nurses.edit');
Route::put('/nurses/{id}',      [NurseController::class, 'update'])->name('nurses.update');
Route::delete('/nurses/{id}',   [NurseController::class, 'destroy'])->name('nurses.destroy');

// ─── Medicines ──────────────────────────────────────────
Route::get('/medicines',           [MedicineController::class, 'index'])->name('medicines.index');
Route::get('/medicines/create',    [MedicineController::class, 'create'])->name('medicines.create');
Route::post('/medicines',          [MedicineController::class, 'store'])->name('medicines.store');
Route::get('/medicines/{id}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
Route::put('/medicines/{id}',      [MedicineController::class, 'update'])->name('medicines.update');
Route::delete('/medicines/{id}',   [MedicineController::class, 'destroy'])->name('medicines.destroy');

// ─── Stock ──────────────────────────────────────────────
Route::get('/stock',           [StockController::class, 'index'])->name('stock.index');
Route::get('/stock/create',    [StockController::class, 'create'])->name('stock.create');
Route::post('/stock',          [StockController::class, 'store'])->name('stock.store');
Route::get('/stock/{id}/edit', [StockController::class, 'edit'])->name('stock.edit');
Route::put('/stock/{id}',      [StockController::class, 'update'])->name('stock.update');

// ─── Inspections ────────────────────────────────────────
Route::get('/inspections',           [InspectionController::class, 'index'])->name('inspections.index');
Route::get('/inspections/create',    [InspectionController::class, 'create'])->name('inspections.create');
Route::post('/inspections',          [InspectionController::class, 'store'])->name('inspections.store');
Route::get('/inspections/{id}',      [InspectionController::class, 'show'])->name('inspections.show');
Route::get('/inspections/{id}/edit', [InspectionController::class, 'edit'])->name('inspections.edit');
Route::put('/inspections/{id}',      [InspectionController::class, 'update'])->name('inspections.update');
Route::delete('/inspections/{id}',   [InspectionController::class, 'destroy'])->name('inspections.destroy');

// ─── Bills ──────────────────────────────────────────────
Route::get('/bills',           [BillController::class, 'index'])->name('bills.index');
Route::get('/bills/create',    [BillController::class, 'create'])->name('bills.create');
Route::post('/bills',          [BillController::class, 'store'])->name('bills.store');
Route::get('/bills/{id}',      [BillController::class, 'show'])->name('bills.show');
Route::get('/bills/{id}/edit', [BillController::class, 'edit'])->name('bills.edit');
Route::put('/bills/{id}',      [BillController::class, 'update'])->name('bills.update');
Route::delete('/bills/{id}',   [BillController::class, 'destroy'])->name('bills.destroy');

// ─── Invoices ───────────────────────────────────────────
Route::get('/invoices',          [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/invoices/{id}',     [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/invoices/{id}/print',[InvoiceController::class, 'print'])->name('invoices.print');

// ─── Reports ────────────────────────────────────────────
Route::get('/reports',                    [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/monthly',            [ReportController::class, 'monthly'])->name('reports.monthly');
Route::get('/reports/patient/{id}',       [ReportController::class, 'patientReport'])->name('reports.patient');
Route::get('/reports/income',             [ReportController::class, 'income'])->name('reports.income');
Route::get('/reports/repeated-patients',  [ReportController::class, 'repeatedPatients'])->name('reports.repeated');

// ─── Society Admin Auth ─────────────────────────────────
Route::get('/admin/login',    [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/send-otp',  [AdminAuthController::class, 'sendOtp'])->name('admin.send.otp');
Route::post('/admin/verify-otp',[AdminAuthController::class, 'verifyOtp'])->name('admin.verify.otp');
Route::post('/admin/logout',  [AdminAuthController::class, 'logout'])->name('admin.logout');

// ─── Society Dashboard ──────────────────────────────────
Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

// ─── Floors ─────────────────────────────────────────────
Route::get('/admin/floors',             [FloorController::class, 'index'])->name('admin.floors.index');
Route::get('/admin/floors/create',      [FloorController::class, 'create'])->name('admin.floors.create');
Route::post('/admin/floors',            [FloorController::class, 'store'])->name('admin.floors.store');
Route::get('/admin/floors/{id}',        [FloorController::class, 'show'])->name('admin.floors.show');
Route::get('/admin/floors/{id}/edit',   [FloorController::class, 'edit'])->name('admin.floors.edit');
Route::put('/admin/floors/{id}',        [FloorController::class, 'update'])->name('admin.floors.update');
Route::delete('/admin/floors/{id}',     [FloorController::class, 'destroy'])->name('admin.floors.destroy');

// ─── Rooms ──────────────────────────────────────────────
Route::get('/admin/rooms',             [RoomController::class, 'index'])->name('admin.rooms.index');
Route::get('/admin/rooms/create',      [RoomController::class, 'create'])->name('admin.rooms.create');
Route::post('/admin/rooms',            [RoomController::class, 'store'])->name('admin.rooms.store');
Route::get('/admin/rooms/{id}',        [RoomController::class, 'show'])->name('admin.rooms.show');
Route::get('/admin/rooms/{id}/edit',   [RoomController::class, 'edit'])->name('admin.rooms.edit');
Route::put('/admin/rooms/{id}',        [RoomController::class, 'update'])->name('admin.rooms.update');
Route::delete('/admin/rooms/{id}',     [RoomController::class, 'destroy'])->name('admin.rooms.destroy');

// ─── Residents ──────────────────────────────────────────
Route::get('/admin/residents',             [ResidentController::class, 'index'])->name('admin.residents.index');
Route::get('/admin/residents/create',      [ResidentController::class, 'create'])->name('admin.residents.create');
Route::post('/admin/residents',            [ResidentController::class, 'store'])->name('admin.residents.store');
Route::get('/admin/residents/{id}',        [ResidentController::class, 'show'])->name('admin.residents.show');
Route::get('/admin/residents/{id}/edit',   [ResidentController::class, 'edit'])->name('admin.residents.edit');
Route::put('/admin/residents/{id}',        [ResidentController::class, 'update'])->name('admin.residents.update');
Route::delete('/admin/residents/{id}',     [ResidentController::class, 'destroy'])->name('admin.residents.destroy');

// ─── Maintenance ────────────────────────────────────────
Route::get('/admin/maintenance',           [MaintenanceController::class, 'index'])->name('admin.maintenance.index');
Route::get('/admin/maintenance/create',    [MaintenanceController::class, 'create'])->name('admin.maintenance.create');
Route::post('/admin/maintenance',          [MaintenanceController::class, 'store'])->name('admin.maintenance.store');
Route::get('/admin/maintenance/{id}/edit', [MaintenanceController::class, 'edit'])->name('admin.maintenance.edit');
Route::put('/admin/maintenance/{id}',      [MaintenanceController::class, 'update'])->name('admin.maintenance.update');
Route::delete('/admin/maintenance/{id}',   [MaintenanceController::class, 'destroy'])->name('admin.maintenance.destroy');

// ─── Complaints ─────────────────────────────────────────
Route::get('/admin/complaints',           [ComplaintController::class, 'index'])->name('admin.complaints.index');
Route::get('/admin/complaints/create',    [ComplaintController::class, 'create'])->name('admin.complaints.create');
Route::post('/admin/complaints',          [ComplaintController::class, 'store'])->name('admin.complaints.store');
Route::get('/admin/complaints/{id}/edit', [ComplaintController::class, 'edit'])->name('admin.complaints.edit');
Route::put('/admin/complaints/{id}',      [ComplaintController::class, 'update'])->name('admin.complaints.update');
Route::delete('/admin/complaints/{id}',   [ComplaintController::class, 'destroy'])->name('admin.complaints.destroy');

// ─── Notices ────────────────────────────────────────────
Route::get('/admin/notices',           [NoticeController::class, 'index'])->name('admin.notices.index');
Route::get('/admin/notices/create',    [NoticeController::class, 'create'])->name('admin.notices.create');
Route::post('/admin/notices',          [NoticeController::class, 'store'])->name('admin.notices.store');
Route::get('/admin/notices/{id}/edit', [NoticeController::class, 'edit'])->name('admin.notices.edit');
Route::put('/admin/notices/{id}',      [NoticeController::class, 'update'])->name('admin.notices.update');
Route::delete('/admin/notices/{id}',   [NoticeController::class, 'destroy'])->name('admin.notices.destroy');

// ─── Visitors ───────────────────────────────────────────
Route::get('/admin/visitors',           [VisitorController::class, 'index'])->name('admin.visitors.index');
Route::get('/admin/visitors/create',    [VisitorController::class, 'create'])->name('admin.visitors.create');
Route::post('/admin/visitors',          [VisitorController::class, 'store'])->name('admin.visitors.store');
Route::get('/admin/visitors/{id}/edit', [VisitorController::class, 'edit'])->name('admin.visitors.edit');
Route::put('/admin/visitors/{id}',      [VisitorController::class, 'update'])->name('admin.visitors.update');
Route::delete('/admin/visitors/{id}',   [VisitorController::class, 'destroy'])->name('admin.visitors.destroy');