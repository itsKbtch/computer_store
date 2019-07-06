@extends('index')
@section('title')
	Đặt hàng | HK
@endsection
@section('content')
		<!-- Breadcurb AREA -->
		<div class="breadcurb-area">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="{{ route('home') }}">Trang chủ</a></li>
					<li>Checkout</li>
				</ul>
			</div>
		</div>
		<!-- Checkout AREA -->
		<div class="checkout-area">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-sm-7">
						<div class="billing-address">
							@error ('promo_code')
							    <div class="alert alert-danger">
							        <ul>
							            <li>{{$message}}</li>
							        </ul>
							    </div>
							@enderror
							@if (session('fail'))
								<div class="alert alert-danger">
							        <ul>
							            <li>{{session('fail')}}</li>
							        </ul>
							    </div>    
					        @endif
							<div class="checkout-head">
								<h2>Thông tin khách hàng</h2>
							</div>
							<div class="checkout-form">
								<form action="{{ route('placeorder') }}" method="post" class="form-horizontal" id="form">
									@csrf
									<div class="form-group @error('name')has-error @enderror">
										<label class="control-label col-md-3">
											Tên <sup>*</sup>
										</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="name" value="{{!empty($user)? $user->name:''}}">
											@error('name')
					                            <div class="invalid-feedback text-danger">{{$message}}</div>
					                        @enderror
										</div>
									</div>
									<div class="form-group @error('address')has-error @enderror">
										<label class="control-label col-md-3">
											Địa chỉ <sup>*</sup>
										</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="address" value="{{!empty($user)? $user->address:''}}">
											@error('address')
					                            <div class="invalid-feedback text-danger">{{$message}}</div>
					                        @enderror
										</div>
									</div>
									<div class="form-group @error('phone_number')has-error @enderror">
										<label class="control-label col-md-3">
											SĐT <sup>*</sup>
										</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="phone_number" value="{{!empty($user)? $user->phone_number:''}}">
											@error('phone_number')
					                            <div class="invalid-feedback text-danger">{{$message}}</div>
					                        @enderror
										</div>
									</div>
									<div class="form-group @error('email')has-error @enderror">
										<label class="control-label col-md-3">
											E-mail
										</label>
										<div class="col-md-9">
											<input type="email" class="form-control" name="email" value="{{!empty($user)? $user->email:''}}">
											@error('email')
					                            <div class="invalid-feedback text-danger">{{$message}}</div>
					                        @enderror
										</div>
									</div>
									<input type="hidden" id="active_code" name="promo_code">
									<input type="hidden" name="user_id" value="{{!empty($user)? $user->id:''}}">
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-sm-5">
						<div class="review-order">
							<div class="checkout-head">
								<h2>Thông tin mua hàng</h2>
							</div>
							@php
	                    		$total = 0;
	                    	@endphp
							@forelse ($carts as $cart)
								@php
									$price = $cart['price'];
								@endphp
								<div class="single-review">
									<div class="single-review-img">
										@if (!empty($cart['image']))
											<img src="{{ asset('storage/product/'.$cart['image']) }}" alt="review" width="100px">
										@else
											<img src="{{ asset('img/checkout.jpg') }}" alt="review">
										@endif
									</div>
									<div class="single-review-content fix">
										<h2><a href="{{ route('details', [str_slug($cart['name'])."-".$cart['id']]) }}">{{$cart['name']}}</a></h2>
										<p><span>Số lượng:</span> {{$cart['quantity']}}</p>

										@if (!empty($cart['discount_percent']))
											@php
												$price = $cart['price'] - $cart['price']*$cart['discount_percent']/100;
											@endphp
											<p>
												<span>Đơn giá:</span> {{number_format($price)}} VNĐ 
												<span class="badge badge-pill badge-primary">- {{$cart['discount_percent']}}%</span>
											</p>
										@else
											@if (!empty($cart['discount_cash']))
												@php
													$price = $cart['price'] - $cart['discount_cash'];
												@endphp
												<p>
													<span>Đơn giá:</span> {{number_format($price)}} VNĐ
													<span class="badge badge-pill badge-primary">- {{$cart['discount_cash']}} VNĐ</span>
												</p>
											@else
												<p><span>Đơn giá:</span> {{number_format($price)}} VNĐ</p>
											@endif
										@endif

										<h3>{{number_format($price*$cart['quantity'])}} VNĐ</h3>
									</div>
								</div>
								@php
	                            	$total = $total + $price*$cart['quantity'];
	                            @endphp
							@empty
								
							@endforelse
							<div class="subtotal-area" style="margin-bottom: 20px">
								<div class="subtotal-content fix">
									<h2 class="floatleft">Tổng</h2>
									<h2 class="floatright sub-total" value={{$total}}>{{number_format($total)}} VNĐ</h2>
								</div>
								<div class="subtotal-content fix">
									<h2 class="floatleft">Thành tiền</h2>
									<h2 class="floatright grand-total" value={{$total}}>{{number_format($total)}} VNĐ</h2>
								</div>
							</div>
							<div class="chart-all">
								<h2>Mã giảm giá</h2>
								<input id="promocode" name="active_code" type="text">
								<div class="error-message text-danger"></div>
								<button id="applyPromoCode" type="button" class="btn" onclick="apply()">Áp dụng</button>
							</div>
							<div class="payment-method">
								<button type="button" class="btn" onclick="placeorder()">Đặt hàng</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			function formatNumber(num) {
			  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
			}

            function apply() {
                var data = new FormData();

                data.append($('#promocode').attr('name'), $('#promocode').val());

                $.ajax({
                  url: "{{route('applyPromoCode')}}",
                  method: "post",
                  processData: false,
                  contentType: false,
                  headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                  },
                  data: data,
                  success: function(result) {
                  	$('#promocode ~ .error-message').html('');

                    if(result.status == "success") {
                    	var total = Number($('.sub-total').attr('value'));
                    	var discount_percent = result.promo.discount_percent;
                    	var discount_cash = result.promo.discount_cash;
                    	var newtotal = total;

                    	if (discount_percent != null && discount_percent != 0) {
                    		newtotal = total - total*discount_percent/100;
                    		$('.grand-total').html(formatNumber(newtotal) + " VNĐ");
                    		$('.grand-total').parent('.subtotal-content').before('<div class="subtotal-content fix"><h2 class="floatleft">Chiết khấu </h2><h2 class="floatright">-' + formatNumber(discount_percent) + '%</h2></div>');
                    	}

                    	if (discount_cash != null && discount_cash != 0) {
                    		newtotal = total - discount_cash;
                    		
                    		if (newtotal < 0) {
                    			newtotal = 0;	
                    		}

                    		$('.grand-total').html(formatNumber(newtotal) + " VNĐ");
                    		$('.grand-total').parent('.subtotal-content').before('<div class="subtotal-content fix"><h2 class="floatleft">Chiết khấu </h2><h2 class="floatright">-' + formatNumber(discount_cash) + ' VNĐ</h2></div>');
                    	}

                    	$("#applyPromoCode").prop('disabled', true);
                    	$("#promocode").prop('disabled', true);
                    	$("#applyPromoCode").attr('title', 'Chỉ được áp dụng 1 mã giảm giá');
                    	$('.grand-total').attr('value', newtotal);
                    	$('#active_code').val(result.promo.id);
                    }
                    if (result.status == 'fail') {
                    	$('#promocode ~ .error-message').html('Mã không tồn tại');
                    }
                    if (result.status == 'out of stock') {
                    	$('#promocode ~ .error-message').html('Mã đã hết số lượng');
                    }
                    if (result.status == 'out of date') {
                        $('#promocode ~ .error-message').html('Mã đã hết hạn');
                    }
                  },
                  error: function(error) {
                   	$('#promocode ~ .error-message').html('Không thể áp dụng mã');
                  }
                });
            }

            function placeorder() {
            	$('#form').append('<input type="hidden" name="total" value=' + $('.sub-total').attr('value') + '>');
            	$('#form').append('<input type="hidden" name="total_with_discount" value=' + $('.grand-total').attr('value') + '>');
            	$('#form').submit();
            }
		</script>
@endsection