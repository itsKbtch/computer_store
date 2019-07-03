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
                <h3 class="page-title">Mã giảm giá</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <form action="{{route('admin.code.store')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                        <div class="form-group col-12">
                          <label for="active_code">Mã:</label>
                          <input type="text" class="form-control @error('active_code')is-invalid @enderror" id="active_code" name="active_code" value="{{old('active_code')}}">
                          @error('active_code')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                          <label for="discount">Lượng chiết khấu:</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <select class="form-control" name="discount_type" id="discount_type">
                                <option value='percent'{{old('discount_percent')? ' selected':''}}>%</option>
                                <option value='cash'{{old('discount_cash')? ' selected':''}}>VNĐ</option>
                              </select>
                            </div>
                            <input type="number" class="form-control @error('discount_percent')is-invalid @enderror  @error('discount_cash')is-invalid @enderror" id="discount" name="{{old('discount_cash')? 'discount_cash':'discount_percent'}}" value="{{old('discount_percent')}}{{old('discount_cash')}}">
                            @error('discount_percent')
                              <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                            @error('discount_cash')
                              <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="discounttime">Thơi gian kết thúc:</label>
                          <input type="datetime-local" class="form-control @error('end_time')is-invalid @enderror" id="discounttime" name="end_time" value="{{old('end_time')}}">
                          @error('end_time')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>

                        <div class="form-group col-12">
                          <label for="quantity">Số lượng:</label>
                          <input type="number" class="form-control @error('quantity')is-invalid @enderror" id="quantity" name="quantity" value="{{old('quantity')}}">
                          @error('quantity')
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
          <script>
            $(function() {
              $('#discount_type').on('change', function() {
                if($('#discount_type').val() == 'percent') {
                  $('#discount').attr('name', 'discount_percent');
                } else {
                  $('#discount').attr('name', 'discount_cash');
                }
              });
            });
          </script>
@endsection