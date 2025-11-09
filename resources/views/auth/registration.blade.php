
@extends('layouts.layout')
@section('content')
<section class="container forms">
            <div class="form login">
                <div class="form-content">
                     <h2>Create Admin Account</h2>
                    <form action="#" id="registration">
                    {!! csrf_field() !!}
                    <div class="field input-field">
                            <input id="first_name" type="text" class="first_name input" placeholder="First Name" name="first_name">
                        </div>
                        <div class="field input-field">
                        <input type="text" id="last_name" name="last_name" class="last_name input" placeholder="Last Name">
                        </div>
                        <div class="field input-field">
                           <input id="email" class="email input" type="email" name="email" autocomplete="off" placeholder="Email" onBlur="checkAvailability(this.value,'User')">
                           <span id="availability-status"></span>
                        </div>
                        <div class="field input-field">
                           <input id="phone_no" class="phone_no input" type="text" name="phone_no" autocomplete="off" placeholder="Mobile Number">
                        </div>
                        <div class="field input-field">
                          <input class="password password-policy" id="password" type="password" name="password" placeholder="Password" autocomplete="off" onkeyup="enterPassword(this)">
                            <i class='bx bx-hide eye-icon'></i>
                        </div>
                        <div class="field input-field">
                            <input class="password confirm_password" type="password" name="confirm_password" placeholder="Confirm Password" autocomplete="off" id="student-confirm-password">
                            <i class='bx bx-hide eye-icon'></i>
                        </div>
                        <div class="form-link">
                                <input class="form-checkbox-input form-check-input" type="checkbox" name="terms_condition" value="yes" id="flexCheck-1">
                               <span> I Agree to  <a href="#" class="link signup-link">Terms & conditions</a></span>
                        </div>
                        <div class="field button-field">
                              <input type="hidden" name="role" value="{{Crypt::encrypt('ADMIN')}}">
                            <button id="student-sign-up" type="submit" name="button">Sign Up</button>
                        </div>
                    </form>
                    <div class="form-link">
                        <span>Already have an account? <a href="{{route('login')}}" class="link signup-link">Login Now</a></span>
                    </div>
                </div>
            </div>
</section>
@endsection
