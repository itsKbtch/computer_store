@extends('admin.index')
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
                <span class="text-uppercase page-subtitle">Thêm mới</span>
                <h3 class="page-title">Khuyến mại</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <form action="{{route('admin.promo.update', [$promo->id])}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                        <div class="form-group col-12">
                          <label for="name">Tên chương trình:</label>
                          <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name" value="{{old('name')? old('name'):$promo->name}}">
                          @error('name')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-12">
                          <label for="content">Nội dung chương trình:</label>
                          <textarea name="content" rows="5" id="content" class="form-control @error('content')is-invalid @enderror">{{old('content')? old('content'):$promo->content}}</textarea>
                          @error('content')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-12">
                          <label for="end_time">Thơi gian kết thúc:</label>
                          <input type="datetime-local" class="form-control @error('end_time')is-invalid @enderror" id="discounttime" name="end_time" value="{{old('end_time')? old('end_time'):date("Y-m-d\TH:i", strtotime($promo->end_time))}}">
                          @error('end_time')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="col-12">
                          <label>Sản phẩm áp dụng: </label>
                        </div>
                        <div class="col-12 mb-3">
                          <div class="list-group-item m-0 p-0" style="max-height: 400px; min-height: 200px; overflow: auto;">
                            <ul class="list-group" id="productsList">
                              @forelse ($promo->products as $product)
                                <li class="m-0 p-0 text-truncate border-top-0 border-left-0 border-right-0 border-bottom product" title="{{$product->name}}">
                                  <a href="{{ route('admin.promo.update.unapply', [$promo->id, $product->id]) }}" onclick="return confirm('Bạn có chắc muốn ngừng áp dụng khuyến mại cho sản phẩm này?')" class="btn btn-light mr-1" id="" title="Ngừng áp dụng cho sản phẩm này"><i class="fas fa-times"></i></a>
                                  <small>{{$product->name}}</small>
                                </li>
                              @empty
                                <li class="my-1 mx-2 p-0 text-truncate border-top-0 border-left-0 border-right-0 border-bottom-0">
                                  Chưa có sản phẩm nào được áp dụng
                                </li>
                              @endforelse
                            </ul>
                          </div>
                        </div>
                        <div class="form-group col-12">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="form-control custom-control-input" id="active" name="active" value=1{{old('active')? ' checked':$promo->active? ' checked':''}}>
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