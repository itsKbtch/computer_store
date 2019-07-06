@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item active" aria-current="page">Kho hàng</li>
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
          <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
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
                <span class="text-uppercase page-subtitle">Trang chính</span>
                <h3 class="page-title">Kho hàng</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-xl-7 col-lg-8 col-md-12">
                <div class="btn-group mb-4">
                  <a class="btn btn-primary" href="{{route('admin.stock.create')}}">
                    Thêm mới
                  </a>
                  <button class="btn btn-danger" onclick="destroyMany()">
                    Xóa
                  </button>
                </div>
                <div class="btn-group mb-4">
                  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#filters" aria-expanded="false" aria-controls="filters">
                    Bộ lọc
                  </button>
                </div>
                <div class="btn-group mb-4">
                  <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="font-weight-bold">Sắp xếp:</span>
                    @if (isset($_GET['sort']))
                        @if ($_GET['sort'] == "new")
                        Mới nhất
                        @endif
                        @if ($_GET['sort'] == "old")
                        Cũ nhất
                        @endif
                        @if ($_GET['sort'] == "priceAsc")
                        Giá thấp đến cao
                        @endif
                        @if ($_GET['sort'] == "priceDesc")
                        Giá cao đến thấp
                        @endif
                    @else
                    Mới nhất    
                    @endif
                  </button>
                  <div class="dropdown-menu">
                    <button class="dropdown-item sort" value="new">Mới nhất</button>
                    <button class="dropdown-item sort" value="old">Cũ nhất</button>
                    <button class="dropdown-item sort" value="priceAsc">Giá thấp đến cao</button>
                    <button class="dropdown-item sort" value="priceDesc">Giá cao đến thấp</button>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3 col-xl-5 col-lg-4 col-md-12">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" id="keyword" class="form-control" placeholder="search" aria-label="search" value="{{isset($_GET['keyword'])? $_GET['keyword']:''}}"> 
              </div>
            </div>
            
            <div class="collapse mb-4" id="filters">
              <div class="card card-body">
                <div class="row">
                  <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                    <h5 class="card-title">
                      Tình trạng
                    </h5>
                    <div class="custom-control custom-checkbox mb-1">
                      <input type="checkbox" class="custom-control-input filter" name="status%5B%5D" value=1 id="con" {{(isset($_GET['status']) && in_array(1, $_GET['status']))? 'checked':''}}><label class="custom-control-label" for="con">Còn hàng</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-1">
                      <input type="checkbox" class="custom-control-input filter" name="status%5B%5D" value=2 id="het" {{(isset($_GET['status']) && in_array(2, $_GET['status']))? 'checked':''}}><label class="custom-control-label" for="het">Hết hàng</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-1">
                      <input type="checkbox" class="custom-control-input filter" name="status%5B%5D" value=3 id="sap" {{(isset($_GET['status']) && in_array(3, $_GET['status']))? 'checked':''}}><label class="custom-control-label" for="sap">Sắp về</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-1">
                      <input type="checkbox" class="custom-control-input filter" name="filters%5B%5D" value="discount" id="discount" {{(isset($_GET['filters']) && in_array('discount', $_GET['filters']))? 'checked':''}}><label class="custom-control-label" for="discount">Có chiết khấu</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-1">
                      <input type="checkbox" class="custom-control-input filter" name="filters%5B%5D" value="promoted" id="promoted" {{(isset($_GET['filters']) && in_array('promoted', $_GET['filters']))? 'checked':''}}><label class="custom-control-label" for="promoted">Có khuyến mại</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-1">
                      <input type="checkbox" class="custom-control-input filter" name="filters%5B%5D" value="active" id="active" {{(isset($_GET['filters']) && in_array('active', $_GET['filters']))? 'checked':''}}><label class="custom-control-label" for="active">active</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-1">
                      <input type="checkbox" class="custom-control-input filter" name="filters%5B%5D" value="inactive" id="inactive" {{(isset($_GET['filters']) && in_array('inactive', $_GET['filters']))? 'checked':''}}><label class="custom-control-label" for="inactive">inactive</label>
                    </div>
                  </div>
                  <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                    <h5 class="card-title">
                      Danh mục chính
                    </h5>
                    @foreach ($mainCategories as $mainCategory)
                      <div class="custom-control custom-checkbox mb-1">
                        <input type="checkbox" class="custom-control-input filter" name="category%5B%5D" value={{$mainCategory->id}} id="ct{{$mainCategory->id}}" {{(isset($_GET['category']) && in_array($mainCategory->id, $_GET['category']))? 'checked':''}}>
                        <label class="custom-control-label" for="ct{{$mainCategory->id}}">{{$mainCategory->name}}</label>
                      </div>
                    @endforeach
                  </div>
                  <div class="col-xl-6 col-sm-12">
                      <h5 class="card-title">
                        Danh mục con
                      </h5>
                      <div class="row col-12">
                        @foreach ($subCategories as $subCategory)
                          <div class="custom-control custom-checkbox mb-1 col-lg-4 col-md-6">
                            <input type="checkbox" class="custom-control-input filter" name="category%5B%5D" value={{$subCategory->id}} id="ct{{$subCategory->id}}" {{(isset($_GET['category']) && in_array($subCategory->id, $_GET['category']))? 'checked':''}}>
                            <label class="custom-control-label" for="ct{{$subCategory->id}}">{{$subCategory->name}}</label>
                          </div>
                        @endforeach
                      </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="custom-control custom-checkbox mb-3">
              <input type="checkbox" class="custom-control-input" name="" value="" id="all"><label class="custom-control-label" for="all">Chọn tất cả</label>
            </div>
            <div class="row">
              @forelse ($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                  <div class="card card-small card-post card-post--1">
                  <div class="card-post__image p-2 d-flex justify-content-end align-items-start flex-wrap" style="background-image: url('{{!$product->photos->isEmpty()? asset('storage/product/'.$product->photos[0]->name):''}}');">
                      @if ($product->status == 1)
                        <a href="#" class="badge badge-pill badge-primary text-uppercase mr-1">Còn hàng</a>
                      @endif
                      @if ($product->status == 2)
                        <a href="#" class="badge badge-pill badge-danger text-uppercase mr-1">Hết hàng</a>
                      @endif
                      @if ($product->status == 3)
                        <a href="#" class="badge badge-pill badge-info text-uppercase mr-1">Sắp về</a>
                      @endif
                      
                      @if (!empty($product->discount_percent))
                        <a href="#" class="badge badge-pill badge-warning text-uppercase mr-1">giảm {{$product->discount_percent}}%</a>
                      @endif
                      @if (!empty($product->discount_cash))
                        <a href="#" class="badge badge-pill badge-warning text-uppercase mr-1">giảm {{number_format($product->discount_cash)}}</a>
                      @endif
                      <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input multi-choice" name="id[]" value={{$product->id}} id="pd{{$product->id}}"><label class="custom-control-label" for="pd{{$product->id}}"></label>
                      </div>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">
                        <a class="text-fiord-blue" href="{{route('admin.stock.details', [$product->id])}}">{{$product->name}}</a>
                      </h5>
                      <div class=""><span class="font-weight-bold">Giá: </span>{{number_format($product->price)}}VNĐ</div>
                      <div class=""><span class="font-weight-bold">Tồn kho: </span>{{number_format($product->in_stock)}}</div>
                      <div class=""><span class="font-weight-bold">Ngày thêm: </span>{{$product->created_at}}</div>
                      <div class="btn-group mt-4">
                        <a class="btn btn-info btn-sm" href="{{route('admin.stock.edit', [$product->id])}}" title="Chỉnh sửa"><i class="fas fa-pencil-alt"></i></a>
                        <button class="btn btn-danger btn-sm" onclick="destroy('{{ route('admin.stock.delete', [$product->id]) }}')" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                      </div>
                    </div>
                  </div>    
                </div>
              @empty
                <div class="col-12">
                  <h5>Không có dữ liệu</h5>
                </div>
              @endforelse
            </div>
          </div>

          <div class="d-flex justify-content-center">
            {{$products->links()}}
          </div>

          <script type="text/javascript">
            var checkedAll = false;
            var filters = [];
            var sort = "{{(isset($_GET['sort']))? $_GET['sort']:''}}";
            var keyword = "{{(isset($_GET['keyword']))? $_GET['keyword']:''}}";
      
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
                    window.location.reload();
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

            function destroyMany() {
                if ($('.multi-choice:checked').length == 0) {
                  alert('Chưa có sản phẩm nào được chọn');
                  return false;
                }

                if(!confirm("Bạn có chắc chắn xóa?")) {
                  return false;
                }

                var data = new FormData();

                $('.multi-choice:checked').each(function() {
                  data.append('id[]', $(this).val());
                });

                $.ajax({
                  url: "{{route('admin.stock.deleteMany')}}",
                  method: "post",
                  processData: false,
                  contentType: false,
                  headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                  },
                  data: data,
                  success: function(result) {
                    if(result.status == "success") {
                      alert("Xóa thành công");
                      window.location.reload();
                    }
                    else {
                      if (result.status == 'fail') {
                        alert("Xóa thất bại");
                      } 
                    }
                  },
                  error: function(error) {
                    console.log(error);
                  }
                });
            }

            function selectCard(checkbox) {
              var card = checkbox.parents('.card');
              if (card.hasClass('selected')) {
                card.removeClass('selected');
              } else {
                card.addClass('selected');
              }
              if (checkedAll) {
                checkedAll = false;
                $("#all").prop("checked", false);
              }
            }
      
            function selectAll() {
              checkboxes = $('.multi-choice');
      
              if (checkedAll) {
                checkboxes.each(function() {
                  $(this).prop("checked", false);
                  var card = $(this).parents('.card');
                  card.removeClass('selected');
                });
                checkedAll = false;
              } else {
                checkboxes.each(function() {
                  $(this).prop("checked", true);
                  var card = $(this).parents('.card');
                  card.addClass('selected');
                });
                checkedAll = true;
              }
            }

            function filter() {
              var url = "?";

              if (keyword != "") {
                url = url + "keyword=" + keyword;
                if (filters.length > 0 || sort != "") {
                  url = url + "&";
                }
              }

              $.each(filters, function(index, val) {
                url = url + val;
                if (index < filters.length-1) {
                  url = url + "&";
                }
              });

              if (filters.length > 0) {
                url = url + "&";
              }
              
              if (sort != "") {
                url = url + "sort=" + sort;
              }

              if (filters.length > 0 && sort == "") {
                url = url.substr(0, url.length-1);
              }
              
              window.location.href = url;
            }
      
            $(function() {
              $(".multi-choice").on("click", function() {
                selectCard($(this));
              });
              $("#all").on("click", function() {
                selectAll();
              });
              $(".filter").on('change', function() {
                $('.filter:checked').each(function() {
                  filters.push($(this).attr('name') + "=" + $(this).val());
                });
                filter();
              });
              $(".sort").on('click', function() {
                sort = $(this).attr('value');
                $('.filter:checked').each(function() {
                  filters.push($(this).attr('name') + "=" + $(this).val());
                });
                filter();
              });
              $("#keyword").on('keyup', function(event) {
                  if (event.keyCode == 13) {
                      keyword = $('#keyword').val();
                      filter();
                  }
              });
            })
          </script>
@endsection