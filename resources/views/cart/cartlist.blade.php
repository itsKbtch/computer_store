@extends('index')
@section('title')
	Giỏ hàng | HK
@endsection
@section('content')
		<!-- Breadcurb AREA -->
		<div class="breadcurb-area">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="{{ route('home') }}">Trang chủ</a></li>
					<li>Giỏ hàng</li>
				</ul>
			</div>
		</div>
		<!-- Chart AREA -->
		<div class="chart-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="chart-item table-responsive fix">
							<table class="col-md-12">
								<thead>
									<tr>
										<th class="th-product">Sản phẩm</th>
										<th class="th-details">Tên</th>
										<th class="th-qty">Số lượng</th>
										<th class="th-price">Đơn giá</th>
										<th class="th-total">Tổng</th>
										<th class="th-delate">Xóa</th>
									</tr>
								</thead>
								<tbody>
									@php
                                		$total = 0;
                                	@endphp
									@forelse ($carts as $cart)
										@php
											$price = $cart['price'];
										@endphp
										<tr>
											<td class="th-product">
												@if (!empty($cart['image']))
													<img src="{{ asset('storage/product/'.$cart['image']) }}" alt="cart">
												@else
													<img src="{{ asset('img/cart/cart-1.jpg') }}" alt="cart">
												@endif
											</td>
											<td class="th-details">
												<a href="{{ route('details', [str_slug($cart['name'])."-".$cart['id']]) }}">{{$cart['name']}}</a>
											</td>
											<td class="th-qty">
												<input class="quantity" type="number" name="cart[{{$cart['id']}}]" min="1" value="{{$cart['quantity']}}">
											</td>
											<td class="th-price">
												<span style="{{!empty($cart['discount_percent']) || !empty($cart['discount_cash'])?'text-decoration: line-through':''}}">{{number_format($cart['price'])}} VNĐ</span>

												@if (!empty($cart['discount_percent']))
													@php
														$price = $cart['price'] - $cart['price']*$cart['discount_percent']/100;
													@endphp
													<br>
													<span>
														<span class="badge badge-pill badge-primary">giảm {{$cart['discount_percent']}}%</span><br>
														{{number_format($price)}} VNĐ
													</span>
												@endif
												@if (!empty($cart['discount_cash']))
													@php
														$price = $cart['price'] - $cart['discount_cash'];
													@endphp
													<br>
													<span>
														<span class="badge badge-pill badge-primary">giảm {{$cart['discount_cash']}} VNĐ</span><br> 
														{{number_format($price)}} VNĐ
													</span>
												@endif
											</td>
											<td class="th-total">{{number_format($price*$cart['quantity'])}} VNĐ</td>
											<td class="th-delate"><a onclick="removeCart({{$cart['id']}})"><i class="fa fa-trash"></i></a></td>
										</tr>
										@php
                                        	$total = $total + $price*$cart['quantity'];
                                        @endphp
									@empty
										<tr>
											<td colspan=6>Chưa có sản phẩm nào</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
						<div class="cart-button">
							<a href="{{ route('home') }}"><button type="button" class="btn">Tiếp tục mua sắm</button></a>

							@if (!empty($carts))
							<button type="button" class="btn floatright" onclick="updateCart()">Cập nhật giỏ hàng</button>
							@endif
						</div>
					</div>
				</div>
				@if (!empty($carts))
				<div class="row">
					<div class="cart-shopping-area fix">
						<div class="col-md-4 col-sm-4" style="float: right">
							<div class="shopping-summary chart-all">
								<div class="shopping-cost-area">
									<div class="shopping-cost">
										<div class="shopping-cost-left">
											{{-- <p>Tạm tính </p> --}}
											<p style="font-weight: bold">Thành tiền </p>
										</div>
										<div class="shopping-cost-right">
											{{-- <p class="sub-total">{{number_format($total)}} VNĐ</p> --}}
											<p class="grand-total">{{number_format($total)}} VNĐ</p>
										</div>
									</div>
									<div style="float: right; width: 100%">
										<input type="hidden" id="active_code" name="active_code_id">
										<a href="{{ route('checkout') }}"><button type="button" class="btn">Đặt hàng</button></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
		<script>
			function removeCart(id) {
              if(!confirm("Bạn có chắc chắn xóa?")) {
                return false;
              }
              
              $.ajax({
                url: "{{route('removeCart')}}",
                type: "POST",
                data: {
                  "_token" : '{{csrf_token()}}', 
                  "_method" : "POST",
                  "id": id
                },
                success: function(result) {
                  if(result.status == "success") {
                    window.location.reload();
                  }
                  else {
                    alert("Xóa thất bại");
                  }
                },
                error: function(error) {
                  alert("Xóa thất bại");
                }
              });
            }

            function updateCart() {
                var data = new FormData();

                $('.quantity').each(function() {
                  data.append($(this).attr('name'), $(this).val());
                });

                $.ajax({
                  url: "{{route('updateCart')}}",
                  method: "post",
                  processData: false,
                  contentType: false,
                  headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                  },
                  data: data,
                  success: function(result) {
                    if(result.status == "success") {
                      window.location.reload();
                    }
                    else {
                      if (result.status == 'fail') {
                        alert("Xóa thất bại");
                      } 
                    }
                  },
                  error: function(error) {
                    alert("Xóa thất bại");
                  }
                });
            }

            $(function() {
            	$('.quantity').on('change', function() {
            		updateCart();
            	});
            });
		</script>
@endsection