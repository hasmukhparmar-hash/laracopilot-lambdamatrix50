<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare & Society Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Hero -->
    <div class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 text-white">
        <div class="max-w-6xl mx-auto px-6 py-20 text-center">
            <div class="flex justify-center space-x-4 mb-6">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center"><i class="fas fa-hospital text-3xl"></i></div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center"><i class="fas fa-building text-3xl"></i></div>
            </div>
            <h1 class="text-5xl font-bold mb-4">Management Suite</h1>
            <p class="text-xl text-blue-200 mb-10">Complete Clinic + Society Management System built with Laravel 10</p>
            <div class="flex justify-center space-x-4">
                <a href="/login" class="bg-white text-blue-700 font-bold px-8 py-4 rounded-xl hover:bg-blue-50 transition text-lg">
                    <i class="fas fa-hospital mr-2"></i>Clinic System
                </a>
                <a href="/admin/login" class="bg-blue-500 text-white font-bold px-8 py-4 rounded-xl hover:bg-blue-400 transition text-lg">
                    <i class="fas fa-building mr-2"></i>Society System
                </a>
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="max-w-6xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Clinic -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center"><i class="fas fa-hospital text-blue-600 text-xl"></i></div>
                    <div><h2 class="text-xl font-bold text-gray-800">Clinic Management</h2><p class="text-gray-500 text-sm">Laravel 10 + PHP 8.1</p></div>
                </div>
                <ul class="space-y-2 mb-6">
                    @foreach(['OTP Login (Admin/Doctor/Nurse)','Patient Registration & Detail View','Inspection with Vitals & Prescriptions','Medicine Stock Management','Bill Generation & Invoice Print','Monthly & Income Reports','Repeated Patient Tracking'] as $f)
                    <li class="flex items-center space-x-2 text-sm text-gray-600"><i class="fas fa-check text-green-500"></i><span>{{ $f }}</span></li>
                    @endforeach
                </ul>
                <a href="/login" class="block w-full text-center bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 font-semibold">Open Clinic System →</a>
            </div>

            <!-- Society -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center"><i class="fas fa-building text-teal-600 text-xl"></i></div>
                    <div><h2 class="text-xl font-bold text-gray-800">Society Management</h2><p class="text-gray-500 text-sm">Laravel 10 + PHP 8.1</p></div>
                </div>
                <ul class="space-y-2 mb-6">
                    @foreach(['OTP Login (Admin/Manager/Secretary)','Floor-wise Room Management','Room Status Tracking','Resident Registration','Visitor Log','Maintenance Requests','Notice Board'] as $f)
                    <li class="flex items-center space-x-2 text-sm text-gray-600"><i class="fas fa-check text-green-500"></i><span>{{ $f }}</span></li>
                    @endforeach
                </ul>
                <a href="/admin/login" class="block w-full text-center bg-teal-600 text-white py-3 rounded-xl hover:bg-teal-700 font-semibold">Open Society System →</a>
            </div>
        </div>
    </div>

    <!-- Download Section -->
    <div class="bg-gray-800 text-white py-12">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h3 class="text-2xl font-bold mb-2">Download Project</h3>
            <p class="text-gray-400 mb-6">Download the complete project as a ZIP file</p>
            <a href="/download-project" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold px-10 py-4 rounded-xl text-lg transition">
                <i class="fas fa-download mr-2"></i>Download ZIP
            </a>
            <p class="text-gray-500 text-sm mt-4">Excludes: vendor, .env, node_modules (run composer install after extracting)</p>
        </div>
    </div>

    <footer class="bg-gray-900 text-white py-8 text-center">
        <p class="text-gray-400">© {{ date('Y') }} Management Suite. Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="text-blue-400 hover:underline">LaraCopilot</a></p>
    </footer>
</body>
</html>
