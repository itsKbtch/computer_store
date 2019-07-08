<!doctype html>
<html class="no-js h-100" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>HK - Trang quản trị</title>
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="{{asset('admin_assets/styles/shards-dashboards.1.1.0.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/styles/extras.1.1.0.min.css')}}">
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  </head>
  <body class="h-100">
    <div class="container-fluid">
      <div class="row">
        <!-- Main Sidebar -->
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="{{asset('admin_assets/images/shards-dashboards-logo.svg')}}" alt="Shards Dashboard">
                  <span class="d-none d-md-inline ml-1">HK</span>
                </div>
              </a>
              <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
              </a>
            </nav>
          </div>
          <div class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
            @yield('breadcrumb')
          </div>
          <div class="nav-wrapper">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link{{strpos(Route::currentRouteName(), 'admin.home') !== false? ' active':''}}" href="{{route('admin.home.index')}}">
                  <i class="material-icons">home</i>
                  <span>Trang chủ</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link{{strpos(Route::currentRouteName(), 'admin.shop') !== false? ' active':''}}" href="{{route('admin.shop.info')}}">
                  <i class="material-icons">info</i>
                  <span>Thông tin cửa hàng</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link{{strpos(Route::currentRouteName(), 'admin.invoice') !== false? ' active':''}}" href="{{route('admin.invoice.index')}}">
                  <i class="material-icons">receipt</i>
                  <span>Đơn hàng</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link{{strpos(Route::currentRouteName(), 'admin.stock') !== false? ' active':''}}" href="{{route('admin.stock.index')}}">
                  <i class="material-icons">view_module</i>
                  <span>Kho hàng</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link{{strpos(Route::currentRouteName(), 'admin.category') !== false? ' active':''}}" href="{{route('admin.category.index')}}">
                  <i class="material-icons">category</i>
                  <span>Quản lí danh mục</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link{{(strpos(Route::currentRouteName(), 'admin.promo') !== false || strpos(Route::currentRouteName(), 'admin.code') !== false)? ' active':''}}" href="#promo" data-toggle="collapse" data-target="#promo" aria-expanded="{{strpos(Route::currentRouteName(), 'admin.promo') !== false? 'true':'false'}}" aria-controls="promo">
                  <i class="material-icons">redeem</i>
                  <span>Promotions</span>
                </a>
              </li>
              <div class="collapse{{(strpos(Route::currentRouteName(), 'admin.promo') !== false || strpos(Route::currentRouteName(), 'admin.code') !== false)? ' show':''}}" id="promo">
                <li class="nav-item">
                  <a class="pl-5 py-2 nav-link{{strpos(Route::currentRouteName(), 'admin.promo') !== false? ' active':''}}" href="{{route('admin.promo.index')}}">
                    <span>Khuyến mại</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="pl-5 py-2 nav-link{{strpos(Route::currentRouteName(), 'admin.code') !== false? ' active':''}}" href="{{route('admin.code.index')}}">
                    <span>Mã giảm giá</span>
                  </a>
                </li>
              </div>
              <li class="nav-item">
                <a class="nav-link{{strpos(Route::currentRouteName(), 'admin.users') !== false? ' active':''}}" href="{{route('admin.users.index')}}">
                  <i class="material-icons">person</i>
                  <span>Thành viên</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link{{strpos(Route::currentRouteName(), 'admin.slideshow') !== false? ' active':''}}" href="{{route('admin.slideshow.index')}}">
                  <i class="material-icons">photo</i>
                  <span>Slideshow</span>
                </a>
              </li>
            </ul>
          </div>
        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
          <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
              <div class="main-navbar__search w-100 d-none d-md-flex d-lg-flex align-items-center">
                  @yield('breadcrumb')
              </div>
              <ul class="navbar-nav border-left flex-row ">
                <li class="nav-item dropdown d-flex align-items-center">
                  <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" data-display="static" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->username }} <span class="caret"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small dropdown-menu-md-right">
                    <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                      <i class="material-icons">&#xE7FD;</i> Thông tin cá nhân
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.profile.changePasswordForm') }}">
                      <i class="material-icons">lock</i> Đổi mật khẩu
                    </a>
                    <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="{{ route('admin.logout') }} "
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                       </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                        </form>
                  </div>
                </li>
              </ul>
              <nav class="nav">
                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-sm-inline d-md-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                  <i class="material-icons">&#xE5D2;</i>
                </a>
              </nav>
            </nav>
          </div>
          <!-- / .main-navbar -->
          @yield('content')
          <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
            <span class="copyright ml-auto my-auto mr-2">Copyright © 2018
              <a href="https://designrevision.com" rel="nofollow">DesignRevision</a>
            </span>
          </footer>
        </main>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    <script src="{{asset('admin_assets/scripts/extras.1.1.0.min.js')}}"></script>
    <script src="{{asset('admin_assets/scripts/shards-dashboards.1.1.0.min.js')}}"></script>
  </body>
</html>