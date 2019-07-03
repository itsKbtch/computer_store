@extends('admin.index')
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
          
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Thêm mới</span>
                <h3 class="page-title">Khuyến mại</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <form action="{{route('admin.promo.store')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                        <div class="form-group col-12">
                          <label for="name">Tên chương trình:</label>
                          <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name" value="{{old('name')}}">
                          @error('name')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-12">
                          <label for="content">Nội dung chương trình:</label>
                          <textarea name="content" rows="5" id="content" class="form-control @error('content')is-invalid @enderror">{{old('content')}}</textarea>
                          @error('content')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-12">
                          <label for="end_time">Thơi gian kết thúc:</label>
                          <input type="datetime-local" class="form-control @error('end_time')is-invalid @enderror" id="discounttime" name="end_time" value="{{old('end_time')}}">
                          @error('end_time')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-12">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="form-control custom-control-input" id="active" name="active" value=1{{old('active')? ' checked':''}}>
                            <label class="custom-control-label" for="active">Active</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection