<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg border border-slate-200">

        <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Sign Up</h2>

        {{-- ERROR GLOBAL --}}
        @if ($errors->has('error'))
            <div class="mb-4 bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm">
                {{ $errors->first('error') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            {{-- NAME --}}
            <div>
                <label class="text-sm text-slate-500">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#1e3a5f] outline-none">

                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

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

            {{-- CONFIRM --}}
            <div>
                <label class="text-sm text-slate-500">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#1e3a5f] outline-none">
            </div>

            {{-- BUTTON --}}
            <button type="submit"
                class="w-full bg-[#1e3a5f] text-white py-2.5 rounded-lg font-medium hover:bg-[#162c47] transition">
                Sign Up
            </button>

            {{-- LINK --}}
            <p class="text-center text-sm text-slate-500">
                Already have an account?
                <a href="{{ route('login') }}" class="text-[#1e3a5f] font-medium hover:underline">
                    Sign In
                </a>
            </p>

        </form>

    </div>

</body>

</html>
