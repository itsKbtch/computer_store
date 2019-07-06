@extends('admin.index')

@section('breadcrumb')
  <ol class="breadcrumb bg-white m-0">
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.home.index') }}">Trang chủ</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.invoice.index') }}">Thành viên</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{$user->id}}</li>
    <li class="breadcrumb-item active" aria-current="page">Thông tin</li>
  </ol>
@endsection

@section('content')
          <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
              <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                <span class="text-uppercase page-subtitle">Thông tin</span>
                <h3 class="page-title">Thành viên</h3>
              </div>
            </div>
            <!-- End Page Header -->
            
            <div class="row">
              <div class="col-lg-6">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    Thông tin thành viên
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Mã thành viên: </div>
                      <div class="font-weight-normal text-right">{{$user->user_id}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Tên: </div>
                      <div class="font-weight-normal text-right">{{$user->name}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">SĐT: </div>
                      <div class="font-weight-normal text-right">{{$user->phone_number}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Địa chỉ: </div>
                      <div class="font-weight-normal text-right">{{$user->address}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Email: </div>
                      <div class="font-weight-normal text-right">{{$user->email}}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                      <div class="text-nowrap">Ngày tham gia: </div>
                      <div class="font-weight-normal text-right">{{$user->created_at}}</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 mb-4">
                <div class="card card-small">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Đơn mua hàng</h6>
                  </div>
                  <div class="card-body p-0">
                    <table class="table table-responsive-sm mb-0 table-hover">
                      <thead class="bg-secondary text-white">
                        <tr class="text-center">
                          <th scope="col" class="border-0 align-middle">Mã</th>
                          <th scope="col" class="border-0 align-middle">Giá trị</th>
                          <th scope="col" class="border-0 align-middle">Tình trạng</th>
                          <th scope="col" class="border-0 align-middle">Ngày tạo</th>
                          <th scope="col" class="border-0 align-middle">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $points = 0;
                        @endphp
                        @forelse ($user->invoices as $invoice)
                          <tr class="text-center">
                            <td class="align-middle">{{$invoice->id}}</td>
                            <td class="align-middle">{{number_format($invoice->total_with_discount)}} VNĐ</td>
                            <td class="align-middle">
                              @switch($invoice->status)
                                  @case(0)
                                      <span class="text-primary">Đang chờ</span>
                                      @break
                          
                                  @case(1)
                                      <span class="text-success">Thành công</span>
                                      @break
                          
                                  @case(2)
                                      <span class="text-black-50">Hủy</span>
                                      @break

                                  @case(3)
                                      <span class="text-warning">Xác nhận</span>
                                      @break
                              
                                  @default
                                      <span class="text-primary">Đang chờ</span>
                              @endswitch
                            </td>
                            <td class="align-middle">{{$invoice->created_at}}</td>
                            <td class="align-middle">
                              <a class="btn btn-info btn-sm" href="{{ route('admin.invoice.details', [$invoice->id]) }}" title="Chi tiết"><i class="fas fa-info-circle"></i></a>
                            </td>
                          </tr>
                          @php
                            if ($invoice->status == 1) {
                              $points = $points + $invoice->total_with_discount;
                            }
                          @endphp
                        @empty
                          <tr>
                            <td colspan=4>Chưa có đơn hàng nào</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                  <div class="card-body border-top d-flex justify-content-between">
                    <div class="text-nowrap">Tích điểm: </div>
                    <div class="font-weight-normal text-right">{{number_format($points)}} VNĐ</div>
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