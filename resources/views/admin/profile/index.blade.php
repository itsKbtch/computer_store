@extends('admin.index')

@section('breadcrumb')
	<ol class="breadcrumb bg-white m-0">
	    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Thông tin cá nhân</li>
	</ol>	
@endsection

@section('content')
		  	@if (session('success'))
	    	<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
	    	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    	    <span aria-hidden="true">×</span>
	    	  </button>
	    	  <i class="fa fa-info mx-2"></i>
	    	  {{session('success')}}
	    	</div>
	      	@endif

	      @if (session('fail'))
	      <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
	        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	          <span aria-hidden="true">×</span>
	        </button>
	        <i class="fa fa-info mx-2"></i>
	        {{session('fail')}}
	      </div>    
	      @endif

          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Admin</span>
                <h3 class="page-title">Thông tin cá nhân</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <!-- Default Light Table -->
            <div class="row">
              <div class="col-12">
                <div class="card card-small mb-4">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col">
                          <form action="{{ route('admin.profile.update') }}" method="post">
                          	@csrf
                            <div class="form-group">
                              <label for="name">Họ tên:</label>
                              <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name" value="{{Auth::user()->name}}"> 
                              @error('name')
                              	<div class="invalid-feedback">{{$message}}</div>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="username">Tên tài khoản:</label>
                              <input type="text" class="form-control @error('username')is-invalid @enderror" id="username" name="username" value="{{Auth::user()->username}}"> 
                              @error('username')
                              	<div class="invalid-feedback">{{$message}}</div>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="email">Email:</label>
                              <input type="email" class="form-control @error('email')is-invalid @enderror" id="email" name="email" value="{{Auth::user()->email}}"> 
                              @error('email')
                              	<div class="invalid-feedback">{{$message}}</div>
                              @enderror
                            </div>
                            <div class="text-center">
                            	<button type="submit" class="btn btn-accent">Cập nhật tài khoản</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- End Default Light Table -->
          </div>
@endsection