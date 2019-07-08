@extends('index')
@section('title')
	Home | HK
@endsection
@section('content')
		<!-- Slider AREA -->
		@if (!$slideshow->isEmpty())
		<div class="slider-area" style="margin-bottom: 1.5em;">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- Main Slider -->
						<div class="main-slider">
							<div class="slider">
								<div id="mainSlider" class="nivoSlider slider-image">
									@foreach ($slideshow as $slide)
										<img src="{{asset('storage/slide/'.$slide->photo)}}" alt="{{$slide->photo}}" title="#htmlcaption{{$slide->id}}"/>
									@endforeach
								</div>
								@foreach ($slideshow as $slide)
									<div id="htmlcaption{{$slide->id}}" class="nivo-html-caption slider-caption-{{$slide->id}}">
										<div class="slider-progress"></div>									
										<div class="slide-text">
											<div class="middle-text">
												<div class="cap-dec wow slideInDown" data-wow-duration="1.1s" data-wow-delay="0s">
													<h3 style="text-shadow: 0px 0px 10px #FFA726">{{$slide->caption}}</h3>
												</div>	
												<div class="cap-readmore animated bounceIn" data-wow-duration="1.5s" data-wow-delay=".5s">
													<a href="{{$slide->link}}">Xem chi tiết</a>
												</div>	
											</div>	
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		
        <!-- Product AREA -->
		<div class="product-area">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-4">
						<div class="product-catagori-area">
							<div class="best-seller-area">
								<h2 class="header-title">Sản phẩm bán chạy</h2>
								@forelse ($bestSellers as $bestSeller)
									<div class="best-sell-product">
										<div class="best-product-img" style="width: 100%; padding: 0;">
											<a href="{{ route('details', [str_slug($bestSeller->name)."-".$bestSeller->id]) }}">
												@if (!$bestSeller->photos->isEmpty())
													<img class="primary-img" src="{{asset('storage/product/'.$bestSeller->photos[0]->name)}}" alt="{{$bestSeller->name}}">
												@else
													<img src="{{asset('img/product/best-product-2.png')}}" alt="product">
												@endif
											</a>
										</div>
										<div class="best-product-content">
											<h2><a href="{{ route('details', [str_slug($bestSeller->name)."-".$bestSeller->id]) }}">{{$bestSeller->name}}</a></h2>
											<h3 style="{{!empty($bestSeller->discount_end_time)? 'text-decoration: line-through':''}}">{{number_format($bestSeller->price)}} VNĐ</h3>

											@if (!empty($bestSeller->discount_percent))
						                       <h3>
						                       	{{number_format($bestSeller->price - $bestSeller->price*$bestSeller->discount_percent/100)}} VNĐ 
						                       	<span class="badge badge-pill badge-warning text-uppercase">giảm {{$bestSeller->discount_percent}}%</span>
						                       </h3>
						                    @endif
						                    @if (!empty($bestSeller->discount_cash))
						                       <h3>
						                       	{{number_format($bestSeller->price - $bestSeller->discount_cash)}} VNĐ 
						                       	<span class="badge badge-pill badge-warning text-uppercase">giảm {{number_format($bestSeller->discount_cash)}}</span>
						                       </h3>
						                    @endif

											<div class="best-product-rating">
												@for ($i = 0; $i < 5; $i++)
													@if ($i < round($bestSeller->rate))
														<a><i class="fa fa-star"></i></a>
													@else
														<a><i class="fa fa-star-o"></i></a>	
													@endif
												@endfor
												<span>({{$bestSeller->rate_count}} đánh giá)</span>
											</div>
										</div>
									</div>
								@empty
									<div class="best-sell-product">
										Chưa có sản phẩm nào
									</div>
								@endforelse
								<p class="view-details">
									<a></a>
								</p>
							</div>
							@if (!$slideshow->isEmpty())
								<div class="add-kids single-add">
									<a href="{{$slideshow[0]->link}}"><img src="{{asset('storage/slide/'.$slideshow[0]->photo)}}" alt="{{$slideshow[0]->caption}}" title="{{$slideshow[0]->link}}"></a>
								</div>
							@endif
						</div>
					</div>
					<div class="col-md-9 col-sm-8">
						<div class="product-items-area">
							@if (!$promoProducts->isEmpty())
							<div class="product-items">
								<h2 class="product-header"><a href="{{ route('search')."?filters%5B%5D=discount&filters%5B%5D=promotion" }}">Khuyến mại HOT</a></h2>
								<div class="row">
									<div id="product-slider" class="owl-carousel">
										@foreach ($promoProducts as $product)
										<div class="col-md-4">
											<div class="single-product">
												<div class="single-product-img">
													<a href="{{ route('details', [str_slug($product->name)."-".$product->id]) }}">
														@if (!$product->photos->isEmpty())
															<img class="primary-img" src="{{asset('storage/product/'.$product->photos[0]->name)}}" alt="{{$product->name}}">
														@else
															<img class="primary-img" src="{{asset('img/product/single-product-1.jpg')}}" alt="product">
														@endif
													</a>
													<div class="single-product-action">
														<a href="{{ route('details', [str_slug($product->name)."-".$product->id]) }}"><i class="fa fa-external-link"></i></a>
													</div>
												</div>
												<div class="single-product-content">
													<div class="product-content-left">
														<h2><a href="{{ route('details', [str_slug($product->name)."-".$product->id]) }}">{{$product->name}}</a></h2>
														<p style="{{!empty($product->discount_end_time)? 'text-decoration: line-through':''}}">{{number_format($product->price)}} VNĐ</p>
													</div>

													@if (!empty($product->discount_end_time))
													<div class="product-content-right">
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
													@endif										
												</div>
											</div>
										</div>
										@endforeach
									</div>
								</div>
							</div>
							@endif
							
							@forelse ($categories as $category)
							<div class="product-items">
								<h2 class="product-header"><a href="{{ route('category', [str_slug($category->name).'-'.$category->id]) }}">{{$category->name}}</a></h2>
								<div class="row">
									<div id="product-slider" class="owl-carousel">
										@forelse ($category->products as $product)
										<div class="col-md-4">
											<div class="single-product">
												<div class="single-product-img">
													<a href="{{ route('details', [str_slug($product->name)."-".$product->id]) }}">
														@if (!$product->photos->isEmpty())
															<img class="primary-img" src="{{asset('storage/product/'.$product->photos[0]->name)}}" alt="{{$product->name}}">
														@else
															<img class="primary-img" src="{{asset('img/product/single-product-1.jpg')}}" alt="product">
														@endif
													</a>
													<div class="single-product-action">
														<a href="{{ route('details', [str_slug($product->name)."-".$product->id]) }}"><i class="fa fa-external-link"></i></a>
													</div>
												</div>
												<div class="single-product-content">
													<div class="product-content-left">
														<h2><a href="{{ route('details', [str_slug($product->name)."-".$product->id]) }}">{{$product->name}}</a></h2>
														<p style="{{!empty($product->discount_end_time)? 'text-decoration: line-through':''}}">{{number_format($product->price)}} VNĐ</p>
													</div>

													@if (!empty($product->discount_end_time))
													<div class="product-content-right">
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
							@empty
							Chưa có sản phẩm nào	
							@endforelse
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection