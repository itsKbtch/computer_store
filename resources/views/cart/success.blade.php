@extends('index')

@section('title')
	Đặt hàng thành công
@endsection

@section('content')
	<div class="not-found-area fix">
		<div class="container">
			<div class="success" style="text-align: center">
				<h2 style="margin: 20px auto;">Đặt hàng thành công</h2>
				<p>Chúng tôi sẽ liên lạc với bạn sớm nhất.</p>
				<div class="bill" style="border: solid 1px gray; max-width: 500px; margin: 20px auto; text-align: left; padding: 20px">
					<p><b>Mã đơn hàng:</b> {{$invoice->id}}</p>
					<p><b>Tên:</b> {{$invoice->name}}</p>
					<p><b>Đ/c:</b> {{$invoice->address}}</p>
					<p><b>SĐT:</b> {{$invoice->phone_number}}</p>
					<p><b>Thành tiền:</b> {{number_format($invoice->total_with_discount)}} VNĐ</p>
				</div>
				<a href="{{ route('home') }}"><button class="btn btn-warning">Về trang chủ</button></a>
			</div>
		</div>
	</div>
@endsection