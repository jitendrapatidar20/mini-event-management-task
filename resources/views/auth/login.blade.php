@extends('layouts.layout')
@section('content')
<section class="container forms" style="height: 100vh;">
    <div class="form login">
        <div class="form-content">
            <h2>Admin Login</h2>
            <form action="#" id="login">
                    {!! csrf_field() !!}
                    <input type="hidden" name="role" value="{{Crypt::encrypt('ADMIN')}}">
                <div class="field input-field">
                    <input type="email" placeholder="Email" class="input email" name="email" id="email">
                </div>
                <div class="field input-field">
                    <input type="password" placeholder="Password" class="password password" name="password" id="password">
                    <i class='bx bx-hide eye-icon'></i>
                </div>
                <div class="form-link">
                    <a href="{{route('forgot')}}" class="forgot-pass">Forgot password?</a>
                </div>
                <div class="field button-field">
                    <button id="login-btn" type="submit" name="button">Login</button>
                </div>
            </form>
            <div class="form-link">
                <span>Don't have an account? <a href="{{route('register')}}" class="link signup-link">Signup</a></span>
            </div>
        </div>
    </div>
</section>
@endsection