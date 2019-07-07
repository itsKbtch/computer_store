@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.invoice.index') }}">Đơn hàng</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$invoice->id}}</li>
    <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
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
          @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-info mx-2"></i>
            {{session('success')}}
          </div>
          @endif

          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Chi tiết</span>
                <h3 class="page-title">Đơn hàng</h3>
              </div>
            </div>
            <!-- End Page Header -->
            
            <div class="row">
              <div class="col-lg-4">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    Thông tin đơn hàng
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Mã đơn hàng: </div>
                      <div class="font-weight-normal text-right">{{$invoice->id}}</div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                      <div class="text-nowrap">Tổng: </div>
                      <div class="font-weight-normal">{{number_format($invoice->total)}} VNĐ</div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                      <div class="text-nowrap">Chiết khấu: </div>
                      <div class="font-weight-normal text-right">{{!empty($invoice->discount_percent)? '- '.$invoice->discount_percent.'%':(!empty($invoice->discount_cash)? '- '.number_format($invoice->discount_cash).' VNĐ':'')}}</div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                      <div class="text-nowrap">Thành tiền: </div>
                      <div class="font-weight-normal text-right">{{number_format($invoice->total_with_discount)}} VNĐ</div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                      <div class="text-nowrap">Tình trạng: </div>
                      <div class="font-weight-normal text-right">
                        <form class="statusChange" action="{{ route('admin.invoice.changeStatus', [$invoice->id]) }}" method="post">
                          @csrf
                          <select class="status form-control{{$invoice->status == 1? " text-success":($invoice->status == 2? " text-black-50":($invoice->status == 3? " text-warning":" text-primary"))}}" name="status" style="width: 120px" onchange="if (confirm('Bạn có chắc muốn thay đổi?')) {$(this).parent('.statusChange').submit();} else {$(this).children('.selected').prop('selected', true)}"{{$invoice->status == 1? " disabled":""}}>
                            <option class="text-primary{{$invoice->status == 0? " selected":""}}" value=0{{$invoice->status == 0? " selected":""}}>Đang chờ</option>
                            <option class="text-warning{{$invoice->status == 3? " selected":""}}" value=3{{$invoice->status == 3? " selected":""}}>Xác nhận</option>
                            <option class="text-success{{$invoice->status == 1? " selected":""}}" value=1{{$invoice->status == 1? " selected":""}}>Thành công</option>
                            <option class="text-black-50{{$invoice->status == 2? " selected":""}}" value=2{{$invoice->status == 2? " selected":""}}>Hủy</option>
                          </select>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    Thông tin khách hàng
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Tên: </div>
                      <div class="font-weight-normal text-right">{{$invoice->name}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">SĐT: </div>
                      <div class="font-weight-normal text-right">{{$invoice->phone_number}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Địa chỉ: </div>
                      <div class="font-weight-normal text-right">{{$invoice->address}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Email: </div>
                      <div class="font-weight-normal text-right">{{$invoice->email}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Mã thành viên: </div>
                      <div class="font-weight-normal text-right">{{$invoice->user_id}}</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-8 mb-4">
                <div class="card card-small">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Sản phẩm</h6>
                  </div>
                  <div class="card-body p-0 pb-2">
                    <table class="table table-responsive mb-0 table-hover">
                      <thead class="bg-secondary text-white">
                        <tr class="text-center">
                          <th scope="col" class="border-0 align-middle">Mã</th>
                          <th scope="col" class="border-0 align-middle">Ảnh</th>
                          <th scope="col" class="border-0 align-middle">Tên</th>
                          <th scope="col" class="border-0 align-middle">Số lượng</th>
                          <th scope="col" class="border-0 align-middle">Đơn giá</th>
                          <th scope="col" class="border-0 align-middle">Thành tiền</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($invoice->items as $item)
                          @php
                            $price = $item->price;
                          @endphp
                          <tr class="text-center">
                            <td class="align-middle">{{$item->id}}</td>
                            <td class="align-middle">
                              <img src="{{!$item->photos->isEmpty()? asset('storage/product/'.$item->photos[0]->name):''}}" alt="{{$item->name}}" width="200px">
                            </td>
                            <td class="align-middle"><a href="{{ route('admin.stock.details', [$item->id]) }}">{{$item->name}}</a></td>
                            <td class="align-middle">{{$item->pivot->quantity}}</td>
                            <td class="align-middle">
                              <span style="{{!empty($item->pivot->discount_percent) || !empty($item->pivot->discount_cash)?'text-decoration: line-through':''}}">{{number_format($item->price)}} VNĐ</span>

                                @if (!empty($item->pivot->discount_percent))
                                  @php
                                    $price = $item->price - $item->price*$item->pivot->discount_percent/100;
                                  @endphp
                                  <br>
                                  <span>
                                    <span class="badge badge-pill badge-primary">giảm {{$item->pivot->discount_percent}}%</span><br>
                                    {{number_format($price)}} VNĐ
                                  </span>
                                @endif
                                @if (!empty($item->pivot->discount_cash))
                                  @php
                                    $price = $item->price - $item->pivot->discount_cash;
                                  @endphp
                                  <br>
                                  <span>
                                    <span class="badge badge-pill badge-primary">giảm {{$item->pivot->discount_cash}} VNĐ</span><br> 
                                    {{number_format($price)}} VNĐ
                                  </span>
                                @endif
                            </td>
                            <td class="align-middle">{{number_format($price*$item->pivot->quantity)}} VNĐ</td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan=5>Không có dữ liệu</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-12 mb-4 text-center">
                <div class="btn-group">
                  <button class="btn btn-danger btn-sm" onclick="destroy('{{ route('admin.invoice.delete', [$invoice->id]) }}')" title="Xóa"><i class="fas fa-trash-alt"></i></button>
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
                    window.location.href = "{{route('admin.invoice.index')}}";
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