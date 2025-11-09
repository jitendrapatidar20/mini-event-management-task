@extends('layouts.layout')
@section('content')
<section class="container forms" style="height: 100vh;">
            <div class="form login">
                <div class="form-content">
                    <h2>Forget Password</h2>
                    <span id="returnEmail" style="color:green;font-size:13px;"></span>
                    <form action="#" id="forgotPassword">
                         {!! csrf_field() !!}
                        <div class="field input-field">
                            <input type="email" placeholder="Email" class="input email" name="email" id="email">
                        </div>
                        <div class="field button-field">
                            <button id="forget-btn" type="submit" name="forget">Submit</button>
                        </div>
                    </form>
                    <div class="form-link">
                        <span>If have an account ? <a href="{{route('login')}}" class="link signup-link">Login Now</a></span>
                    </div>
                </div>
            </div>
</section>
@endsection