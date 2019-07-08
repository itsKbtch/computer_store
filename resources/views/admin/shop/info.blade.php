@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thông tin cửa hàng</li>
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
                <span class="text-uppercase page-subtitle">Chỉnh sửa</span>
                <h3 class="page-title">Thông tin cửa hàng</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <form action="{{route('admin.shop.update')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                        <div class="form-group col-12">
                          <label for="about">Giới thiệu về cửa hàng:</label>
                          <textarea name="about" rows="5" id="about" class="form-control @error('about')is-invalid @enderror">{{!empty($info)? $info->about: ''}}</textarea>
                          @error('about')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        <div class="form-group col-12">
                          <label for="phone_number">Số điện thoại:</label>
                          <input type="text" class="form-control @error('phone_number')is-invalid @enderror" id="phone_number" name="phone_number" value="{{!empty($info)? $info->phone_number: ''}}">
                          @error('phone_number')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        <div class="form-group col-12">
                          <label for="email">Email:</label>
                          <input type="email" class="form-control @error('email')is-invalid @enderror" id="email" name="email" value="{{!empty($info)? $info->email: ''}}">
                          @error('email')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        
                        <div class="form-group col-12">
                          <label for="address">Địa chỉ:</label>
                          <input type="text" class="form-control @error('address')is-invalid @enderror" id="address" name="address" value="{{!empty($info)? $info->address: ''}}">
                          @error('address')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        <div class="form-group col-12">
                          <label for="facebook">Facebook link:</label>
                          <input type="text" class="form-control @error('facebook')is-invalid @enderror" id="facebook" name="facebook" value="{{!empty($info)? $info->facebook: ''}}">
                          @error('facebook')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        <div class="form-group col-12">
                          <label for="open_time">Thời gian mở cửa:</label>
                          <input type="text" class="form-control @error('open_time')is-invalid @enderror" id="open_time" name="open_time" value="{{!empty($info)? $info->open_time: ''}}">
                          @error('open_time')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection