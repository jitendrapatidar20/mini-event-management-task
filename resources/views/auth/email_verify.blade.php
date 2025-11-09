@extends('layouts.layout')
@section('content')
<section class="container forms" style="height: 100vh;">
            <div class="form login">
                <div class="form-content">
                    @if($formLayout==true)
                        <div class="col" style="text-align: center; color:green;">
                           <h1>Your Email successfully Verified.</h1>
                                 <div class="media-options">
                                    <a href="{{route('login')}}" class="field google">
                                        <span>Login Now</span>
                                    </a>
                                </div>
                          </div>
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