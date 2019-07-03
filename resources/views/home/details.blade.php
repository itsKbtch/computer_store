@extends('index')
@section('title')
	{{$product->name}} | HK
@endsection
@section('content')
		<!-- Breadcurb AREA -->
		<div class="breadcurb-area">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="{{ route('home') }}">Trang chủ</a></li>
					@foreach ($product->categories as $crum)
						@if (empty($crum->parent_id))
							<li><a href="{{ route('category', [str_slug($crum->name).'-'.$crum->id]) }}">{{$crum->name}}</a></li>
						@else
							<li><a href="{{ route('category', [str_slug($crum->parentCategory->name).'-'.$crum->parentCategory->id, str_slug($crum->name).'-'.$crum->id]) }}">{{$crum->name}}</a></li>
						@endif
					@endforeach
				</ul>
			</div>
		</div>
		<!-- Product Item AREA -->
		<div class="product-item-area">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-4">
						<div class="add-shop">
							@forelse ($slideshow as $slide)
								<div class="add-kids single-add">
									<a href="{{$slide->link}}"><img src="{{asset('storage/slide/'.$slide->photo)}}" alt="{{$slide->caption}}" title="{{$slide->link}}"></a>
								</div>
							@empty
								<div class="add-kids single-add">
									<a href="#"><img src="{{asset('img/banner/kids-ad.jpg')}}" alt="add"></a>
								</div>
							@endforelse
						</div>
					</div>
					<div class="col-md-9 col-sm-8">
						<div class="row">
							<div class="col-md-5 col-sm-5">
								<div class="product-item-tab">
									<!-- Tab panes -->
									<div class="single-tab-content">
										<div class="tab-content">
											@forelse ($product->photos as $photo)
												<div role="tabpanel" class="tab-pane{{$loop->first? ' active':''}}" id="img{{$photo->id}}"><img src="{{asset('storage/product/'.$photo->name)}}" alt="{{$photo->name}}" width="100%"></div>
											@empty
												<div role="tabpanel" class="tab-pane active" id="img-one"><img src="{{asset('img/single-product/single-product-1.jpg')}}" alt="tab-img" width="100%"></div>
											@endforelse
										</div>
									</div>
									<!-- Nav tabs -->
									<div class="single-tab-img">
										<ul class="nav nav-tabs" role="tablist">
											@forelse ($product->photos as $photo)
												<li role="presentation" class="{{$loop->first? 'active':''}}"><a href="#img{{$photo->id}}" role="tab" data-toggle="tab"><img src="{{asset('storage/product/'.$photo->name)}}" alt="{{$photo->name}}" width="100px"></a></li>
											@empty
												<li role="presentation" class="active"><a href="#img-one" role="tab" data-toggle="tab"><img src="{{asset('img/single-product/single-product-1.jpg')}}" alt="tab-img" width="100px"></a></li>
											@endforelse
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-7 col-sm-7">
								<div class="product-tab-content">
									<div class="product-tab-header">
										<h1>{{$product->name}}</h1>
										<div class="best-product-rating">
											<a href="#"><i class="fa fa-star"></i></a>
											<a href="#"><i class="fa fa-star"></i></a>
											<a href="#"><i class="fa fa-star"></i></a>
											<a href="#"><i class="fa fa-star"></i></a>
											<a href="#"><i class="fa fa-star"></i></a>
											<p>(3 costomar review)</p>
										</div>
										<h3 style="{{!empty($product->discount_end_time)? 'text-decoration: line-through':''}}">{{number_format($product->price)}} VNĐ</h3>
										@if (!empty($product->discount_percent))
					                       <h3>
					                       	<span class="badge badge-pill badge-warning text-uppercase">giảm {{$product->discount_percent}}%</span>
					                       	{{number_format($product->price - $product->price*$product->discount_percent/100)}} VNĐ
					                       </h3>
					                    @endif
					                    @if (!empty($product->discount_cash))
					                       <h3>
					                       	<span class="badge badge-pill badge-warning text-uppercase">giảm {{number_format($product->discount_cash)}}</span>
					                       	{{number_format($product->price - $product->discount_cash)}} VNĐ
					                       </h3>
					                    @endif
									</div>
									<div class="product-item-code">
										<p>Tình trạng: 
											@if ($product->status == 1)
					                        	<span class="badge badge-pill badge-primary">Còn hàng</span>
					                      	@endif
					                      	@if ($product->status == 2)
					                        	<span class="badge badge-pill badge-primary">Hết hàng</span>
					                      	@endif
					                      	@if ($product->status == 3)
					                        	<span class="badge badge-pill badge-primary">Sắp về</span>
					                      	@endif
					                  	</p>
									</div>
									<div class="product-item-details">
										<p>
										@php
											echo nl2br($product->description);
										@endphp
										</p>
									</div>
									@if (!$product->promotion->isEmpty())
									<div class="available-option">
										<h2>Khuyến mại:</h2>
										<ul>
											@foreach ($product->promotion as $promo)
												<li>{{$promo->name}}</li>
											@endforeach
										</ul>
									</div>
									@endif
									<form action="{{ route('addCart') }}" method="POST" style="margin-top: 20px">
										@csrf
										<input type="hidden" name='id' value={{$product->id}}>
										<button type="submit" class="btn btn-warning">Thêm vào giỏ hang</button>
									</form>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="description-tab">
								<!-- Nav tabs -->
									<ul class="nav nav-tabs" role="tablist">
										<li role="presentation" class="active"><a href="#description" role="tab" data-toggle="tab">Thông số kĩ thuật</a></li>
									</ul>
									  <!-- Tab panes -->
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="description">
											<table class="table table-bordered">
												@forelse ($product->details as $detail)
													<tr>
														<td>{{$detail->name}}</td>
														<td>{{$detail->value}}</td>
													</tr>
												@empty
													<tr>
														<td>Không có thông số</td>
													</tr>
												@endforelse
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="single-product-slider similar-product">
									<div class="product-items">
										<h2 class="product-header">Có thể bạn quan tâm</h2>
										<div class="row">
											<div id="singleproduct-slider" class="owl-carousel">
												@forelse ($relates as $relate)
												<div class="col-md-4">
													<div class="single-product">
														<div class="single-product-img">
															<a href="#">
																@if (!$relate->photos->isEmpty())
																	<img class="primary-img" src="{{asset('storage/product/'.$relate->photos[0]->name)}}" alt="{{$relate->name}}">
																@else
																	<img class="primary-img" src="img/product/single-product-1.jpg" alt="product">
																@endif
															</a>
															<div class="single-product-action">
																<a href="{{ route('details', [str_slug($relate->name)."-".$relate->id]) }}"><i class="fa fa-external-link"></i></a>
																<a href="#"><i class="fa fa-shopping-cart"></i></a>
															</div>
														</div>
														<div class="single-product-content">
															<div class="product-content-left">
																<h2><a href="{{ route('details', [str_slug($relate->name)."-".$relate->id]) }}">{{$relate->name}}</a></h2>
																<p style="{{!empty($relate->discount_end_time)? 'text-decoration: line-through':''}}">{{number_format($relate->price)}} VNĐ</p>
															</div>

															@if (!empty($relate->discount_end_time))
															<div class="product-content-right">
																@if (!empty($relate->discount_percent))
											                       <h3>
											                       	<span class="badge badge-pill badge-warning text-uppercase">giảm {{$relate->discount_percent}}%</span>
											                       	{{number_format($relate->price - $relate->price*$relate->discount_percent/100)}} VNĐ
											                       </h3>
											                    @endif
											                    @if (!empty($relate->discount_cash))
											                       <h3>
											                       	<span class="badge badge-pill badge-warning text-uppercase">giảm {{number_format($relate->discount_cash)}}</span>
											                       	{{number_format($relate->price - $relate->discount_cash)}} VNĐ
											                       </h3>
											                    @endif
																
															</div>
															@endif										
														</div>
													</div>
												</div>
												@empty
												<div class="col-md-4">Chưa có sản phẩm nào</div>
												@endforelse
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection