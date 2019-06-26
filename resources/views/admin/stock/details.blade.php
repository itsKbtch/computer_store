@extends('admin.index')
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
                        <div class="detail col-12 row">
                          <div class="form-group col-md-2">
                            <input type="text" class="form-control" value="{{$detail['name']}}" readonly>
                          </div>
                          <div class="form-group col-md-9">
                            <input type="text" class="form-control" value="{{$detail['value']}}"readonly>
                          </div>
                        </div>
                      @endforeach
                    @endif
                  </div>
                  <strong class="text-muted d-block my-2">Danh mục</strong>
                  
                  <div class="row">
                    <div class="form-group col-12 mb-1">
                      <label>Danh mục chính:</label>
                    </div>
                    <div class="col-6 mb-4">
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
                    <div class="col-6 mb-4">
                        <ul class="list-group">
                            @foreach ($product->categories as $category)
                                @if (!empty($category->parent_id))
                                <li class="list-group-item px-3 py-1">{{$category->name}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-12 text-center">
                        <div class="btn-group">
                            <a class="btn btn-warning btn-sm" href="{{route('admin.stock.edit', [$product->id])}}"><i class="fas fa-pencil-alt"></i></a>
                            <button class="btn btn-danger btn-sm" type="button"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <script>
            var details = 0;

            function deleteDetail(detail) {
              $(detail).parents('.detail').remove();
            }

            $(function() {
              $('.mainCategory:checked').each(function() {
                $('.subCategory[parent=' + $(this).val() + ']').prop('disabled', false);
              });

              $('#addDetail').on('click', function() {
                $(this).parent().before('<div class="detail col-12 row"><div class="form-group col-md-2"><input type="text" class="form-control" name="newDetails[' + details + '][name]" placeholder="Tên thông số"></div><div class="form-group col-md-9"><input type="text" class="form-control" name="newDetails[' + details + '][value]" placeholder="Giá trị"></div><div class="form-group col-md-1 text-muted"><button type="button" class="btn btn-light" onclick="deleteDetail(this)"><i class="fas fa-times"></i></button></div></div>');
                details++;
              });

              $('.mainCategory').on('change', function() {
                $('.subCategory').prop('disabled', true);
                $('.mainCategory:checked').each(function() {
                  $('.subCategory[parent=' + $(this).val() + ']').prop('disabled', false);
                });
              });

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