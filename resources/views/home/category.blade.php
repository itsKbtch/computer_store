@extends('index')
@section('title')
	{{!empty($subCategory)? $subCategory->name:$mainCategory->name}} | HK
@endsection
@section('content')
	<div class="breadcurb-area">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="{{ route('home') }}">Trang chủ</a></li>
					@if (!empty($subCategory))
						<li><a href="{{ route('category', [str_slug($mainCategory->name).'-'.$mainCategory->id]) }}">{{$mainCategory->name}}</a></li>
						<li>{{$subCategory->name}}</li>
					@else
						<li>{{$mainCategory->name}}</li>
					@endif
				</ul>
			</div>
		</div>
		<!-- Product Item AREA -->
		<div class="product-item-area">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-4">
						<div class="product-categeries">
							<h2>Bộ lọc</h2>
							<div class="panel-group" id="accrodian">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<i class="fa fa-th-large"></i> Ưu đãi
											<a class="collapsed" data-toggle="collapse" href="#promo" data-parent="#accrodian"></a>
										</h4>
									</div>
									<div class="panel-collapse collapse" id="promo">
										<div class="panel-body">
											<div style="padding: 20px;">
												<input type="checkbox" class="filter" name="filters%5B%5D" value="discount"{{(isset($_GET['filters']) && in_array('discount', $_GET['filters']))? ' checked':''}}> Đang giảm giá<br>
												<input type="checkbox" class="filter" name="filters%5B%5D" value="promotion"{{(isset($_GET['filters']) && in_array('promotion', $_GET['filters']))? ' checked':''}}> Có khuyến mại<br>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="product-item-categori">
							<div class="product-type">
								<h2>Danh mục</h2>
								<ul>
									@forelse ($mainCategory->subCategories as $category)
										<li>
											<a href="{{ route('category', [str_slug($mainCategory->name).'-'.$mainCategory->id, str_slug($category->name).'-'.$category->id]) }}">
												<i class="fa fa-angle-right"></i>{{$category->name}}
											</a>
										</li>
									@empty
										<li><a>Không có danh mục nào</a></li>
									@endforelse
								</ul>
							</div>
						</div>
						<div class="product-item-categori">
							<div class="product-type">
								<h2>Khoảng giá</h2>
								<ul>
									<li>
										<a style="cursor: pointer;{{isset($_GET['price']) && $_GET['price'] == 'all'? ' color: #ffa726;':''}}" class="price" value="all"><i class="fa fa-angle-right"></i>Tất cả</a>
									</li>
									<li>
										<a style="cursor: pointer;{{isset($_GET['price']) && $_GET['price'] == 'lower1'? ' color: #ffa726;':''}}" class="price" value="lower1"><i class="fa fa-angle-right"></i>Dưới 1 triệu</a>
									</li>
									<li>
										<a style="cursor: pointer;{{isset($_GET['price']) && $_GET['price'] == 'from1to2'? ' color: #ffa726;':''}}" class="price" value="from1to2"><i class="fa fa-angle-right"></i>Từ 1 triệu tới 2 triệu</a>
									</li>
									<li>
										<a style="cursor: pointer;{{isset($_GET['price']) && $_GET['price'] == 'from2to5'? ' color: #ffa726;':''}}" class="price" value="from2to5"><i class="fa fa-angle-right"></i>Từ 2 triệu tới 5 triệu</a>
									</li>
									<li>
										<a style="cursor: pointer;{{isset($_GET['price']) && $_GET['price'] == 'from5to10'? ' color: #ffa726;':''}}" class="price" value="from5to10"><i class="fa fa-angle-right"></i>Từ 5 triệu tới 10 triệu</a>
									</li>
									<li>
										<a style="cursor: pointer;{{isset($_GET['price']) && $_GET['price'] == 'greater10'? ' color: #ffa726;':''}}" class="price" value="greater10"><i class="fa fa-angle-right"></i>Trên 10 triệu</a>
									</li>
								</ul>
							</div>
						</div>
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
						<div class="product-item-list">
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="product-item-heading">
										<div class="item-heading-title">
											<h2>{{!empty($subCategory)? $subCategory->name:$mainCategory->name}}</h2>
										</div>
										<div class="result-short-view">
											<div class="result-short">
												<p>{{$products->count()}} sản phẩm</p>
												<div class="result-short-selection">
													<select class="sort">
														<option value="gia-cao-den-thap"{{isset($_GET['sort'])? $_GET['sort'] == 'gia-cao-den-thap'? ' selected':'':' selected'}}>Giá cao đến thấp</option>
														<option value="gia-thap-den-cao"{{isset($_GET['sort']) && $_GET['sort'] == 'gia-thap-den-cao'? ' selected':''}}>Giá thấp đến cao</option>
													</select>
													<i class="fa fa-sort-alpha-asc"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="display: flex; flex-wrap: wrap">
								@forelse ($products as $product)
									<div class="col-md-4 col-sm-6">
										<div class="single-item-area">
											<div class="single-item">
												<div class="product-item-img">
													<a href="{{ route('details', [str_slug($product->name)."-".$product->id]) }}">
														@if (!$product->photos->isEmpty())
															<img class="primary-img" src="{{asset('storage/product/'.$product->photos[0]->name)}}" alt="{{$product->name}}" style="object-fit: cover; width: 100%; height: 100%;">
														@else
															<img class="primary-img" src="{{asset('img/product/single-product-1.jpg')}}" alt="product">
														@endif
													</a>
													<div class="product-item-action">
														<a href="{{ route('details', [str_slug($product->name)."-".$product->id]) }}"><i class="fa fa-external-link"></i></a>
													</div>
												</div>
												<div class="single-item-content">
													<h2><a href="{{ route('details', [str_slug($product->name)."-".$product->id]) }}">{{$product->name}}</a></h2>
													<div class="best-product-rating">
														@for ($i = 0; $i < 5; $i++)
															@if ($i < round($product->rate))
																<a><i class="fa fa-star"></i></a>
															@else
																<a><i class="fa fa-star-o"></i></a>	
															@endif
														@endfor
														<span>({{$product->rate_count}} đánh giá)</span>
													</div>
													<h3 style="{{!empty($product->discount_end_time)? 'text-decoration: line-through':''}}">{{number_format($product->price)}} VNĐ</h3>
													@if (!empty($product->discount_percent))
								                       <h3>
								                       	{{number_format($product->price - $product->price*$product->discount_percent/100)}} VNĐ
								                       	<span class="badge badge-pill badge-warning text-uppercase">giảm {{$product->discount_percent}}%</span>
								                       </h3>
								                    @endif
								                    @if (!empty($product->discount_cash))
								                       <h3>
								                       	{{number_format($product->price - $product->discount_cash)}} VNĐ
								                       	<span class="badge badge-pill badge-warning text-uppercase">giảm {{number_format($product->discount_cash)}}</span>
								                       </h3>
								                    @endif
												</div>
											</div>
											<div class="item-action-button fix">
												<a href="{{ route('details', [str_slug($product->name)."-".$product->id]) }}" style="width: 100%">
													Xem chi tiết
												</a>
											</div>
										</div>
									</div>
								@empty
									<div class="col-md-4 col-sm-6">
									Không có sản phẩm nào
									</div>
								@endforelse
							</div>
						</div>
						<div class="floatright">
							{{$products->links()}}
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			var price = "{{(isset($_GET['price']))? $_GET['price']:''}}";
			var sort = "{{(isset($_GET['sort']))? $_GET['sort']:''}}";
			var filters = [];

			function filter() {
              var url = "?";

              $.each(filters, function(index, val) {
                url = url + val;
                if (index < filters.length-1) {
                  url = url + "&";
                }
              });

              if (filters.length > 0) {
                url = url + "&";
              }

              if (price != "") {
                url = url + "price=" + price + "&";
              }
              
              if (sort != "") {
                url = url + "sort=" + sort;
              }

              if ((filters.length > 0 && sort == "" && price == "") || (price != "" && sort == "")) {
                url = url.substr(0, url.length-1);
              }
              
              window.location.href = url;
            }

            $(function() {
            	$(".sort").on('change', function() {
	            	sort = $(this).val();
	            	$('.filter:checked').each(function() {
	                  filters.push($(this).attr('name') + "=" + $(this).val());
	                });
	                filter();
	            });
	            $(".price").on('click', function() {
	            	price = $(this).attr('value');
	            	$('.filter:checked').each(function() {
	                  filters.push($(this).attr('name') + "=" + $(this).val());
	                });
	                filter();
	            });
	            $(".filter").on('change', function() {
	                $('.filter:checked').each(function() {
	                  filters.push($(this).attr('name') + "=" + $(this).val());
	                });
	               	filter();
	            });
            })

		</script>
@endsection