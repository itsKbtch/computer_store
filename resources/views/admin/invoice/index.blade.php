@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item active" aria-current="page">Đơn hàng</li>
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
                <span class="text-uppercase page-subtitle">Trang chính</span>
                <h3 class="page-title">Đơn hàng</h3>
              </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
              <div class="col-xl-7 col-lg-8 col-md-12">
                <div class="btn-group mb-4">
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
                        @if ($_GET['sort'] == "total-desc")
                        Giá trị giảm dần
                        @endif
                        @if ($_GET['sort'] == "total-asc")
                        Giá trị tăng dần
                        @endif
                    @else
                        Mới nhất
                    @endif
                  </button>
                  <div class="dropdown-menu">
                    <button class="dropdown-item sort" value="new">Mới nhất</button>
                    <button class="dropdown-item sort" value="old">Cũ nhất</button>
                    <button class="dropdown-item sort" value="total-desc">Giá trị giảm dần</button>
                    <button class="dropdown-item sort" value="total-asc">Giá trị tăng dần</button>
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
                  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-2">
                    <h5 class="card-title">
                      Tình trạng
                    </h5>
                    <div class="custom-control custom-checkbox mb-1">
                      <input type="checkbox" class="custom-control-input filter" name="filters%5B%5D" value="success" id="success" {{(isset($_GET['filters']) && in_array('success', $_GET['filters']))? 'checked':''}}><label class="custom-control-label" for="success">Thành công</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-1">
                      <input type="checkbox" class="custom-control-input filter" name="filters%5B%5D" value="canceled" id="canceled" {{(isset($_GET['filters']) && in_array('canceled', $_GET['filters']))? 'checked':''}}><label class="custom-control-label" for="canceled">Hủy</label>
                    </div>
                    <div class="custom-control custom-checkbox mb-1">
                      <input type="checkbox" class="custom-control-input filter" name="filters%5B%5D" value="waiting" id="waiting" {{(isset($_GET['filters']) && in_array('waiting', $_GET['filters']))? 'checked':''}}><label class="custom-control-label" for="waiting">Đang chờ</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="custom-control custom-checkbox mb-3">
              <input type="checkbox" class="custom-control-input" name="" value="" id="all"><label class="custom-control-label" for="all">Chọn tất cả</label>
            </div>
            <div class="row">
              <div class="col">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Đơn hàng</h6>
                  </div>
                  <div class="card-body p-0 pb-2">
                    <table class="table table-responsive-lg mb-0 table-hover">
                      <thead class="bg-secondary text-white">
                        <tr>
                          <th scope="col" class="border-0 align-middle"><i class="material-icons">check_box</i></th>
                          <th scope="col" class="border-0 align-middle">Mã</th>
                          <th scope="col" class="border-0 align-middle">Tên khách hàng</th>
                          <th scope="col" class="border-0 align-middle">SĐT</th>
                          <th scope="col" class="border-0 align-middle">Thành tiền</th>
                          <th scope="col" class="border-0 align-middle">Tình trạng</th>
                          <th scope="col" class="border-0 align-middle">Ngày tạo</th>
                          <th scope="col" class="border-0 align-middle">Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                      	@forelse ($invoices as $invoice)
                      	<tr class="item">
                          <td class="align-middle">
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input multi-choice" name="id[]" value={{$invoice->id}} id="iv{{$invoice->id}}"><label class="custom-control-label" for="iv{{$invoice->id}}"></label>
                            </div>
                          </td>
                          <td class="align-middle">{{$invoice->id}}</td>
                          <td class="align-middle">{{$invoice->name}}</td>
                          <td class="align-middle">{{$invoice->phone_number}}</td>
                          <td class="align-middle">{{number_format($invoice->total_with_discount)}} VNĐ</td>
                          <td class="align-middle">
                            <form class="statusChange" action="{{ route('admin.invoice.changeStatus', [$invoice->id]) }}" method="post">
                              @csrf
                              <select class="status form-control{{$invoice->status == 1? " text-success":($invoice->status == 2? " text-black-50":($invoice->status == 3? " text-warning":" text-primary"))}}" name="status" style="width: 120px" onchange="if (confirm('Bạn có chắc muốn thay đổi?')) {$(this).parent('.statusChange').submit();} else {$(this).children('.selected').prop('selected', true)}">
                                <option class="text-primary{{$invoice->status == 0? " selected":""}}" value=0{{$invoice->status == 0? " selected":""}}>Đang chờ</option>
                                <option class="text-warning{{$invoice->status == 3? " selected":""}}" value=3{{$invoice->status == 3? " selected":""}}>Xác nhận</option>
                                <option class="text-success{{$invoice->status == 1? " selected":""}}" value=1{{$invoice->status == 1? " selected":""}}>Thành công</option>
                                <option class="text-black-50{{$invoice->status == 2? " selected":""}}" value=2{{$invoice->status == 2? " selected":""}}>Hủy</option>
                              </select>
                            </form>
                          </td>
                          <td class="align-middle">{{$invoice->created_at}}</td>
                          <td class="align-middle">
                            <div class="btn-group">
                              <a class="btn btn-info btn-sm" href="{{ route('admin.invoice.details', [$invoice->id]) }}" title="Chi tiết"><i class="fas fa-info-circle"></i></a>
                              <button class="btn btn-danger btn-sm" onclick="destroy('{{ route('admin.invoice.delete', [$invoice->id]) }}')" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                            </div>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan=7>Không có dữ liệu</td>
                        </tr>
                      	@endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-center">
            {{$invoices->links()}}
          </div>

          <script>
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
                  alert('Chưa có mã nào được chọn');
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
                  url: "{{route('admin.invoice.deleteMany')}}",
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
              var card = checkbox.parents('.item');
              if (card.hasClass('bg-light')) {
                card.removeClass('bg-light');
              } else {
                card.addClass('bg-light');
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
                  var card = $(this).parents('.item');
                  card.removeClass('bg-light');
                });
                checkedAll = false;
              } else {
                checkboxes.each(function() {
                  $(this).prop("checked", true);
                  var card = $(this).parents('.item');
                  card.addClass('bg-light');
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