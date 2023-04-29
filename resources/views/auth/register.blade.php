@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center mb-1">
            <h2 class="heading-section">Interior Woodwork Management App</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="login-wrap p-0">
                <h3 class="mb-1 text-center">Register as client</h3>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="signin-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="form-group">
                        <input id="password-field" type="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password text-info"></span>
                    </div>
                    <div class="form-group">
                        <input id="password-field" type="password" class="form-control" placeholder="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password text-info"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary submit px-3">Sign up</button>
                    </div>
                    <div class="form-group d-md-flex">

                        <div class="w-100 text-md-left">
                            Already have an account?
                            <a href="{{ route('login') }}" style="color: blue">login</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
