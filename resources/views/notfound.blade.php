@extends('index')

@section('title')
	Không tìm thấy | HK
@endsection

@section('content')
	<div class="not-found-area fix">
		<div class="container">
			<div class="not-found">
				<img src="{{asset('img/404.png')}}" alt="404" width="200px" style="margin-top: 50px">
				<h2>Không tìm thấy trang bạn yêu cầu</h2>
				<p>Hãy kiểm tra lại URL hoặc sử dụng thanh tìm kiếm</p>
				<a href="{{ route('home') }}">Về trang chủ</a>
			</div>
		</div>
	</div>
@endsection