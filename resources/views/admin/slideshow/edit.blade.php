@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.slideshow.index') }}">Slideshow</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$slideshow->id}}</li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
  </ol>
@endsection

@section('content')
          @if (session('fail'))
          <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-info mx-2"></i>
            {{session('fail')}}
          </div>    
          @endif
          @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-info mx-2"></i>
            {{session('success')}}
          </div>
          @endif
          
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Chỉnh sửa</span>
                <h3 class="page-title">Slide</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <form action="{{route('admin.slideshow.update', [$slideshow->id])}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                        <div class="form-group col-12">
                          <label for="caption">Caption:</label>
                          <input type="text" class="form-control @error('caption')is-invalid @enderror" id="caption" name="caption" value="{{$slideshow->caption}}">
                          @error('caption')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        
                        <div class="form-group col-12">
                          <label for="link">Link:</label>
                          <input type="text" class="form-control @error('link')is-invalid @enderror" id="link" name="link" value="{{$slideshow->link}}">
                          @error('link')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        
                        <div class="form-group col-12">
                          <label>Ảnh:</label><br>
                          <img class="img-thumbnail border border-secondary" src="{{asset('storage/slide/'.$slideshow->photo)}}" alt="{{$slideshow->photo}}" width="500px">
                        </div>
                          
                        <div class="form-group col-12">
                          <label for="photo">Ảnh mới:</label>
                          <input type="file" class="form-control @error('photo')is-invalid @enderror" id="photo" name="photo">
                          @error('photo')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        <div class="form-group col-12">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="form-control custom-control-input" id="active" name="active" value=1{{$slideshow->active? ' checked':''}}>
                            <label class="custom-control-label" for="active">Active</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection