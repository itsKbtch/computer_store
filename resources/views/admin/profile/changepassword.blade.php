@extends('admin.index')

@section('breadcrumb')
	<ol class="breadcrumb bg-white m-0">
	    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Đổi mật khẩu</li>
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
                <h3 class="page-title">Đổi mật khẩu</h3>
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
                          <form action="{{ route('admin.profile.changePassword') }}" method="post">
                          	@csrf
                            <div class="form-group">
                              <label for="new_password">Mật khẩu mới:</label>
                              <input type="password" class="form-control @error('new_password')is-invalid @enderror" id="new_password" name="new_password"> 
                              @error('new_password')
                              	<div class="invalid-feedback">{{$message}}</div>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="confirm_new_password">Xác nhận mật khẩu mới:</label>
                              <input type="password" class="form-control @error('confirm_new_password')is-invalid @enderror" id="confirm_new_password" name="confirm_new_password"> 
                              @error('confirm_new_password')
                              	<div class="invalid-feedback">{{$message}}</div>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="current_password">Mật khẩu hiện tại:</label>
                              <input type="password" class="form-control @error('current_password')is-invalid @enderror" id="current_password" name="current_password"> 
                              @error('current_password')
                              	<div class="invalid-feedback">{{$message}}</div>
                              @enderror
                            </div>
                            <div class="text-center">
                            	<button type="submit" class="btn btn-accent">Cập nhật mật khẩu</button>
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