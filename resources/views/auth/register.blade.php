<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
</head>

<body>
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
        <a href=" {{ route('login') }} ">Already have an account? Sign In.</a>
    </form>
</body>

</html>
