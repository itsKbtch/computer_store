<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if lt IE 7 ]> <html lang="en" class="ie6">    <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7">    <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8">    <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie9">    <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@yield('title')</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Favicon
		============================================ -->
		<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/logo-HK-title.png')}}">
		
		<!-- Fonts
		============================================ -->
		<link href='https://fonts.googleapis.com/css?family=Raleway:400,700,600,500,300,800,900' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,300,300italic,500italic,700' rel='stylesheet' type='text/css'>

 		<!-- CSS  -->
		
		<!-- Bootstrap CSS
		============================================ -->      
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        
		<!-- font-awesome.min CSS
		============================================ -->      
        <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
		
		<!-- Mean Menu CSS
		============================================ -->      
        <link rel="stylesheet" href="{{asset('css/meanmenu.min.css')}}">
        
		<!-- owl.carousel CSS
		============================================ -->      
        <link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}">
        
		<!-- owl.theme CSS
		============================================ -->      
        <link rel="stylesheet" href="{{asset('css/owl.theme.css')}}">
  	
		<!-- owl.transitions CSS
		============================================ -->      
        <link rel="stylesheet" href="{{asset('css/owl.transitions.css')}}">
		
		<!-- Price Filter CSS
		============================================ --> 
        <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">	

		<!-- nivo-slider css
		============================================ --> 
		<link rel="stylesheet" href="{{asset('css/nivo-slider.css')}}">
        
 		<!-- animate CSS
		============================================ -->         
        <link rel="stylesheet" href="{{asset('css/animate.css')}}">
		
		<!-- jquery-ui-slider CSS
		============================================ --> 
		<link rel="stylesheet" href="{{asset('css/jquery-ui-slider.css')}}">
        
 		<!-- normalize CSS
		============================================ -->        
        <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
   
        <!-- main CSS
		============================================ -->          
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
        
        <!-- style CSS
		============================================ -->          
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        
        <!-- responsive CSS
		============================================ -->          
        <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
        
        <script src="{{asset('js/vendor/modernizr-2.8.3.min.js')}}"></script>

        <script src="{{asset('js/vendor/jquery-1.11.3.min.js')}}"></script>
    </head>
    <body class="home-one">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
               
        <!-- HEADER AREA -->
        <div class="header-area">
			<div class="header-top-bar">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="header-top-left">
								@auth
									<p>Xin chào {{Auth::user()->name}}!</p>
								@endauth
								@guest
								    <p>HK xin chào quý khách!</p>
								@endguest
							</div>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="header-top-right">
								<ul class="list-inline">
									@auth
										<li><a href="{{ route('account.index') }}"><i class="fa fa-user"></i>Tài khoản</a></li>
										<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-unlock"></i>Đăng xuất</a></li>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                                        @csrf
	                                    </form>
									@endauth
									@guest
									    <li><a href="{{ route('login') }}"><i class="fa fa-lock"></i>Đăng nhập</a></li>
										<li><a href="{{ route('register') }}"><i class="fa fa-pencil-square-o"></i>Đăng kí</a></li>
									@endguest
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header-bottom">
				<div class="container">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-12">
							<div class="header-logo">
								<a href="{{ route('home') }}"><img src="{{asset('img/logo-HK.png')}}" width="70%" alt="logo"></a>
							</div>
						</div>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<div class="search-chart-list">
								<div class="header-search">
									<form action="{{ route('search') }}">
										<input type="text" name="keyword" placeholder="Search"/>
										<button type="submit"><i class="fa fa-search"></i></button>
									</form>
								</div>
								<div class="header-chart">
									<ul class="list-inline" style="display: flex">
										<li><a href="{{ route('cartList') }}"><i class="fa fa-cart-arrow-down"></i></a></li>
										<li class="chart-li"><a href="{{ route('cartList') }}">Giỏ hàng</a>
											<ul>
                                                <li>
                                                	@php
                                                		$total = 0;
                                                	@endphp
                                                    <div class="header-chart-dropdown">
                                                    	@forelse ($carts as $cart)
                                                    		<div class="header-chart-dropdown-list">
	                                                            <div class="dropdown-chart-right">
	                                                                <h2><a href="{{ route('details', [str_slug($cart['name'])."-".$cart['id']]) }}">{{$cart['name']}}</a></h2>
	                                                                <h3>Số lượng: {{$cart['quantity']}}</h3>
	                                                                <h4>Đơn giá: {{number_format($cart['price'])}} VNĐ</h4>
	                                                            </div>
	                                                        </div>
	                                                        @php
	                                                        	$total = $total + $cart['price']*$cart['quantity'];
	                                                        @endphp
                                                    	@empty
                                                    		<div class="header-chart-dropdown-list">
	                                                            Chưa có sản phẩm nào
	                                                        </div>
                                                    	@endforelse
														<div class="chart-checkout">
															<p>Tổng<span>{{number_format($total)}} VNĐ</span></p>
															@if (!empty($carts))
																<button type="button" class="btn btn-default"><a href="{{ route('checkout') }}" width="100%">Đặt hàng</a></button>
															@endif
														</div>
                                                    </div> 
                                                </li> 
                                            </ul> 
										</li>
										<li><a href="{{ route('cartList') }}">{{count($carts)}} sản phẩm</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- MAIN MENU AREA -->
		<div class="main-menu-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="main-menu hidden-xs">
							<nav>
								<ul>
									<li><a href="{{ route('home') }}">Trang chủ</a></li>
									@forelse ($categories as $category)		
										<li><a href="{{ route('category', [str_slug($category->name).'-'.$category->id]) }}">{{$category->name}}</a>
											<ul class="sub-menu">
												@foreach ($category->subCategories as $subCategory)
													<li><a href="{{ route('category', [str_slug($category->name).'-'.$category->id, str_slug($subCategory->name).'-'.$subCategory->id]) }}">{{$subCategory->name}}</a></li>
												@endforeach
											</ul>
										</li>
									@empty
										
									@endforelse
								</ul>
							</nav>
						</div>
						<!-- Mobile MENU AREA -->
						<div class="mobile-menu hidden-sm hidden-md hidden-lg">
							<nav>
								<ul>
									<li><a href="{{ route('home') }}">Trang chủ</a></li>
									@forelse ($categories as $category)		
										<li><a href="{{ route('category', [str_slug($category->name).'-'.$category->id]) }}">{{$category->name}}</a>
											<ul class="sub-menu">
												@foreach ($category->subCategories as $subCategory)
													<li><a href="{{ route('category', [str_slug($category->name).'-'.$category->id, str_slug($subCategory->name).'-'.$subCategory->id]) }}">{{$subCategory->name}}</a></li>
												@endforeach
											</ul>
										</li>
									@empty
										
									@endforelse
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
        @yield('content')
		<!-- Footer AREA -->
		<div class="footer-area">
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-sm-12">
							<div class="footer-info-card">
								<div class="footer-logo">
									<a href="index.html"><img src="{{asset('img/footer-logo.png')}}" alt="logo"></a>
								</div>
								<p>Lorem ipsum dolor sit amet, coetuer adipiscing elit. Aenean comodo liula eget dolor. Aenean massa. Cum sociis natoque penatibus.</p>
								<ul class="list-inline">
									<li><a href="#"><img src="{{asset('img/visa-card/visa-card-1.png')}}" alt="card" class="img-responsive"></a></li>
									<li><a href="#"><img src="{{asset('img/visa-card/visa-card-2.png')}}" alt="card" class="img-responsive"></a></li>
									<li><a href="#"><img src="{{asset('img/visa-card/visa-card-3.png')}}" alt="card" class="img-responsive"></a></li>
									<li><a href="#"><img src="{{asset('img/visa-card/visa-card-4.png')}}" alt="card" class="img-responsive"></a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="footer-menu-area">
								<h2 class="footer-heading">MY ACCOUNT</h2>
								<div class="footer-menu">
									<ul>
										<li><a href="#"><i class="fa fa-angle-right"></i>My Account</a></li>
										<li><a href="#"><i class="fa fa-angle-right"></i>About Us</a></li>
										<li><a href="#"><i class="fa fa-angle-right"></i>Contact</a></li>
										<li><a href="#"><i class="fa fa-angle-right"></i>Affiliates</a></li>
										<li><a href="#"><i class="fa fa-angle-right"></i>Meet The Maker</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 hidden-sm hidden-xs">
							<div class="footer-menu-area">
								<h2 class="footer-heading">Opening time</h2>
								<div class="footer-menu opening-time">
									<ul>
										<li><i class="fa fa-angle-right"></i>Satarday<span>7.00 AM - 7.00 PM</span></li>
										<li><i class="fa fa-angle-right"></i>Sunday<span>7.00 AM - 7.00 PM</span></li>
										<li><i class="fa fa-angle-right"></i>Monday<span>7.00 AM - 7.00 PM</span></li>
										<li><i class="fa fa-angle-right"></i>Tuesday<span>7.00 AM - 7.00 PM</span></li>
										<li><i class="fa fa-angle-right"></i>Thusday<span>7.00 AM - 7.00 PM</span></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="contact-info-area">
								<h2 class="footer-heading">Contact Us</h2>
								<div class="contact-info">
									<div class="contanct-details">
										<div class="info-icon">
											<i class="fa fa-phone"></i>
										</div>
										<div class="info-content">
											<p>+1 (00) 86 868 868 666</p>
											<p>+1 (00) 42 868 666 888</p>
										</div>
									</div>
									<div class="contanct-details">
										<div class="info-icon">
											<i class="fa fa-envelope-o"></i>
										</div>
										<div class="info-content">
											<p>admin@bootexperts.com</p>
											<p>info@bootexperts.com</p>
										</div>
									</div>
									<div class="contanct-details">
										<div class="info-icon">
											<i class="fa fa-map-marker"></i>
										</div>
										<div class="info-content">
											<p>68 Dohava Stress, Lorem isput Spust, New York- US</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
			<div class="footer-bottom">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="copyright">
								Copyrignt@2018 <a href="https://freethemescloud.com/" target="_blank">Free themes Cloud </a>/ ALL RIGHTS RESERVED
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="footer-social-icon">
								<ul class="list-inline">
									<li><a href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
									<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
									<li><a href="#"><i class="fa fa-vimeo"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <!-- JS -->
        
 		<!-- bootstrap js
		============================================ -->         
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
		
		<!-- nivo slider js
		============================================ --> 
		<script src="{{asset('js/jquery.nivo.slider.pack.js')}}"></script>
        
 		<!-- Mean Menu js
		============================================ -->         
        <script src="{{asset('js/jquery.meanmenu.min.js')}}"></script>
        
   		<!-- owl.carousel.min js
		============================================ -->       
        <script src="{{asset('js/owl.carousel.min.js')}}"></script>
		
		<!-- jquery price slider js
		============================================ --> 		
		<script src="{{asset('js/jquery-price-slider.js')}}"></script>
		
		<!-- wow.js
		============================================ -->
        <script src="{{asset('js/wow.js')}}"></script>		
		<script>
			new WOW().init();
		</script>
        
   		<!-- plugins js
		============================================ -->         
        <script src="{{asset('js/plugins.js')}}"></script>
		
   		<!-- main js
		============================================ -->           
        <script src="{{asset('js/main.js')}}"></script>


    </body>
</html>
