@extends('index')
@section('title')
	Giỏ hàng | HK
@endsection
@section('content')
	<!-- Breadcurb AREA -->
		<div class="breadcurb-area">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Pages</a></li>
					<li>Chart</li>
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
										<th class="th-product">Product</th>
										<th class="th-details">Tên</th>
										<th class="th-qty">Số lượng</th>
										<th class="th-price">Đơn giá</th>
										<th class="th-total">Tổng</th>
										<th class="th-delate">Xóa</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($carts as $cart)
										<tr>
											<td class="th-product">
												<img src="{{ asset('storage/product/'.$cart['image']) }}" alt="cart">
											</td>
											<td class="th-details">
												{{$cart['name']}}
											</td>
											<td class="th-qty">
												<input type="number" min="1" value="{{$cart['quantity']}}">
											</td>
											<td class="th-price">{{number_format($cart['price'])}} VNĐ</td>
											<td class="th-total">{{number_format($cart['price']*$cart['quantity'])}} VNĐ</td>
											<td class="th-delate"><a href="#"><i class="fa fa-trash"></i></a></td>
										</tr>
									@empty
										<tr>
											<td colspan=6>Chưa có sản phẩm nào</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
						<div class="cart-button">
							<button type="button" class="btn">Continue Shopping</button>
							<button type="button" class="btn floatright">Update Cart</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="cart-shopping-area fix">
						<div class="col-md-4 col-sm-4">
							<div class="calculate-shipping chart-all">
								<h2>CALCULATE SHIPPING</h2>
								<p>Enter your destination to get a shipping estimate.</p>
								<select>
									<option>Sellect Country</option>
									<option>America</option>
									<option>Afganisthan</option>
									<option>Bangladesh</option>
									<option>Chin</option>
									<option>Japna</option>
								</select>
								<select>
									<option>State/Provinence</option>
									<option>Dhaka</option>
									<option>Borishal</option>
									<option>Gajipur</option>
									<option>Kustiya</option>
									<option>Vola</option>
									<option>Gaibandha</option>
								</select>
								<input type="text" placeholder="Zip / Post Code">
								<button type="button" class="btn">Get A Quote</button>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="chart-all">
								<h2>PROMOTIONAL CODE</h2>
								<p>Enter your destination to get a shipping estimate.</p>
								<input type="text" placeholder="Zip / Post Code">
								<button type="button" class="btn">Get A Quote</button>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="shopping-summary chart-all">
								<div class="shopping-cost-area">
									<h2>SHOPPING BAG SUMMARY</h2>
									<div class="shopping-cost">
										<div class="shopping-cost-left">
											<p>Sub Total </p>
											<p>GRAND TOTAL </p>
										</div>
										<div class="shopping-cost-right">
											<p>$2.010.00</p>
											<p>$2.010.00</p>
										</div>
									</div>
									<button type="button" class="btn">Proceed to Checkout</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection