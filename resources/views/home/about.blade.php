@extends('index')

@section('title')
	Giới thiệu | HK
@endsection

@section('content')
		<!-- Breadcurb AREA -->
		<div class="breadcurb-area">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="{{ route('home') }}">Trang chủ</a></li>
					<li>Giới thiệu</li>
				</ul>
			</div>
		</div>
		<!-- About AREA -->
		<div class="about-header">
			<div class="container">
				<div class="row" style="margin-bottom: 20px">
					<div class="col-md-3">
						<div class="about-header-img" style="display: flex; justify-content: center; align-items: center; height: 200px">
							<img src="{{asset('img/logo-HK.png')}}" alt="logo" style="width: 144px" />
						</div>
					</div>
					<div class="col-md-9">
						<div class="about-header-content">
							<h1 class="about-title">Về chúng tôi</h1>
							<p>
								@php
									if (!empty($info)) {
										echo nl2br($info->about);
									} else {
										echo 'Chưa có thông tin';
									}
								@endphp
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection