<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sunrise Society Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-teal-600 via-teal-700 to-cyan-900 flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <!-- Logo -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-building text-white text-4xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-white">Sunrise Society</h1>
        <p class="text-teal-200 mt-1">Management System</p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach($errors->all() as $e)<div><i class="fas fa-exclamation-circle mr-1"></i>{{ $e }}</div>@endforeach
            </div>
        @endif

        @if(session('otp_sent'))
        <!-- OTP Verification Form -->
        <div class="mb-4 bg-teal-50 border border-teal-200 rounded-lg p-4 text-sm text-teal-700">
            <i class="fas fa-shield-alt mr-1"></i> OTP sent! <strong>Demo OTP: {{ session('demo_otp') }}</strong>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-6">Verify OTP</h2>
        <form action="{{ route('admin.verify.otp') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ old('email', session('otp_email')) }}">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 text-sm">
                    {{ session('otp_email') }}
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Enter 6-digit OTP</label>
                <input type="text" name="otp" maxlength="6" placeholder="Enter OTP" autofocus
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-center text-2xl tracking-widest font-bold @error('otp') border-red-400 @enderror">
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-lg transition duration-200">
                <i class="fas fa-check mr-2"></i>Verify & Login
            </button>
            <div class="text-center mt-4">
                <a href="{{ route('admin.login') }}" class="text-sm text-teal-600 hover:underline">← Use different email</a>
            </div>
        </form>

        @else
        <!-- Email Form -->
        <h2 class="text-xl font-bold text-gray-800 mb-2">Admin Login</h2>
        <p class="text-gray-500 text-sm mb-6">Enter your email to receive an OTP</p>
        <form action="{{ route('admin.send.otp') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-3.5 text-gray-400"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@society.com"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none @error('email') border-red-400 @enderror" required>
                </div>
            </div>
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-lg transition duration-200">
                <i class="fas fa-paper-plane mr-2"></i>Send OTP
            </button>
        </form>

        <!-- Demo Credentials -->
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Demo Credentials</p>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">admin@society.com</span>
                    <span class="font-mono bg-teal-100 text-teal-700 px-2 rounded text-xs py-0.5">OTP: 123456</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">manager@society.com</span>
                    <span class="font-mono bg-teal-100 text-teal-700 px-2 rounded text-xs py-0.5">OTP: 654321</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">secretary@society.com</span>
                    <span class="font-mono bg-teal-100 text-teal-700 px-2 rounded text-xs py-0.5">OTP: 111222</span>
                </div>
            </div>
        </div>
        @endif
    </div>

    <p class="text-center text-teal-200 text-xs mt-6">
        © {{ date('Y') }} Sunrise Society. Powered by <a href="https://laracopilot.com/" target="_blank" class="underline">LaraCopilot</a>
    </p>
</div>
</body>
</html>
