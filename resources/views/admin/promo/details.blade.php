@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.promo.index') }}">Khuyến mại</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$promo->id}}</li>
    <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
  </ol>
@endsection

@section('content')
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
                    <div class="row">
                      <div class="form-group col-12">
                        <label for="name">Tên chương trình:</label>
                        <input type="text" class="form-control" value="{{$promo->name}}" disabled>
                      </div>
                      <div class="form-group col-12">
                        <label for="content">Nội dung chương trình:</label>
                        <textarea name="content" rows="5" id="content" class="form-control" disabled>{{$promo->content}}</textarea>
                      </div>
                      <div class="form-group col-12">
                        <label for="end_time">Thơi gian kết thúc:</label>
                        <input type="datetime-local" class="form-control" id="discounttime" name="end_time" value="{{!empty($promo->end_time)? date("Y-m-d\TH:i", strtotime($promo->end_time)):''}}" disabled>
                      </div>
                      <div class="col-12">
                        <label>Sản phẩm áp dụng: </label>
                      </div>
                      <div class="col-12 mb-3">
                        <div class="list-group-item m-0 p-0" style="max-height: 400px; min-height: 200px; overflow: auto;">
                          <ul class="list-group" id="productsList">
                            @forelse ($promo->products as $product)
                              <li class="px-2 py-1 text-truncate border-top-0 border-left-0 border-right-0 border-bottom product" title="{{$product->name}}">
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
                          <input type="checkbox" class="form-control custom-control-input" id="active" name="active" value=1{{$promo->active? ' checked':''}} disabled>
                          <label class="custom-control-label" for="active">Active</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-12 text-center">
                          <div class="btn-group">
                              <a class="btn btn-warning btn-sm" href="{{route('admin.promo.edit', [$promo->id])}}"><i class="fas fa-pencil-alt"></i></a>
                              <button class="btn btn-danger btn-sm" onclick="destroy('{{ route('admin.promo.delete', [$promo->id]) }}')"><i class="fas fa-trash-alt"></i></button>
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
                    window.location.href = "{{ route('admin.promo.index') }}";
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