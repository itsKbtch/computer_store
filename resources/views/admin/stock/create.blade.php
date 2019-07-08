@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.stock.index') }}">Kho hàng</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
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
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Thêm mới</span>
                <h3 class="page-title">Kho hàng</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-12">
                <div class="card mb-4">
                  <div class="card-body">
                    <form action="{{route('admin.stock.store')}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                      @csrf
                      <strong class="text-muted d-block my-2">Thông tin chung</strong>
                      <div class="row">
                        <div class="form-group col-12">
                          <label for="name">Tên sản phẩm:</label>
                          <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name" value="{{old('name')}}">
                          @error('name')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-md-6">
                          <label for="price">Giá (VNĐ):</label>
                          <input type="number" class="form-control @error('price')is-invalid @enderror" id="price" name="price" value="{{old('price')}}">
                          @error('price')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-md-6">
                          <label for="warranty">Bảo Hành:</label>
                          <input type="number" class="form-control @error('warranty')is-invalid @enderror" id="warranty" name="warranty" value="{{old('warranty')}}">
                          @error('warranty')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-md-6">
                          <label for="in_stock">Tồn kho:</label>
                          <input type="number" class="form-control @error('in_stock')is-invalid @enderror" id="in_stock" name="in_stock" value="{{old('in_stock')}}">
                          @error('in_stock')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-md-6">
                          <label for="status">Tình trạng:</label>
                          <select id="inputState" class="form-control @error('status')is-invalid @enderror" name="status">
                            <option value=0 disabled{{old('status')? '':' selected'}}>Chọn</option>
                            <option value=1{{old('status') == 1? ' selected':''}}>Còn hàng</option>
                            <option value=2{{old('status') == 2? ' selected':''}}>Hết hàng</option>
                            <option value=3{{old('status') == 3? ' selected':''}}>Sắp về</option>
                          </select>
                          @error('status')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-12">
                          <label for="description">Mô tả chung:</label>
                          <textarea name="description" rows="5" id="description" class="form-control @error('description')is-invalid @enderror">{{old('description')}}</textarea>
                          @error('description')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-md-6">
                          <label for="photos">Ảnh:</label>
                          <input type="file" class="form-control @error('photos')is-invalid @enderror @error('photos.*')is-invalid @enderror" id="photos" name="photos[]" multiple>
                          @error('photos')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                          @error('photos.*')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                        <div class="form-group col-12">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="form-control custom-control-input" id="active" name="active" value=1 {{old('active')? 'checked':''}}>
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
                          <input type="datetime-local" class="form-control @error('discount_end_time')is-invalid @enderror" id="discounttime" name="discount_end_time" value="{{old('discount_end_time')}}">
                          @error('discount_end_time')
                              <div class="invalid-feedback">{{$message}}</div>
                          @enderror
                        </div>
                      </div>
                      <strong class="text-muted d-block my-2">Thông tin chi tiết</strong>
                      <div class="row">
                        
                        @if (old('details'))
                          @foreach (old('details') as $key => $detail)
                            <div class="detail col-12 row">
                              <div class="form-group col-md-2">
                                <input type="text" class="form-control @error('details.'.$key.'.name')is-invalid @enderror" name="details[{{$key}}][name]" value="{{$detail['name']}}" placeholder="Tên thông số">
                                @error('details.'.$key.'.name')
                                  <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                              </div>
                              <div class="form-group col-md-9">
                                <input type="text" class="form-control @error('details.'.$key.'.value')is-invalid @enderror" name="details[{{$key}}][value]" value="{{$detail['value']}}" placeholder="Giá trị">
                                @error('details.'.$key.'.value')
                                  <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                              </div>
                              <div class="form-group col-md-1 text-muted">
                                <button type="button" class="btn btn-light" onclick="deleteDetail(this)"><i class="fas fa-times"></i></button>
                              </div>
                            </div>
                          @endforeach
                        @endif
                        <div class="form-group col-12">
                          <button type="button" class="btn btn-secondary" id="addDetail">Thêm thông số kĩ thuật</button>
                        </div>
                      </div>

                      <strong class="text-muted d-block my-2">Danh mục</strong>
                      
                      <div class="row">
                        <div class="form-group col-12 mb-1">
                          <label>Danh mục chính: </label>
                          <span class="font-weight-normal font-italic" style="font-size: 0.9em; margin-left: 5px">Hãy chọn danh mục chính</span>
                        </div>
                        @forelse ($categories as $category)
                          @if (empty($category->parent_id))
                            <div class="form-group col-md-6 col-lg-4 col-xl-3">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-control custom-control-input mainCategory" id="id{{$category->id}}" name="categories[]" value={{$category->id}}{{in_array($category->id, is_array(old('categories'))? old('categories'):[])? ' checked':''}}>
                                <label class="custom-control-label" for="id{{$category->id}}">{{$category->name}}</label>
                              </div>
                            </div>
                          @endif
                        @empty
                          <div class="form-group col-12">
                            Không có dữ liệu
                          </div>
                        @endforelse

                        <div class="row col-12 subCategories">
                          <div class="form-group col-12 mb-1">
                            <label>Danh mục con:</label>
                          </div>
                          @forelse ($categories as $category)
                            @if (!empty($category->parent_id))
                              <div class="form-group col-md-6 col-lg-4 col-xl-3">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="form-control custom-control-input subCategory" parent={{$category->parent_id}} id="id{{$category->id}}" name="categories[]" value={{$category->id}} disabled{{in_array($category->id, is_array(old('categories'))? old('categories'):[])? ' checked':''}}>
                                  <label class="custom-control-label" for="id{{$category->id}}">{{$category->name}}</label>
                                </div>
                              </div>
                            @endif
                          @empty
                            <div class="form-group col-12">
                              Không có dữ liệu
                            </div>
                          @endforelse
                        </div>
                        @error('categories')
                          <div class="form-group col-12">
                            <div class="custom-control-input is-invalid"></div>
                            <div class="invalid-feedback">{{$message}}</div>
                          </div>
                        @enderror
                        @error('categories.*')
                          <div class="form-group col-12">
                            <div class="custom-control-input is-invalid"></div>
                            <div class="invalid-feedback">{{$message}}</div>
                          </div>
                        @enderror

                        <div class="form-group col-12 mt-1">
                          <a class="font-weight-normal font-italic text-black-50" id="addCategory" href="{{route('admin.category.index')}}" onclick="return confirm('Bạn có chắc muốn chuyển sang trang quản lí không? Dữ liệu bạn đã điền sẽ bị mất.');">Quản lí danh mục</a>
                        </div>
                      </div>

                      <strong class="text-muted d-block my-2">Promotions</strong>

                      <div class="row">
                        <div class="row col-12">
                          @forelse ($promos as $promo)
                            <div class="form-group col-12">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-control custom-control-input" id="pr{{$promo->id}}" name="promos[]" value={{$promo->id}}{{in_array($promo->id, is_array(old('promos'))? old('promos'):[])? ' checked':''}}>
                                <label class="custom-control-label" for="pr{{$promo->id}}">{{$promo->name}}</label>
                              </div>
                            </div>
                          @empty
                            <div class="form-group col-12">
                              Không có dữ liệu
                            </div>
                          @endforelse
                        </div>
                        @error('promos')
                          <div class="form-group col-12">
                            <div class="custom-control-input is-invalid"></div>
                            <div class="invalid-feedback">{{$message}}</div>
                          </div>
                        @enderror
                        @error('promos.*')
                          <div class="form-group col-12">
                            <div class="custom-control-input is-invalid"></div>
                            <div class="invalid-feedback">{{$message}}</div>
                          </div>
                        @enderror

                        <div class="form-group col-12 mt-1">
                          <a class="font-weight-normal font-italic text-black-50" id="addCategory" href="{{route('admin.promo.index')}}" onclick="return confirm('Bạn có chắc muốn chuyển sang trang quản lí không? Dữ liệu bạn đã điền sẽ bị mất.');">Quản lí khuyến mại</a>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12 text-center">
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
            var details = {{old('details')? count(old('details')):0}};

            function deleteDetail(detail) {
              $(detail).parents('.detail').remove();
            }

            $(function() {
              $('.mainCategory:checked').each(function() {
                $('.subCategory[parent=' + $(this).val() + ']').prop('disabled', false);
              });

              $('#addDetail').on('click', function() {
                $(this).parent().before('<div class="detail col-12 row"><div class="form-group col-md-2"><input type="text" class="form-control" name="details[' + details + '][name]" placeholder="Tên thông số"></div><div class="form-group col-md-9"><input type="text" class="form-control" name="details[' + details + '][value]" placeholder="Giá trị"></div><div class="form-group col-md-1 text-muted"><button type="button" class="btn btn-light" onclick="deleteDetail(this)"><i class="fas fa-times"></i></button></div></div>');
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