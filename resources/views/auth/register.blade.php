@extends('layouts.app')
@section('title', 'register')
@section('content')

    <h2>Sign Up</h2>
    {{-- tampilkan error --}}
    @if ($errors->has('error'))
        <div style="color:red">
            {{ $errors->first('error') }}
        </div>
    @endif

    <form action=" {{ route('register') }} " method="POST">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value=" {{ old('name') }} " required>
            @error('name')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value=" {{ old('email') }} " required>
            @error('email')
                <span style="color:red"> {{ $message }} </span>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <span style="color:red"> {{ $message }} </span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit">Sign Up</button>
        <a href=" {{ route('login') }} ">Already have an account? Sign up.</a>
    </form>
@endsection
