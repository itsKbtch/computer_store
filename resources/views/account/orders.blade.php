@extends('account.index')

@section('main')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <i class="fa fa-info mx-2"></i>
          {{session('success')}}
        </div>
    @endif

    @if (session('fail'))
      <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <i class="fa fa-info mx-2"></i>
        {{session('fail')}}
      </div>    
    @endif
    
	  <div class="card">
        <div class="card-header">Đơn hàng</div>

        <div class="card-body p-0">
            <table class="table table-responsive-sm mb-0 table-hover">
              <thead class="bg-dark text-white">
                <tr class="text-center">
                  <th scope="col" class="border-0 align-middle text-center">Mã</th>
                  <th scope="col" class="border-0 align-middle text-center">Giá trị</th>
                  <th scope="col" class="border-0 align-middle text-center">Tình trạng</th>
                  <th scope="col" class="border-0 align-middle text-center">Ngày tạo</th>
                  <th scope="col" class="border-0 align-middle text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $points = 0;
                @endphp
                @forelse ($invoices as $invoice)
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
                      <div class="button-group">
                          <a class="btn btn-info btn-sm" href="{{ route('account.orders.details', [$invoice->id]) }}" title="Chi tiết">Chi tiết</a>
                          @if ($invoice->status == 0)
                            <button class="btn btn-danger btn-sm" title="Hủy" onclick="if (confirm('Bạn có chắc muốn hủy đơn hàng này?')) {document.getElementById('cancelOrder').submit();}">Hủy</button>
                            <form action="{{ route('account.orders.cancel', [$invoice->id]) }}" method="post" id="cancelOrder" style="display: none">
                              @csrf
                            </form>
                          @endif
                      </div>
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
@endsection