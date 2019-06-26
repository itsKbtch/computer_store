@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
<!--===============================================================================================-->
    <script src="{{ asset('login_assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset('login_assets/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset('login_assets/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('login_assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset('login_assets/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset('login_assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('login_assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset('login_assets/vendor/countdowntime/countdowntime.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset('login_assets/js/main.js') }}"></script>
@endsection
