@extends('index')

@section('title')
	Liên hệ | HK
@endsection

@section('content')
		<!-- Breadcurb AREA -->
		<div class="breadcurb-area">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="{{ route('home') }}">Trang chủ</a></li>
					<li>Liên hệ</li>
				</ul>
			</div>
		</div>
		<!-- Contact-us area -->
		<div class="contact-us-area">
			<div class="container">
				<div class="contact-information">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<div class="contact-details">
									<div class="contact-head">
										<h3>THÔNG TIN LIÊN HỆ</h3>
									</div>
									<div class="contact-bottom">
										<p><span><i class="fa fa-phone"></i></span> <b>SĐT:</b> {{!empty($info)? $info->phone_number:'Chưa có thông tin'}}</p>
										<p><span><i class="fa fa-envelope"></i></span> <b>E-mail:</b> {{!empty($info)? $info->email:'Chưa có thông tin'}}</p>
										<p><span><i class="fa fa-map-marker"></i></span> <b>Địa chỉ:</b> {{!empty($info)? $info->address:'Chưa có thông tin'}}</p>
										<p><span><i class="fa fa-facebook"></i></span> <b>Facebook:</b> <a href="{{!empty($info)? $info->phone_number:'#'}}">{{!empty($info)? $info->facebook:'Chưa có thông tin'}}</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection