@extends('layouts.app')
@section('title', 'login')
    @section('content')
        
    <h2>Sign In</h2>
    {{-- tampilkan error --}}
    @if ($errors->has('error'))
        <div style="color:red">
            {{$errors->first('error')}}
        </div>
    @endif
    
    <form action=" {{route('login')}} " method="POST">
        @csrf
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value=" {{old('email')}} " required>
            @error('email')
                <span style="color:red"> {{$message}} </span>
            @enderror
        </div>
        
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <span style="color:red"> {{$message}} </span>
            @enderror
        </div>

        <div>
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember Me</label>
        </div>

        <button type="submit">Sign In</button>
        <a href=" {{route('register')}} ">Don't have an account? Sign up.</a>
    </form>
@endsection