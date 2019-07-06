@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.promo.index') }}">Khuyến mại</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$promo->id}}</li>
    <li class="breadcrumb-item active" aria-current="page">Áp dụng</li>
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

          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-0">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Áp dụng</span>
                <h3 class="page-title">Khuyến mại</h3>
              </div>
            </div>
            <!-- End Page Header -->
            
            <div class="row">
              <div class="col-12">
                  <h5 class="mb-4">Áp dụng khuyến mãi: {{$promo->name}}</h5>
              </div>
              <div class="col-lg-6">
                <div class="card mb-4">
                  <div class="input-group mt-4 mb-3 col-12">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" id="keyword" class="form-control" placeholder="search" aria-label="search"> 
                  </div>
                  <div class="mb-3 col-12">
                    <button type="button" class="btn btn-light mr-1" onclick="addAll()"><i class="fas fa-plus"></i> Thêm tất cả</button>
                  </div>
                  <div class="col-12 mb-3">
                    <div class="list-group-item m-0 p-0" style="max-height: 400px; min-height: 200px; overflow: auto;">
                      <ul class="list-group" id="productsList">
                        @forelse ($products as $product)
                          <li class="m-0 p-0 text-truncate border-top-0 border-left-0 border-right-0 border-bottom product" title="{{$product->name}}">
                            <button type="button" class="btn btn-light mr-1 add" id="add{{$product->id}}"><i class="fas fa-plus"></i></button>
                            <small>{{$product->name}}</small>
                            <input type="hidden" name='products[]' value={{$product->id}}>
                          </li>
                        @empty
                          <li class="my-1 mx-2 p-0 text-truncate border-top-0 border-left-0 border-right-0 border-bottom-0">
                            Không có sản phẩm nào để áp dụng
                          </li>
                        @endforelse
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 mb-4">
                <div class="card">
                  <form action="{{route('admin.promo.apply', [$promo->id])}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mt-3 mb-3 pb-2 col-12 border-bottom">
                      Sản phẩm đã thêm
                    </div>
                    <div class="mb-3 col-12">
                      <button type="button" class="btn btn-light mr-1" onclick="removeAll()"><i class="fas fa-times"></i> Xóa tất cả</button>
                    </div>
                    <div class="col-12 mb-3">
                      <div class="list-group-item m-0 p-0" style="max-height: 400px; min-height: 200px; overflow: auto;">
                        <ul class="list-group" id="chosenProducts">
                        </ul>
                      </div>
                    </div>
                    <div class="col-12 mb-3 text-center">
                      <button type="submit" class="btn btn-primary">Áp dụng</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <script type="text/javascript">
            function remove(button, add) {
              $(button).parent('.product').remove();
              $('#' + add).prop('disabled', false);
            }

            function add(button) {
              $(button).prop('disabled', true);
              var product = $(button).parents('.product').clone();
              var add = product.children('.add').attr('id');
              product.children('.add').remove();
              product.prepend('<button type="button" class="btn btn-light mr-1 remove" onclick="remove(this, \'' + add + '\')"><i class="fas fa-times"></i></button>');
              product.appendTo('#chosenProducts');
            }

            function addAll() {
              $('#productsList').children('.product').each(function() {
                if ($(this).children('.add').prop('disabled') != true) {
                  add($(this).children('.add'));
                }
              });
            }

            function removeAll() {
              $('#chosenProducts').children('.product').each(function() {
                $(this).children('.remove').trigger('click');
              });
            }

            $(function() {
              $('.add').on('click', function() {
                add(this);
              });
              $('#keyword').on('keyup', function() {
                var keyword = $(this).val();
                $('#productsList .product').each(function() {
                  var name = $(this).attr('title');
                  if (name.match(RegExp(keyword, 'gi')) != null) {
                    $(this).removeClass('d-none');
                  } else {
                    $(this).addClass('d-none');
                  }
                });
              });
            })
          </script>
@endsection