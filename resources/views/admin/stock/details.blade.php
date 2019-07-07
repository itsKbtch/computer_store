@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.stock.index') }}">Kho hàng</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$product->id}}</li>
    <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
  </ol>
@endsection

@section('content')
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Chi tiết</span>
                <h3 class="page-title">Kho hàng</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                  <strong class="text-muted d-block my-2">Thông tin chung</strong>
                  <div class="row">
                    <div class="form-group col-12">
                      <label for="name">Tên sản phẩm:</label>
                      <input type="text" class="form-control" value="{{$product->name}}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="price">Giá (VNĐ):</label>
                      <input type="number" class="form-control" value="{{$product->price}}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="warranty">Bảo Hành:</label>
                      <input type="number" class="form-control" value="{{$product->warranty}}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="in_stock">Tồn kho:</label>
                      <input type="number" class="form-control" value="{{$product->in_stock}}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="status">Tình trạng:</label>
                      <select id="inputState" class="form-control" readonly disabled>
                        <option value=0 disabled{{empty($product->status)? '':' selected'}}>Chọn</option>
                        <option value=1{{$product->status == 1? ' selected':''}}>Còn hàng</option>
                        <option value=2{{$product->status == 2? ' selected':''}}>Hết hàng</option>
                        <option value=3{{$product->status == 3? ' selected':''}}>Sắp về</option>
                      </select>
                    </div>
                    <div class="form-group col-12">
                      <label for="description">Mô tả chung:</label>
                      <textarea rows="5" class="form-control" readonly>{{$product->description}}</textarea>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="col-12">Ảnh: </label>
                            @if ($product->photos->isEmpty())
                            <div class="col-12">
                              Không có ảnh
                            </div>
                            @else
                                @foreach ($product->photos as $photo)
                                    <div class="col-md-6 col-lg-4 col-xl-3 delPhotoBox" style="position: relative">
                                        <img class="d-inline img-thumbnail border border-secondary" src="{{asset('storage/product/'.$photo->name)}}" alt="{{$photo->name}}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-12">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="form-control custom-control-input" value=1 {{$product->active? 'checked':''}} readonly>
                        <label class="custom-control-label" for="active">Active</label>
                      </div>
                    </div>
                  </div>
                  <strong class="text-muted d-block my-2">Chiết khấu</strong>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="discount">Lượng chiết khấu:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <select class="form-control" readonly disabled>
                            <option value='percent'{{!empty($product->discount_percent)? ' selected':''}}>%</option>
                            <option value='cash'{{!empty($product->discount_cash)? ' selected':''}}>VNĐ</option>
                          </select>
                        </div>
                        <input type="number" class="form-control" value="{{!empty($product->discount_percent)? $product->discount_percent:''}}{{!empty($product->discount_cash)? $product->discount_cash:''}}" readonly>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="discounttime">Thơi gian kết thúc:</label>
                      <input type="datetime-local" class="form-control" value="{{!empty($product->discount_end_time)? date("Y-m-d\TH:i", strtotime($product->discount_end_time)):''}}" readonly>
                    </div>
                  </div>
                  <strong class="text-muted d-block my-2">Thông tin chi tiết</strong>
                  <div class="row">
                    @if (!$product->details->isEmpty())
                      @foreach ($product->details as $key => $detail)
                        <div class="form-group col-md-2">
                          <input type="text" class="form-control" value="{{$detail['name']}}" readonly>
                        </div>
                        <div class="form-group col-md-10">
                          <input type="text" class="form-control" value="{{$detail['value']}}"readonly>
                        </div>
                        <div class="form-group col-12 d-md-none border-bottom"></div>
                      @endforeach
                    @endif
                  </div>
                  <strong class="text-muted d-block my-2">Danh mục</strong>
                  
                  <div class="row">
                    <div class="form-group col-12 mb-1">
                      <label>Danh mục chính:</label>
                    </div>
                    <div class="col-12 mb-4">
                        <ul class="list-group">
                        @foreach ($product->categories as $category)
                          @if (empty($category->parent_id))
                            <li class="list-group-item px-3 py-1">{{$category->name}}</li>
                          @endif
                        @endforeach
                        </ul>
                    </div>
                    
                    <div class="form-group col-12 mb-1">
                        <label>Danh mục con:</label>
                    </div>
                    <div class="col-12 mb-4">
                        <ul class="list-group">
                            @foreach ($product->categories as $category)
                                @if (!empty($category->parent_id))
                                <li class="list-group-item px-3 py-1">{{$category->name}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                  </div>

                  <strong class="text-muted d-block my-2">Promotions</strong>

                  <div class="row">
                    <div class="col-12 mb-4">
                        <ul class="list-group">
                          @forelse ($product->promotion as $promo)
                            <li class="list-group-item px-3 py-1">{{$promo->name}}</li>
                          @empty
                          Không có chương trình nào áp dụng
                          @endforelse
                        </ul>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-12 text-center">
                        <div class="btn-group">
                            <a class="btn btn-warning btn-sm" href="{{route('admin.stock.edit', [$product->id])}}"><i class="fas fa-pencil-alt"></i></a>
                            <button class="btn btn-danger btn-sm" onclick="destroy('{{ route('admin.stock.delete', [$product->id]) }}')" title="{{$product->invoices_count > 0? " Không thể xóa do đã có đơn hàng":" Xóa"}}"{{$product->invoices_count > 0? " disabled":""}}><i class="fas fa-trash-alt"></i></button>
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
                    window.location.href = "{{ route('admin.stock.index') }}";
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