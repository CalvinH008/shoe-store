<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg border border-slate-200">

        <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Sign In</h2>

        {{-- ERROR GLOBAL --}}
        @if ($errors->has('error'))
            <div class="mb-4 bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm">
                {{ $errors->first('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            {{-- EMAIL --}}
            <div>
                <label class="text-sm text-slate-500">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#1e3a5f] outline-none">

                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="text-sm text-slate-500">Password</label>
                <input type="password" name="password" required
                    class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#1e3a5f] outline-none">

                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- REMEMBER --}}
            <div class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" class="rounded">
                <span>Remember Me</span>
            </div>

            {{-- BUTTON --}}
            <button type="submit"
                class="w-full bg-[#1e3a5f] text-white py-2.5 rounded-lg font-medium hover:bg-[#162c47] transition">
                Sign In
            </button>

            {{-- LINK --}}
            <p class="text-center text-sm text-slate-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-[#1e3a5f] font-medium hover:underline">
                    Sign up
                </a>
            </p>

        </form>

    </div>

</body>

</html>
