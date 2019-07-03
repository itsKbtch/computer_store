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
                <span class="text-uppercase page-subtitle">Chi tiết</span>
                <h3 class="page-title">Mã giảm giá</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="row">
                      <div class="form-group col-12">
                        <label for="active_code">Mã:</label>
                        <input type="text" class="form-control" value="{{$code->active_code}}" disabled="">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="discount">Lượng chiết khấu:</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <select class="form-control" disabled>
                              <option value='percent'{{!empty($code->discount_percent)? ' selected':''}}>%</option>
                              <option value='cash'{{!empty($code->discount_cash)? ' selected':''}}>VNĐ</option>
                            </select>
                          </div>
                          <input type="number" class="form-control" value="{{!empty($code->discount_percent)? $code->discount_percent:''}}{{!empty($code->discount_cash)? $code->discount_cash:''}}" disabled>
                        </div>
                      </div>

                      <div class="form-group col-md-6">
                        <label for="discounttime">Thơi gian kết thúc:</label>
                        <input type="datetime-local" class="form-control" value="{{!empty($code->end_time)? date("Y-m-d\TH:i", strtotime($code->end_time)):''}}" disabled>
                      </div>

                      <div class="form-group col-12">
                        <label for="quantity">Số lượng:</label>
                        <input type="number" class="form-control" value="{{$code->quantity}}" disabled>
                      </div>

                      <div class="form-group col-12">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="form-control custom-control-input" id="active" name="active" value=1{{$code->active? ' checked':''}} readonly disabled>
                          <label class="custom-control-label" for="active">Active</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-12 text-center">
                        <div class="btn-group">
                          <a class="btn btn-warning btn-sm" href="{{route('admin.code.edit', [$code->id])}}"><i class="fas fa-pencil-alt"></i></a>
                          <button class="btn btn-danger btn-sm" onclick="destroy('{{ route('admin.code.delete', [$code->id]) }}')"><i class="fas fa-trash-alt"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <script>
            function destroy(url) {
              if(!confirm("Bạn có chắc chắn xóa?")) {
                return false;
              }
              
              $.ajax({
                url: url,
                type: "DELETE",
                data: {
                  "_token" : '{{csrf_token()}}', 
                  "_method" : "DELETE"
                },
                success: function(result) {
                  if(result.status == "success") {
                    alert("Xóa thành công");
                    window.location.href = '{{ route('admin.code.index') }}';
                  }
                  else {
                    alert("Xóa thất bại");
                  }
                },
                error: function(error) {
                  console.log(error);
                }
              });
            }
          </script>
@endsection