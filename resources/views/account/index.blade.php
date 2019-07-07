@extends('layouts.app')

@section('title')
	{{Auth::user()->name}} | Tài khoản | HK
@endsection

@section('menu')
	@auth
		<li class="nav-item">
            <a class="nav-link" style="color: #ffffff" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Đăng xuất') }}</a>
        </li>
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
	@endauth
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<ul class="nav nav-tabs mb-4">
				  <li class="nav-item">
				    <a class="nav-link{{strpos(Route::currentRouteName(), 'account.index') !== false? ' font-weight-bold active':''}}" style="{{strpos(Route::currentRouteName(), 'account.index') !== false? 'color: rgb(95, 30, 107)':''}}" href="{{ route('account.index') }}">Tài khoản</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link{{strpos(Route::currentRouteName(), 'account.orders') !== false? ' font-weight-bold active':''}}" style="{{strpos(Route::currentRouteName(), 'account.orders') !== false? 'color: rgb(95, 30, 107)':''}}" href="{{ route('account.orders') }}">Đơn hàng</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link{{Route::currentRouteName() == 'account.changePasswordForm'? ' font-weight-bold active':''}}" style="{{Route::currentRouteName() == 'account.changePasswordForm'? 'color: rgb(95, 30, 107)':''}}" href="{{ route('account.changePasswordForm') }}">Đổi mật khẩu</a>
				  </li>
				</ul>
			</div>
			<div class="col-12">
				@yield('main')
			</div>
		</div>
	</div>
@endsection