@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
            <h2 class="heading-section">Interior Woodwork Management App</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="login-wrap p-0">
                <h3 class="mb-4 text-center">Log in</h3>
                <form method="POST" action="{{ route('login') }}" class="signin-form">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="form-group">
                        <input id="password-field" type="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password text-info"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                    </div>
                    <div class="form-group d-md-flex">
                        <div class="w-50">
                            <label class="checkbox-wrap checkbox-primary">
                                Remember Me
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                        <div class="w-50 text-md-right">
                            <a href="{{ route('password.request') }}" style="color: #fff">Forgot Password</a>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

