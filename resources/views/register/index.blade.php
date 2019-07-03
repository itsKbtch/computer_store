@extends('index')
@section('title')
	Đăng kí | HK
@endsection
@section('content')
		<!-- Breadcurb AREA -->
		<div class="breadcurb-area">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="#">Trang chủ</a></li>
					<li><a href="#">Đăng kí</a></li>
				</ul>
			</div>
		</div>
		<!-- Checkout AREA -->
		<div class="checkout-area">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="billing-address">
							<div class="checkout-head">
								<h2>Đăng kí</h2>
							</div>
							<div class="checkout-form">
								<form action="#" method="post" class="form-horizontal">
									<div class="form-group">
										<label class="control-label col-md-2">
											Họ tên <sup>*</sup>
										</label>
										<div class="col-md-10">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">
											Địa chỉ <sup>*</sup>
										</label>
										<div class="col-md-10">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">
											E-mail <sup>*</sup>
										</label>
										<div class="col-md-10">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">
											Phone <sup>*</sup>
										</label>
										<div class="col-md-10">
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-2">
											Mật khẩu <sup>*</sup>
										</label>
										<div class="col-md-10">
											<input type="password" class="form-control">
										</div>
									</div>
									<div class="form-group text-center">
										<button type="submit" class="btn btn-warning">Đăng kí</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
@endsection