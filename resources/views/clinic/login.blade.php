<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HealthCare Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-900 flex items-center justify-center p-4">
<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
            <i class="fas fa-hospital text-white text-4xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-white">HealthCare Clinic</h1>
        <p class="text-blue-200 mt-1">Management System</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl p-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach($errors->all() as $e)<div><i class="fas fa-exclamation-circle mr-1"></i>{{ $e }}</div>@endforeach
            </div>
        @endif

        @if(session('otp_sent'))
        <!-- OTP Step -->
        <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm">
            <i class="fas fa-shield-alt text-blue-600 mr-1"></i>
            OTP Sent! <strong class="text-blue-700">Demo OTP: {{ session('demo_otp') }}</strong>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-1">Verify OTP</h2>
        <p class="text-gray-500 text-sm mb-5">Enter the 6-digit OTP sent to your email</p>
        <form action="{{ route('verify.otp') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ session('otp_email') }}">
            <div class="mb-2">
                <div class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 text-sm">{{ session('otp_email') }}</div>
            </div>
            <div class="mb-6 mt-4">
                <input type="text" name="otp" maxlength="6" autofocus placeholder="_ _ _ _ _ _"
                    class="w-full border border-gray-300 rounded-xl px-4 py-4 text-3xl font-bold tracking-widest text-center focus:ring-2 focus:ring-blue-500 outline-none @error('otp') border-red-400 @enderror">
            </div>
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">
                <i class="fas fa-check-circle mr-2"></i>Verify & Login
            </button>
            <div class="text-center mt-3"><a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">← Use different email</a></div>
        </form>

        @else
        <!-- Email Step -->
        <h2 class="text-xl font-bold text-gray-800 mb-1">Staff Login</h2>
        <p class="text-gray-500 text-sm mb-5">Enter your registered email to get OTP</p>
        <form action="{{ route('send.otp') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-3.5 text-gray-400"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="your@clinic.com"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none @error('email') border-red-400 @enderror" required>
                </div>
            </div>
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">
                <i class="fas fa-paper-plane mr-2"></i>Send OTP
            </button>
        </form>

        <!-- Demo Credentials -->
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-xl p-4">
            <p class="text-xs font-bold text-gray-500 uppercase mb-3">Demo Accounts</p>
            <div class="space-y-2 text-xs">
                <div class="flex justify-between items-center">
                    <div><span class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded text-xs font-bold mr-1">ADMIN</span><span class="text-gray-600">admin@clinic.com</span></div>
                    <code class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded">123456</code>
                </div>
                <div class="flex justify-between items-center">
                    <div><span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-xs font-bold mr-1">DOCTOR</span><span class="text-gray-600">doctor@clinic.com</span></div>
                    <code class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded">234567</code>
                </div>
                <div class="flex justify-between items-center">
                    <div><span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded text-xs font-bold mr-1">DOCTOR</span><span class="text-gray-600">doctor2@clinic.com</span></div>
                    <code class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded">345678</code>
                </div>
                <div class="flex justify-between items-center">
                    <div><span class="bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded text-xs font-bold mr-1">NURSE</span><span class="text-gray-600">nurse@clinic.com</span></div>
                    <code class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded">456789</code>
                </div>
                <div class="flex justify-between items-center">
                    <div><span class="bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded text-xs font-bold mr-1">NURSE</span><span class="text-gray-600">nurse2@clinic.com</span></div>
                    <code class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded">567890</code>
                </div>
            </div>
        </div>
        @endif
    </div>
    <p class="text-center text-blue-200 text-xs mt-5">© {{ date('Y') }} HealthCare Clinic. Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="underline">LaraCopilot</a></p>
</div>
</body>
</html>
