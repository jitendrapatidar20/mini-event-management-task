@extends('layouts.layout')
@section('content')
<section class="container forms" style="height: 100vh;">
            <div class="form login">
                <div class="form-content">
                    @if($formLayout==true)
                    <h2>Create Your New Password</h2>
                    <form action="#" id="resetPassword">
                         {!! csrf_field() !!}
                         <input type="hidden" name="token" value="{{$token}}">
                         <div class="field input-field">
                          <input class="password password-policy" id="password" type="password" name="password" placeholder="Password" autocomplete="off" onkeyup="enterPassword(this)">
                            <i class='bx bx-hide eye-icon'></i>
                        </div>
                        <div class="field input-field">
                            <input class="password confirm_password" type="password" name="confirm_password" placeholder="Confirm Password" autocomplete="off" id="student-confirm-password">
                            <i class='bx bx-hide eye-icon'></i>
                        </div>
                        <div class="field button-field">
                            <button id="forget-btn" type="submit" name="forget">Submit</button>
                        </div>
                    </form>
                    @else
                    <div class="row">
                        <div class="col" style="text-align: center; color:red;">
                           <h1>This Link has been expired.</h1>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
</section>
@endsection